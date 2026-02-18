<?php

namespace App\Http\Controllers;

use App\Models\TataCara;
use App\Models\GerakanShalat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TataCaraController extends Controller
{
    // menampilkan daftar tata cara
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $tataCara = TataCara::with('gerakan')
            ->when($search, function ($query, $search) {
                $query->where('nama_langkah', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->orderBy('urutan', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Shalat/TataCara/Index', [
            'tataCara' => $tataCara,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    // menampilkan form tambah tata cara
    public function create()
    {
        return Inertia::render('Shalat/TataCara/Create', [
            'gerakans' => GerakanShalat::select('id', 'nama_gerakan')->orderBy('urutan_global')->get(),
        ]);
    }

    // menyimpan tata cara baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_langkah' => 'required|string|max:255',
            'urutan' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'gerakan_id' => 'nullable|exists:gerakan_shalats,id',
            'bacaan_arab' => 'nullable|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
        ]);

        TataCara::create($validated);

        return redirect()->route('tata-cara.index')
            ->with('success', 'Tata Cara created successfully.');
    }

    // menampilkan form edit tata cara
    public function edit(TataCara $tataCara)
    {
        return Inertia::render('Shalat/TataCara/Edit', [
            'tataCara' => $tataCara->load('gerakan'),
            'gerakans' => GerakanShalat::select('id', 'nama_gerakan')->orderBy('urutan_global')->get(),
        ]);
    }

    // memperbarui tata cara
    public function update(Request $request, TataCara $tataCara)
    {
        $validated = $request->validate([
            'nama_langkah' => 'required|string|max:255',
            'urutan' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'gerakan_id' => 'nullable|exists:gerakan_shalats,id',
            'bacaan_arab' => 'nullable|string',
            'transliterasi' => 'nullable|string',
            'terjemahan' => 'nullable|string',
        ]);

        $tataCara->update($validated);

        return redirect()->route('tata-cara.index')
            ->with('success', 'Tata Cara updated successfully.');
    }

    // menghapus tata cara
    public function destroy(TataCara $tataCara)
    {
        $tataCara->delete();

        return redirect()->route('tata-cara.index')
            ->with('success', 'Tata Cara deleted successfully.');
    }

    // menampilkan detail tata cara
    public function show(TataCara $tataCara)
    {
        return Inertia::render('Shalat/TataCara/Show', [
            'tataCara' => $tataCara->load('gerakan'),
        ]);
    }
}
