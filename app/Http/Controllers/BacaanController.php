<?php

namespace App\Http\Controllers;

use App\Models\Bacaan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class BacaanController extends Controller
{
    // menampilkan daftar bacaan
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $bacaans = Bacaan::query()
            ->when($search, function ($query, $search) {
                $query->where('nama_bacaan', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Shalat/Bacaan/Index', [
            'bacaans' => $bacaans,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    // menampilkan form tambah bacaan
    public function create()
    {
        return Inertia::render('Shalat/Bacaan/Create');
    }

    // menyimpan bacaan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bacaan' => 'required|string|max:255',
            'bacaan_arab' => 'required|string',
            'transliterasi' => 'required|string',
            'terjemahan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|string|max:100',
        ]);

        Bacaan::create($validated);

        return redirect()->route('bacaan.index')
            ->with('success', 'Bacaan created successfully.');
    }

    // menampilkan form edit bacaan
    public function edit(Bacaan $bacaan)
    {
        return Inertia::render('Shalat/Bacaan/Edit', [
            'bacaan' => $bacaan,
        ]);
    }

    // memperbarui bacaan
    public function update(Request $request, Bacaan $bacaan)
    {
        $validated = $request->validate([
            'nama_bacaan' => 'required|string|max:255',
            'bacaan_arab' => 'required|string',
            'transliterasi' => 'required|string',
            'terjemahan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|string|max:100',
        ]);

        $bacaan->update($validated);

        return redirect()->route('bacaan.index')
            ->with('success', 'Bacaan updated successfully.');
    }

    // menghapus bacaan
    public function destroy(Bacaan $bacaan)
    {
        $bacaan->delete();

        return redirect()->route('bacaan.index')
            ->with('success', 'Bacaan deleted successfully.');
    }

    // menampilkan detail bacaan
    public function show(Bacaan $bacaan)
    {
        return Inertia::render('Shalat/Bacaan/Show', [
            'bacaan' => $bacaan,
        ]);
    }
}
