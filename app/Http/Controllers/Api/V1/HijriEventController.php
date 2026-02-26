<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\HijriEvent;
use Illuminate\Http\Request;

class HijriEventController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get hijri calendar events
     */
    public function events(Request $request)
    {
        $year = $request->query('year');
        $month = $request->query('month');

        $query = HijriEvent::query();

        if ($year) {
            $query->whereYear('hijri_date', $year);
        }

        if ($month) {
            $query->whereMonth('hijri_date', $month);
        }

        $events = $query->get();

        return $this->response($events, 'Hijri events retrieved successfully');
    }

    /**
     * Get hijri calendar
     */
    public function calendar(Request $request)
    {
        $year = $request->query('year');
        $month = $request->query('month');

        $query = HijriEvent::query();

        if ($year) {
            $query->whereYear('hijri_date', $year);
        }

        if ($month) {
            $query->whereMonth('hijri_date', $month);
        }

        $events = $query->get();

        return $this->response([
            'year' => $year,
            'month' => $month,
            'events' => $events,
        ], 'Hijri calendar retrieved successfully');
    }
}
