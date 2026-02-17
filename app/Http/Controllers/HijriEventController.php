<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

use App\Models\HijriEvent;

class HijriEventController extends Controller
{
    protected array $g2hCache = [];

    /**
     * Display the Hijri calendar page.
     */
    public function index()
    {
        return Inertia::render('Hijri/Event/Index');
    }

    /**
     * Return Hijri events as JSON. Accepts optional ?year=&month=
     */
    public function events(Request $request)
    {
        $year = (int) $request->query('year', 0);
        $month = (int) $request->query('month', 0);

        if ($year <= 0 || $month <= 0) {
            $today = now();
            $h = $this->gregorianToHijriAccurate((int)$today->year, (int)$today->month, (int)$today->day);
            $year = $h['year'];
            $month = $h['month'];
        }

        $events = HijriEvent::where('year', $year)
            ->where('month', $month)
            ->orderBy('day')
            ->get();

        $deduped = [];
        foreach ($events as $event) {
            $canonical = $this->canonicalHolidayKey((string) ($event->title ?? ''));
            if ($canonical === '') {
                continue;
            }

            // Collapse legacy duplicates in the same Hijri month.
            $key = "{$event->year}-{$event->month}-{$canonical}";
            if (!isset($deduped[$key])) {
                $deduped[$key] = $event;
                continue;
            }

            if ($this->storedEventPriority($event) > $this->storedEventPriority($deduped[$key])) {
                $deduped[$key] = $event;
            }
        }

        return response()->json([
            'year' => $year,
            'month' => $month,
            'data' => array_values($deduped),
        ]);
    }

    /**
     * Pull and merge external events from AlAdhan + libur.deno.dev by Gregorian periods.
     */
    public function fetchExternal(Request $request)
    {
        $periods = $request->input('periods', []);
        if (!is_array($periods) || empty($periods)) {
            return response()->json([
                'message' => 'Periods required.',
                'imported' => 0,
                'data' => [],
            ], 422);
        }

        $validPeriods = [];
        foreach ($periods as $period) {
            $gy = (int) data_get($period, 'year', 0);
            $gm = (int) data_get($period, 'month', 0);
            if ($gy < 1900 || $gy > 2100 || $gm < 1 || $gm > 12) {
                continue;
            }
            $validPeriods["{$gy}-{$gm}"] = ['year' => $gy, 'month' => $gm];
        }

        if (empty($validPeriods)) {
            return response()->json([
                'message' => 'No valid periods.',
                'imported' => 0,
                'data' => [],
            ], 422);
        }

        $mergedRows = [];
        try {
            foreach ($validPeriods as $period) {
                $aladhanRows = $this->fetchAladhanRows($period['year'], $period['month']);
                foreach ($aladhanRows as $row) {
                    $this->pushMergedRow($mergedRows, $row);
                }
            }

            $years = [];
            foreach ($validPeriods as $period) {
                $years[$period['year']] = true;
            }
            foreach (array_keys($years) as $year) {
                $liburRows = $this->fetchLiburRows((int) $year);
                foreach ($liburRows as $row) {
                    $this->pushMergedRow($mergedRows, $row);
                }
            }
        } catch (\Throwable $e) {
            // Keep endpoint resilient: offline/external API failures should not break local calendar reads.
            Log::warning('Hijri external sync failed', ['message' => $e->getMessage()]);
        }

        $upsertRows = array_values($mergedRows);
        if (!empty($upsertRows)) {
            HijriEvent::upsert(
                $upsertRows,
                ['year', 'month', 'day', 'title'],
                ['description', 'date_label', 'color_hex', 'icon_key', 'source', 'fetched_at', 'updated_at']
            );
        }

        return response()->json([
            'message' => 'External events synchronized.',
            'imported' => count($upsertRows),
            'data' => $upsertRows,
        ]);
    }

    // ---- helper conversion using AlAdhan API or simple tabular formula ----
    protected function gregorianToHijri(int $gy, int $gm, int $gd)
    {
        // Simple tabular Islamic calendar formula (N = day count formula)
        $N = $gd + 30 * ($gm - 1) + (int)floor(365.25 * ($gy - 1) - 46867);
        
        $q = (int)floor($N / 10631);
        $r = $N % 10631;
        $a = (int)floor($r / 325);
        $w = (int)floor(($r - $a * 325) / 30.4375);
        
        $hijriYear = 400 * $q + 30 * $a + $w;
        
        // Calculate month/day
        $dayInYear = $N - (int)floor((354 * $hijriYear + 30 * (int)floor((11 * $hijriYear + 3) / 30)) / 1);
        $hijriMonth = (int)floor((12 * ($dayInYear + 0.5)) / 354) % 12 + 1;
        $hijriDay = max(1, (int)floor($dayInYear - (int)floor((354 * $hijriMonth - 30) / 12)));
        
        return ['year' => max(1, $hijriYear), 'month' => $hijriMonth, 'day' => $hijriDay];
    }

