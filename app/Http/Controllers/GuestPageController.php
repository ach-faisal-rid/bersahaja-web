<?php

namespace App\Http\Controllers;

use App\Models\Doa;
use App\Models\Hadist;
use Illuminate\Support\Str;
use Inertia\Inertia;

class GuestPageController extends Controller
{
    public function index()
    {
        $doas = Doa::query()
            ->with(['category:id,nama', 'tags:id,nama'])
            ->where('is_active', true)
            ->orderByDesc('id')
            ->limit(6)
            ->get(['id', 'kategori_id', 'judul', 'teks_arab', 'transliterasi', 'terjemahan']);

        $hadists = Hadist::query()
            ->with('category:id,nama')
            ->orderByDesc('id')
            ->limit(6)
            ->get(['id', 'kategori_id', 'judul', 'teks_arab', 'transliterasi', 'terjemah']);

        return Inertia::render('Guest/Home', [
            'doas' => $doas->map(function ($doa) {
                return [
                    'id' => $doa->id,
                    'judul' => $doa->judul,
                    'teks_arab' => $doa->teks_arab,
                    'transliterasi' => Str::limit((string) $doa->transliterasi, 180),
                    'terjemahan' => Str::limit((string) $doa->terjemahan, 220),
                    'category' => $doa->category ? ['nama' => $doa->category->nama] : null,
                    'tags' => $doa->tags->map(fn ($tag) => ['nama' => $tag->nama])->values(),
                ];
            })->values(),
            'hadists' => $hadists->map(function ($hadist) {
                return [
                    'id' => $hadist->id,
                    'judul' => $hadist->judul,
                    'teks_arab' => $hadist->teks_arab,
                    'transliterasi' => Str::limit((string) $hadist->transliterasi, 180),
                    'terjemah' => Str::limit((string) $hadist->terjemah, 220),
                    'category' => $hadist->category ? ['nama' => $hadist->category->nama] : null,
                ];
            })->values(),
        ]);
    }
}
