<?php

namespace App\Http\Controllers;

use App\Models\Iqamat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IqamatController extends Controller
{
    public function index(Request $request)
    {
        $iqamats = Iqamat::all();

        if ($request->user()) {
            // Admin view
            return Inertia::render('Shalat/Iqamat/Index', [
                'iqamats' => $iqamats,
            ]);
        } else {
            // Guest view
            return Inertia::render('Iqamat/Index', [
                'iqamats' => $iqamats,
            ]);
        }
    }

    public function create()
    {
        return Inertia::render('Shalat/Iqamat/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waktu' => 'required|in:subuh,dzuhur,ashar,maghrib,isya',
            'teks_arab' => 'required|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
        ]);

        Iqamat::create($validated);

        return redirect()->route('iqamat.index')
            ->with('success', 'Iqamat created successfully.');
    }

    public function edit(Iqamat $iqamat)
    {
        return Inertia::render('Shalat/Iqamat/Edit', [
            'iqamat' => $iqamat,
        ]);
    }

    public function update(Request $request, Iqamat $iqamat)
    {
        $validated = $request->validate([
            'waktu' => 'required|in:subuh,dzuhur,ashar,maghrib,isya',
            'teks_arab' => 'required|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
        ]);

        $iqamat->update($validated);

        return redirect()->route('iqamat.index')
            ->with('success', 'Iqamat updated successfully.');
    }

    public function destroy(Iqamat $iqamat)
    {
        $iqamat->delete();

        return redirect()->route('iqamat.index')
            ->with('success', 'Iqamat deleted successfully.');
    }

    public function show($waktu)
    {
        $iqamat = Iqamat::where('waktu', $waktu)->firstOrFail();

        return Inertia::render('Iqamat/Show', [
            'iqamat' => $iqamat,
        ]);
    }
}
