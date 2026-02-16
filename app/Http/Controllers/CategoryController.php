<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use inertia\Inertia;

class CategoryController extends Controller
{
    // menampilkan data kategori
    public function index()
    {
        $category = Category::all();
        return Inertia::render('Category/Index', [
            'categories' => $category
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
        $request->validate([
            'nama' => 'required',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    // menampilkan form edit kategori
    public function edit($id)
    {
        $category = Category::find($id);
        return Inertia::render('Category/Edit', [
            'category' => $category
        ]);
    }

    // memperbarui data kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
        ]);
        $category = Category::find($id);
        $category->update($request->all());
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    // menghapus data kategori
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