    protected function gregorianToHijriAccurate(int $gy, int $gm, int $gd): array
    {
        $cacheKey = "{$gy}-{$gm}-{$gd}";
        if (isset($this->g2hCache[$cacheKey])) {
            return $this->g2hCache[$cacheKey];
        }

        $date = str_pad((string) $gd, 2, '0', STR_PAD_LEFT) . '-'
            . str_pad((string) $gm, 2, '0', STR_PAD_LEFT) . '-'
            . $gy;

        $response = Http::timeout(12)->acceptJson()->get("https://api.aladhan.com/v1/gToH/{$date}");
        if ($response->ok()) {
            $hy = (int) $response->json('data.hijri.year', 0);
            $hm = (int) $response->json('data.hijri.month.number', 0);
            $hd = (int) $response->json('data.hijri.day', 0);
            if ($hy > 0 && $hm > 0 && $hd > 0) {
                $result = ['year' => $hy, 'month' => $hm, 'day' => $hd];
                $this->g2hCache[$cacheKey] = $result;
                return $result;
            }
        }

        $fallback = $this->gregorianToHijri($gy, $gm, $gd);
        $this->g2hCache[$cacheKey] = $fallback;
        return $fallback;
    }

    protected function fetchAladhanRows(int $gregorianYear, int $gregorianMonth): array
    {
        $month = str_pad((string) $gregorianMonth, 2, '0', STR_PAD_LEFT);
        $url = "https://api.aladhan.com/v1/gToHCalendar/{$month}/{$gregorianYear}";

        $response = Http::timeout(12)->acceptJson()->get($url);
        if (!$response->ok()) {
            return [];
        }

        $rows = [];
        $data = $response->json('data');
        if (!is_array($data)) {
            return [];
        }

        foreach ($data as $item) {
            $hijri = data_get($item, 'hijri', []);
            $holidays = data_get($hijri, 'holidays', []);
            if (!is_array($holidays)) {
                $holidays = [];
            }

            $hy = (int) data_get($hijri, 'year', 0);
            $hm = (int) data_get($hijri, 'month.number', 0);
            $hd = (int) data_get($hijri, 'day', 0);
            if ($hy <= 0 || $hm <= 0 || $hd <= 0) {
                continue;
            }

            $gDate = data_get($item, 'gregorian.date', '');
            foreach ($holidays as $holidayTitle) {
                $title = trim((string) $holidayTitle);
                if ($title === '') {
                    continue;
                }

                $rows[] = $this->buildEventRow(
                    $hy,
                    $hm,
                    $hd,
                    $title,
                    'Kalender Hijriah (AlAdhan)',
                    $gDate,
                    'aladhan'
                );
            }

            // Ensure Ramadan start appears even when holiday labels are missing.
            if ($hm === 9 && $hd === 1) {
                $rows[] = $this->buildEventRow(
                    $hy,
                    $hm,
                    $hd,
                    'Awal Ramadhan',
                    'Mulai puasa Ramadhan',
                    $gDate,
                    'aladhan'
                );
            }
        }

        return $rows;
    }

    protected function fetchLiburRows(int $gregorianYear): array
    {
        $url = "https://libur.deno.dev/api?year={$gregorianYear}";
        $response = Http::timeout(12)->acceptJson()->get($url);
        if (!$response->ok()) {
            return [];
        }

        $data = $response->json();
        if (!is_array($data)) {
            return [];
        }

        $rows = [];
        foreach ($data as $holiday) {
            $isNational = (bool) data_get($holiday, 'is_national_holiday', false);
            if (!$isNational) {
                continue;
            }

            $date = (string) data_get($holiday, 'holiday_date', '');
            $title = trim((string) data_get($holiday, 'holiday_name', ''));
            if ($date === '' || $title === '') {
                continue;
            }

            $parts = explode('-', $date);
            if (count($parts) !== 3) {
                continue;
            }
            $gy = (int) $parts[0];
            $gm = (int) $parts[1];
            $gd = (int) $parts[2];
            if ($gy <= 0 || $gm <= 0 || $gd <= 0) {
                continue;
            }

            $hijri = $this->gregorianToHijriAccurate($gy, $gm, $gd);
            $hy = (int) data_get($hijri, 'year', 0);
            $hm = (int) data_get($hijri, 'month', 0);
            $hd = (int) data_get($hijri, 'day', 0);
            if ($hy <= 0 || $hm <= 0 || $hd <= 0) {
                continue;
            }

            $rows[] = $this->buildEventRow(
                $hy,
                $hm,
                $hd,
                $title,
                'Libur nasional Indonesia',
                $date,
                'libur.deno.dev'
            );
        }

        return $rows;
    }

