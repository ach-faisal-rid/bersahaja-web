<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hadist;
use App\Models\HadistSource;
use App\Models\Category;
use Inertia\Inertia;

class HadistController extends Controller
{
    // list of hadist
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $hadists = Hadist::with('category')
            ->when($search, function ($query, $search) {
                $query->where('judul', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Hadist/Index', [
            'hadists' => $hadists,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    // create hadist
    public function create()
    {
        return Inertia::render('Hadist/Create', [
            'categories' => Category::select('id', 'nama')->orderBy('nama')->get(),
        ]);
    }

    // store hadist
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'teks_arab' => 'required|string',
            'transliterasi' => 'required|string',
            'terjemah' => 'required|string',
            'kategori_id' => 'required|exists:categories,id',
            'audio_url' => 'nullable|url|max:255',
            'gambar_url' => 'nullable|url|max:255',
            'hadist_sources' => 'nullable|array',
            'hadist_sources.*.book' => 'required|string|max:255',
            'hadist_sources.*.number' => 'nullable|integer',
            'hadist_sources.*.narrator' => 'required|string|max:255',
            'hadist_sources.*.status' => 'required|string|max:255',
            'hadist_sources.*.notes' => 'nullable|string',
        ]);

        $hadist = Hadist::create($validated);

        // Create hadist sources
        $hadistSources = $request->input('hadist_sources', []);
        if (!empty($hadistSources) && is_array($hadistSources)) {
            foreach ($hadistSources as $source) {
                if (!empty($source['book']) && !empty($source['narrator']) && !empty($source['status'])) {
                    HadistSource::create([
                        'hadist_id' => $hadist->id,
                        'book' => $source['book'],
                        'number' => $source['number'] ?? null,
                        'narrator' => $source['narrator'],
                        'status' => $source['status'],
                        'notes' => $source['notes'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('hadists.index')->with('success', 'Hadist berhasil ditambahkan.');
    }

    // edit hadist
    public function edit(Hadist $hadist)
    {
        return Inertia::render('Hadist/Edit', [
            'hadist' => $hadist->load('hadistSources'),
            'categories' => Category::select('id', 'nama')->orderBy('nama')->get(),
        ]);
    }

    // update hadist
    public function update(Request $request, Hadist $hadist)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'teks_arab' => 'required|string',
            'transliterasi' => 'required|string',
            'terjemah' => 'required|string',
            'kategori_id' => 'required|exists:categories,id',
            'audio_url' => 'nullable|url|max:255',
            'gambar_url' => 'nullable|url|max:255',
            'hadist_sources' => 'nullable|array',
            'hadist_sources.*.book' => 'required|string|max:255',
            'hadist_sources.*.number' => 'nullable|integer',
            'hadist_sources.*.narrator' => 'required|string|max:255',
            'hadist_sources.*.status' => 'required|string|max:255',
            'hadist_sources.*.notes' => 'nullable|string',
        ]);

        $hadist->update($validated);

        // Delete existing hadist sources
        $hadist->hadistSources()->delete();

        // Create new hadist sources
        $hadistSources = $request->input('hadist_sources', []);
        if (!empty($hadistSources) && is_array($hadistSources)) {
            foreach ($hadistSources as $source) {
                if (!empty($source['book']) && !empty($source['narrator']) && !empty($source['status'])) {
                    HadistSource::create([
                        'hadist_id' => $hadist->id,
                        'book' => $source['book'],
                        'number' => $source['number'] ?? null,
                        'narrator' => $source['narrator'],
                        'status' => $source['status'],
                        'notes' => $source['notes'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('hadists.index')->with('success', 'Hadist berhasil diubah.');
    }

    // delete hadist
    public function destroy(Hadist $hadist)
    {
        $hadist->delete();

        return redirect()->route('hadists.index')->with('success', 'Hadist berhasil dihapus.');
    }
}
