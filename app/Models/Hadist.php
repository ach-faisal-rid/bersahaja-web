<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hadist extends Model
{
    protected $fillable = ['judul', 'teks_arab', 'transliterasi', 'terjemah', 'kategori_id', 'audio_url', 'gambar_url'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function sources()
    {
        return $this->hasMany(HadistSource::class);
    }

    public function doa()
    {
        return $this->belongsTo(Doa::class);
    }
}