    protected function buildEventRow(
        int $year,
        int $month,
        int $day,
        string $title,
        string $description,
        string $dateLabel,
        string $source
    ): array {
        $now = now();

        return [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'title' => $title,
            'description' => $description,
            'date_label' => $dateLabel,
            'color_hex' => $source === 'libur.deno.dev' ? '#22c55e' : '#0ea5e9',
            'icon_key' => $source === 'libur.deno.dev' ? 'flag' : 'moon',
            'source' => $source,
            'fetched_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    protected function pushMergedRow(array &$buffer, array $row): void
    {
        $canonical = $this->canonicalHolidayKey((string) ($row['title'] ?? ''));
        if ($canonical === '') {
            return;
        }
        $key = "{$row['year']}-{$row['month']}-{$row['day']}-{$canonical}";

        if (!isset($buffer[$key])) {
            $buffer[$key] = $row;
            return;
        }

        // Keep the highest-priority wording/source for semantically same holiday.
        if ($this->eventPriority($row) > $this->eventPriority($buffer[$key])) {
            $buffer[$key] = $row;
        }
    }

    protected function eventPriority(array $row): int
    {
        $source = (string) ($row['source'] ?? '');
        $title = strtolower((string) ($row['title'] ?? ''));
        $score = 0;

        if ($source === 'libur.deno.dev') {
            $score += 100;
        }

        // Prefer Indonesian naming where available.
        if (str_contains($title, 'idul') || str_contains($title, 'tahun baru islam') || str_contains($title, 'maulid')) {
            $score += 20;
        }

        return $score;
    }

    protected function canonicalHolidayKey(string $title): string
    {
        $normalized = strtolower(trim($title));
        $normalized = preg_replace('/[^a-z0-9\s]/', ' ', $normalized) ?? '';
        $normalized = preg_replace('/\s+/', ' ', $normalized) ?? '';
        if ($normalized === '') {
            return '';
        }

        $aliases = [
            'eid al fitr' => 'eid_fitr',
            'eid ul fitr' => 'eid_fitr',
            'idul fitri' => 'eid_fitr',
            '1 syawal' => 'eid_fitr',
            'eid al adha' => 'eid_adha',
            'eid ul adha' => 'eid_adha',
            'idul adha' => 'eid_adha',
            'tahun baru islam' => 'islamic_new_year',
            'islamic new year' => 'islamic_new_year',
            'maulid nabi' => 'mawlid',
            'the prophets birthday' => 'mawlid',
            'ashura' => 'ashura',
            'asura' => 'ashura',
            'nuzulul quran' => 'nuzulul_quran',
        ];

        foreach ($aliases as $needle => $canonical) {
            if (str_contains($normalized, $needle)) {
                return $canonical;
            }
        }

        return str_replace(' ', '_', $normalized);
    }

    protected function storedEventPriority($event): int
    {
        $source = (string) ($event->source ?? '');
        $title = strtolower((string) ($event->title ?? ''));
        $dateLabel = (string) ($event->date_label ?? '');
        $score = 0;

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateLabel) === 1 || preg_match('/^\d{2}-\d{2}-\d{4}$/', $dateLabel) === 1) {
            $score += 120;
        }
        if ($source === 'libur.deno.dev') {
            $score += 90;
        } elseif ($source === 'aladhan') {
            $score += 70;
        } elseif ($source === 'external') {
            $score += 10;
        }

        if (str_contains($title, 'idul') || str_contains($title, 'ramadhan') || str_contains($title, 'ramadan')) {
            $score += 20;
        }

        if ($event->fetched_at) {
            $score += (int) $event->fetched_at->timestamp % 17;
        }

        return $score;
    }
}
