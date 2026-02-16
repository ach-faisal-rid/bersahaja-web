<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doa;
use App\Models\Category;
use App\Models\Repository;
use App\Models\Tag;
use App\Models\HadistSource;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DoaController extends Controller
{
    // list doa
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $doas = Doa::with('category')
            ->when($search, function ($query, $search) {
                $query->where('judul', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Doa/Index', [
            'doas' => $doas,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    // create doa
    public function create()
    {
        return Inertia::render('Doa/Create', [
            'categories' => Category::select('id', 'nama')->orderBy('nama')->get(),
            'tags' => Tag::select('id', 'nama')->orderBy('nama')->get(),
            'repositories' => Repository::select('id', 'nama', 'url')
                ->where('is_active', true)
                ->orderBy('nama')
                ->get(),
        ]);
    }

    // store doa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'repository_id' => 'nullable|exists:repositories,id',
            'kategori_id' => 'required|exists:categories,id',
            'judul' => 'required|string|max:255',
            'teks_arab' => 'required|string',
            'transliterasi' => 'required|string',
            'terjemahan' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'source' => 'nullable|string|max:255',
            'fetched_at' => 'nullable|date',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'integer|exists:tags,id',
            'hadist_sources' => 'nullable|array',
            'hadist_sources.*.book' => 'required|string|max:255',
            'hadist_sources.*.number' => 'nullable|integer',
            'hadist_sources.*.narrator' => 'required|string|max:255',
            'hadist_sources.*.status' => 'required|string|max:255',
            'hadist_sources.*.notes' => 'nullable|string',
        ]);

        if (!empty($validated['repository_id'])) {
            $repository = Repository::find($validated['repository_id']);

            if ($repository) {
                if (empty($validated['source'])) {
                    $validated['source'] = $repository->url;
                }

                $validated['remote_id'] = $this->generateRemoteId((int) $repository->id, $validated['judul']);
            }
        }

        unset($validated['repository_id']);

        $validated['is_active'] = $request->boolean('is_active', true);
        $tagIds = $validated['tag_ids'] ?? [];
        unset($validated['tag_ids']);

        // Handle hadist_sources array
        $hadistSources = $request->input('hadist_sources', []);
        unset($validated['hadist_sources']);

        $doa = Doa::create($validated);
        $doa->tags()->sync($tagIds);

        // Create hadist sources
        if (!empty($hadistSources) && is_array($hadistSources)) {
            foreach ($hadistSources as $source) {
                if (!empty($source['book']) && !empty($source['narrator']) && !empty($source['status'])) {
                    HadistSource::create([
                        'doa_id' => $doa->id,
                        'book' => $source['book'],
                        'number' => $source['number'] ?? null,
                        'narrator' => $source['narrator'],
                        'status' => $source['status'],
                        'notes' => $source['notes'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('doas.index')->with('success', 'Doa berhasil ditambahkan.');
    }

    // edit doa
    public function edit(Doa $doa)
    {
        return Inertia::render('Doa/Edit', [
            'doa' => $doa->load(['hadistSources', 'tags:id,nama']),
            'categories' => Category::select('id', 'nama')->orderBy('nama')->get(),
            'tags' => Tag::select('id', 'nama')->orderBy('nama')->get(),
            'repositories' => Repository::select('id', 'nama', 'url')
                ->where('is_active', true)
                ->orderBy('nama')
                ->get(),
        ]);
    }

    // update doa
    public function update(Request $request, Doa $doa)
    {
        $validated = $request->validate([
            'repository_id' => 'nullable|exists:repositories,id',
            'kategori_id' => 'required|exists:categories,id',
            'judul' => 'required|string|max:255',
            'teks_arab' => 'required|string',
            'transliterasi' => 'required|string',
            'terjemahan' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'source' => 'nullable|string|max:255',
            'fetched_at' => 'nullable|date',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'integer|exists:tags,id',
            'hadist_sources' => 'nullable|array',
            'hadist_sources.*.book' => 'required|string|max:255',
            'hadist_sources.*.number' => 'nullable|integer',
            'hadist_sources.*.narrator' => 'required|string|max:255',
            'hadist_sources.*.status' => 'required|string|max:255',
            'hadist_sources.*.notes' => 'nullable|string',
        ]);

        // Handle repository_id and remote_id update
        if (!empty($validated['repository_id'])) {
            $repository = Repository::find($validated['repository_id']);

            if ($repository) {
                if (empty($validated['source'])) {
                    $validated['source'] = $repository->url;
                }

                // Only generate new remote_id if repository changed or doesn't exist
                if ($doa->remote_id === null || !str_starts_with($doa->remote_id, 'repo-' . $repository->id)) {
                    $validated['remote_id'] = $this->generateRemoteId((int) $repository->id, $validated['judul']);
                }
            }
        }

        unset($validated['repository_id']);

        $validated['is_active'] = $request->boolean('is_active', true);
        $tagIds = $validated['tag_ids'] ?? [];
        unset($validated['tag_ids']);

        // Handle hadist_sources array
        $hadistSources = $request->input('hadist_sources', []);
        unset($validated['hadist_sources']);

        $doa->update($validated);
        $doa->tags()->sync($tagIds);

        // Delete existing hadist sources
        $doa->hadistSources()->delete();

        // Create new hadist sources
        if (!empty($hadistSources) && is_array($hadistSources)) {
            foreach ($hadistSources as $source) {
                if (!empty($source['book']) && !empty($source['narrator']) && !empty($source['status'])) {
                    HadistSource::create([
                        'doa_id' => $doa->id,
                        'book' => $source['book'],
                        'number' => $source['number'] ?? null,
                        'narrator' => $source['narrator'],
                        'status' => $source['status'],
                        'notes' => $source['notes'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('doas.index')->with('success', 'Doa berhasil diperbarui.');
    }

    // destroy doa
    public function destroy(Doa $doa)
    {
        $doa->delete();

        return redirect()->route('doas.index')->with('success', 'Doa berhasil dihapus.');
    }

    private function generateRemoteId(int $repositoryId, string $judul): string
    {
        $slug = Str::slug(Str::limit($judul, 60, ''));
        $base = 'repo-' . $repositoryId . ($slug !== '' ? '-' . $slug : '');
        $candidate = $base;
        $counter = 1;

        while (Doa::where('remote_id', $candidate)->exists()) {
            $candidate = $base . '-' . $counter;
            $counter++;
        }

        return $candidate;
    }
}
