<?php

namespace App\Http\Controllers;

use App\Models\Adzan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdzanController extends Controller
{
    public function index(Request $request)
    {
        $adzans = Adzan::all();

        if ($request->user()) {
            // Admin view
            return Inertia::render('Shalat/Adzan/Index', [
                'adzans' => $adzans,
            ]);
        } else {
            // Guest view
            return Inertia::render('Adzan/Index', [
                'adzans' => $adzans,
            ]);
        }
    }

    public function create()
    {
        return Inertia::render('Shalat/Adzan/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waktu' => 'required|in:subuh,dzuhur,ashar,maghrib,isya',
            'teks_arab' => 'required|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
        ]);

        Adzan::create($validated);

        return redirect()->route('adzan.index')
            ->with('success', 'Adzan created successfully.');
    }

    public function edit(Adzan $adzan)
    {
        return Inertia::render('Shalat/Adzan/Edit', [
            'adzan' => $adzan,
        ]);
    }

    public function update(Request $request, Adzan $adzan)
    {
        $validated = $request->validate([
            'waktu' => 'required|in:subuh,dzuhur,ashar,maghrib,isya',
            'teks_arab' => 'required|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
        ]);

        $adzan->update($validated);

        return redirect()->route('adzan.index')
            ->with('success', 'Adzan updated successfully.');
    }

    public function destroy(Adzan $adzan)
    {
        $adzan->delete();

        return redirect()->route('adzan.index')
            ->with('success', 'Adzan deleted successfully.');
    }

    public function show($waktu)
    {
        $adzan = Adzan::where('waktu', $waktu)->firstOrFail();

        return Inertia::render('Adzan/Show', [
            'adzan' => $adzan,
        ]);
    }
}
