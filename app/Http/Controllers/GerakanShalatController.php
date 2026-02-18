<?php

namespace App\Http\Controllers;

use App\Models\GerakanShalat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class GerakanShalatController extends Controller
{
    // menampilkan daftar gerakan shalat
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $gerakans = GerakanShalat::query()
            ->when($search, function ($query, $search) {
                $query->where('nama_gerakan', 'like', "%{$search}%")
                    ->orWhere('deskripsi_singkat', 'like', "%{$search}%");
            })
            ->orderBy('urutan_global', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Shalat/GerakanShalat/Index', [
            'gerakans' => $gerakans,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    // menampilkan form tambah gerakan shalat
    public function create()
    {
        return Inertia::render('Shalat/GerakanShalat/Create');
    }

    // menyimpan gerakan shalat baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gerakan' => 'required|string|max:255',
            'urutan_global' => 'required|integer|min:1',
            'deskripsi_singkat' => 'required|string',
            'kategori' => 'required|in:Wajib,Sunnah,makruh,haram',
            'icon_url' => 'nullable|string|max:255',
        ]);

        GerakanShalat::create($validated);

        return redirect()->route('gerakan-shalat.index')
            ->with('success', 'Gerakan Shalat created successfully.');
    }

    // menampilkan form edit gerakan shalat
    public function edit(GerakanShalat $gerakanShalat)
    {
        return Inertia::render('Shalat/GerakanShalat/Edit', [
            'gerakan' => $gerakanShalat,
        ]);
    }

    // memperbarui gerakan shalat
    public function update(Request $request, GerakanShalat $gerakanShalat)
    {
        $validated = $request->validate([
            'nama_gerakan' => 'required|string|max:255',
            'urutan_global' => 'required|integer|min:1',
            'deskripsi_singkat' => 'required|string',
            'kategori' => 'required|in:Wajib,Sunnah,makruh,haram',
            'icon_url' => 'nullable|string|max:255',
        ]);

        $gerakanShalat->update($validated);

        return redirect()->route('gerakan-shalat.index')
            ->with('success', 'Gerakan Shalat updated successfully.');
    }

    // menghapus gerakan shalat
    public function destroy(GerakanShalat $gerakanShalat)
    {
        $gerakanShalat->delete();

        return redirect()->route('gerakan-shalat.index')
            ->with('success', 'Gerakan Shalat deleted successfully.');
    }

    // menampilkan detail gerakan shalat
    public function show(GerakanShalat $gerakanShalat)
    {
        return Inertia::render('Shalat/GerakanShalat/Show', [
            'gerakan' => $gerakanShalat,
        ]);
    }
}
