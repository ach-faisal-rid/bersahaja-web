<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use inertia\Inertia;

class TagController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $tags = Tag::all();
        return Inertia::render('Tag/Index', [
            'tags' => $tags
        ]); 
    }

    public function create()
    {
        return Inertia::render('Tag/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        Tag::create($request->all());

        return redirect()->route('tags.index');
    }
}
