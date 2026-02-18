<?php

namespace App\Http\Controllers;

use App\Models\Wudu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WuduController extends Controller
{
    // menampilkan daftar langkah wudu
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $wudus = Wudu::query()
            ->when($search, function ($query, $search) {
                $query->where('nama_langkah', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->orderBy('urutan', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Shalat/Wudu/Index', [
            'wudus' => $wudus,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    // menampilkan form tambah langkah wudu
    public function create()
    {
        return Inertia::render('Shalat/Wudu/Create');
    }

    // menyimpan langkah wudu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_langkah' => 'required|string|max:255',
            'urutan' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'doa_arab' => 'nullable|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
            'tips_penting' => 'nullable|string',
        ]);

        Wudu::create($validated);

        return redirect()->route('wudu.index')
            ->with('success', 'Langkah Wudu created successfully.');
    }

    // menampilkan form edit langkah wudu
    public function edit(Wudu $wudu)
    {
        return Inertia::render('Shalat/Wudu/Edit', [
            'wudu' => $wudu,
        ]);
    }

    // memperbarui langkah wudu
    public function update(Request $request, Wudu $wudu)
    {
        $validated = $request->validate([
            'nama_langkah' => 'required|string|max:255',
            'urutan' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'doa_arab' => 'nullable|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
            'tips_penting' => 'nullable|string',
        ]);

        $wudu->update($validated);

        return redirect()->route('wudu.index')
            ->with('success', 'Langkah Wudu updated successfully.');
    }

    // menghapus langkah wudu
    public function destroy(Wudu $wudu)
    {
        $wudu->delete();

        return redirect()->route('wudu.index')
            ->with('success', 'Langkah Wudu deleted successfully.');
    }

    // menampilkan detail langkah wudu
    public function show(Wudu $wudu)
    {
        return Inertia::render('Shalat/Wudu/Show', [
            'wudu' => $wudu,
        ]);
    }
}
