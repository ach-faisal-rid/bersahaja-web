<?php

namespace App\Http\Controllers;

use App\Models\Khutbah;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KhutbahController extends Controller
{
    public function index(Request $request)
    {
        $khutbahs = Khutbah::all();

        if ($request->user()) {
            // Admin view
            return Inertia::render('Shalat/Khutbah/Index', [
                'khutbahs' => $khutbahs,
            ]);
        } else {
            // Guest view
            return Inertia::render('Khutbah/Index', [
                'khutbahs' => $khutbahs,
            ]);
        }
    }

    public function create()
    {
        return Inertia::render('Shalat/Khutbah/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'teks_arab' => 'required|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
        ]);

        Khutbah::create($validated);

        return redirect()->route('khutbah.index')
            ->with('success', 'Khutbah created successfully.');
    }

    public function edit(Khutbah $khutbah)
    {
        return Inertia::render('Shalat/Khutbah/Edit', [
            'khutbah' => $khutbah,
        ]);
    }

    public function update(Request $request, Khutbah $khutbah)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'teks_arab' => 'required|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
        ]);

        $khutbah->update($validated);

        return redirect()->route('khutbah.index')
            ->with('success', 'Khutbah updated successfully.');
    }

    public function destroy(Khutbah $khutbah)
    {
        $khutbah->delete();

        return redirect()->route('khutbah.index')
            ->with('success', 'Khutbah deleted successfully.');
    }

    public function show($id)
    {
        $khutbah = Khutbah::findOrFail($id);

        return Inertia::render('Khutbah/Show', [
            'khutbah' => $khutbah,
        ]);
    }
}
