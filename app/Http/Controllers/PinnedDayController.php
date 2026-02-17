<?php

namespace App\Http\Controllers;

use App\Models\PinnedDay;
use Illuminate\Http\Request;

class PinnedDayController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->query('year', 0);
        $month = (int) $request->query('month', 0);

        $rows = PinnedDay::query()
            ->when($year > 0, fn ($q) => $q->where('year', $year))
            ->when($month > 0, fn ($q) => $q->where('month', $month))
            ->orderBy('year')
            ->orderBy('month')
            ->orderBy('day')
            ->get();

        return response()->json(['data' => $rows]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:1200|max:2000',
            'month' => 'required|integer|min:1|max:12',
            'day' => 'required|integer|min:1|max:30',
            'note' => 'nullable|string|max:1000',
        ]);

        $row = PinnedDay::updateOrCreate(
            [
                'year' => $validated['year'],
                'month' => $validated['month'],
                'day' => $validated['day'],
            ],
            [
                'note' => $validated['note'] ?? null,
            ]
        );

        return response()->json([
            'message' => 'Pinned day saved.',
            'data' => $row,
        ]);
    }

    public function destroy(PinnedDay $pinnedDay)
    {
        $pinnedDay->delete();

        return response()->json([
            'message' => 'Pinned day deleted.',
        ]);
    }
}
