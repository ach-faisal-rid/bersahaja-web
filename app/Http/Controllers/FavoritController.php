<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use App\Models\Hadist;
use App\Models\Doa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class FavoritController extends Controller
{
    public function index()
    {
        $favorits = Favorit::query()
            ->where('user_id', auth()->id())
            ->with('favoritable')
            ->latest()
            ->get()
            ->map(function (Favorit $favorit) {
                $title = $favorit->favoritable?->judul ?? '-';
                $type = $favorit->favoritable_type === Hadist::class ? 'hadist' : 'doa';

                return [
                    'id' => $favorit->id,
                    'favoritable_id' => $favorit->favoritable_id,
                    'favoritable_type' => $type,
                    'favoritable' => [
                        'id' => $favorit->favoritable_id,
                        'judul' => $title,
                    ],
                ];
            })
            ->values();

        return Inertia::render('favorite/Index', [
            'favorits' => $favorits,
        ]);
    }

    public function create()
    {
        $hadists = Hadist::query()
            ->select('id', 'judul')
            ->orderBy('judul')
            ->get();

        $doas = Doa::query()
            ->select('id', 'judul')
            ->orderBy('judul')
            ->get();

        return Inertia::render('favorite/Add', [
            'hadists' => $hadists,
            'doas' => $doas,
        ]);
    }

    public function add(Request $request)
    {
        [$favoritableType, $favoritableId] = $this->resolveFavoritablePayload($request);

        Favorit::firstOrCreate([
            'user_id' => auth()->id(),
            'favoritable_id' => $favoritableId,
            'favoritable_type' => $favoritableType,
        ]);

        return redirect()->back()->with('success', 'Favorit berhasil ditambahkan.');
    }

    public function remove(Request $request)
    {
        [$favoritableType, $favoritableId] = $this->resolveFavoritablePayload($request);

        Favorit::query()
            ->where('user_id', auth()->id())
            ->where('favoritable_id', $favoritableId)
            ->where('favoritable_type', $favoritableType)
            ->delete();

        return redirect()->back()->with('success', 'Favorit berhasil dihapus.');
    }

    public function user(User $user)
    {
        $favorits = Favorit::query()
            ->where('user_id', $user->id)
            ->with('favoritable')
            ->latest()
            ->get();

        return response()->json($favorits);
    }

    private function resolveFavoritablePayload(Request $request): array
    {
        if ($request->filled('hadist_id')) {
            $validated = $request->validate([
                'hadist_id' => ['required', 'integer', 'exists:hadists,id'],
            ]);

            return [Hadist::class, $validated['hadist_id']];
        }

        if ($request->filled('doa_id')) {
            $validated = $request->validate([
                'doa_id' => ['required', 'integer', 'exists:doas,id'],
            ]);

            return [Doa::class, $validated['doa_id']];
        }

        $validated = $request->validate([
            'favoritable_type' => ['required', 'string'],
            'favoritable_id' => ['required', 'integer'],
        ]);

        $normalizedType = match ($validated['favoritable_type']) {
            'hadist', Hadist::class => Hadist::class,
            'doa', Doa::class => Doa::class,
            default => null,
        };

        if (!$normalizedType) {
            throw ValidationException::withMessages([
                'favoritable_type' => 'Jenis favorit tidak valid.',
            ]);
        }

        if ($normalizedType === Hadist::class) {
            $request->validate([
                'favoritable_id' => ['exists:hadists,id'],
            ]);

            return [$normalizedType, $validated['favoritable_id']];
        }

        $request->validate([
            'favoritable_id' => ['exists:doas,id'],
        ]);

        return [$normalizedType, $validated['favoritable_id']];
    }
}
