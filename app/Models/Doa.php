<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doa extends Model
{
    protected $fillable = ['remote_id', 'kategori_id', 'judul', 'teks_arab', 'transliterasi', 'terjemahan', 'description', 'is_active', 'source', 'fetched_at', 'hadith_sources'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function hadistSources()
    {
        return $this->hasMany(HadistSource::class, 'doa_id');
    }
}
