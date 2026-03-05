<?php

namespace App\Http\Controllers;

use App\Models\DoaSetelahSholat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DoaSetelahSholatController extends Controller
{
    public function index(Request $request)
    {
        $doas = DoaSetelahSholat::all();

        if ($request->user()) {
            // Admin view
            return Inertia::render('Shalat/DoaSetelahSholat/Index', [
                'doas' => $doas,
            ]);
        } else {
            // Guest view
            return Inertia::render('DoaSetelahSholat/Index', [
                'doas' => $doas,
            ]);
        }
    }

    public function create()
    {
        return Inertia::render('Shalat/DoaSetelahSholat/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'teks_arab' => 'required|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
        ]);

        DoaSetelahSholat::create($validated);

        return redirect()->route('doa-setelah-sholat.index')
            ->with('success', 'Doa created successfully.');
    }

    public function edit(DoaSetelahSholat $doaSetelahSholat)
    {
        return Inertia::render('Shalat/DoaSetelahSholat/Edit', [
            'doa' => $doaSetelahSholat,
        ]);
    }

    public function update(Request $request, DoaSetelahSholat $doaSetelahSholat)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'teks_arab' => 'required|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
        ]);

        $doaSetelahSholat->update($validated);

        return redirect()->route('doa-setelah-sholat.index')
            ->with('success', 'Doa updated successfully.');
    }

    public function destroy(DoaSetelahSholat $doaSetelahSholat)
    {
        $doaSetelahSholat->delete();

        return redirect()->route('doa-setelah-sholat.index')
            ->with('success', 'Doa deleted successfully.');
    }

    public function show($id)
    {
        $doa = DoaSetelahSholat::findOrFail($id);

        return Inertia::render('DoaSetelahSholat/Show', [
            'doa' => $doa,
        ]);
    }
}
