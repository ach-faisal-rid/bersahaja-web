<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repository;
use Inertia\Inertia;

class RepositoryController extends Controller
{
    // list repositories
    public function index()
    {
        $repositories = Repository::orderBy('created_at', 'desc')->get();
        return Inertia::render('Repository/Index', [
            'repositories' => $repositories,
        ]);
    }

    // show form to create a new repository
    public function create()
    {
        return Inertia::render('Repository/Create');
    }

    // store a new repository
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'url' => 'required|url|max:255|unique:repositories,url',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Repository::create($validated);

        return redirect()->route('repositories.index')->with('success', 'Repository created successfully.');
    }

    // edit a repository
    public function edit(Repository $repository)
    {
        return Inertia::render('Repository/Edit', [
            'repository' => $repository,
        ]);
    }

    // update a repository
    public function update(Request $request, Repository $repository)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'url' => 'required|url|max:255|unique:repositories,url,' . $repository->id,
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $repository->update($validated);

        return redirect()->route('repositories.index')->with('success', 'Repository updated successfully.');
    }

    // destroy a repository
    public function destroy(Repository $repository)
    {
        $repository->delete();

        return redirect()->route('repositories.index')->with('success', 'Repository berhasil dihapus.');
    }
}

