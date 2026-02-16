<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CategoryController extends Controller
{
    // menampilkan data kategori
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $category = Category::query()
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Category/Index', [
            'categories' => $category,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    // menampilkan form tambah kategori
    public function create()
    {
        return Inertia::render('Category/Create');
    }

    // menyimpan data kategori
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
        ]);

        Category::create($validated);
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    // menampilkan form edit kategori
    public function edit(Category $category)
    {
        return Inertia::render('Category/Edit', [
            'category' => $category,
        ]);
    }

    // memperbarui data kategori
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'nama')->ignore($category->id),
            ],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    // menghapus data kategori
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
