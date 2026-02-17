<?php

namespace App\Http\Controllers;

use App\Models\Doa;
use App\Models\Hadist;
use Inertia\Inertia;

class GuestPageController extends Controller
{
    public function index()
    {
        return Inertia::render('Guest/Home', [
            'doas' => Doa::query()
                ->where('is_active', true)
                ->orderByDesc('id')
                ->limit(6)
                ->get(['id', 'judul', 'teks_arab', 'transliterasi', 'terjemahan']),
            'hadists' => Hadist::query()
                ->orderByDesc('id')
                ->limit(6)
                ->get(['id', 'judul', 'teks_arab', 'transliterasi', 'terjemah']),
        ]);
    }
}
