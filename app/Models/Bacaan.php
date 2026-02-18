<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bacaan extends Model
{
    protected $table = 'bacaans';
    
    protected $fillable = [
        'nama_bacaan',
        'bacaan_arab',
        'transliterasi',
        'terjemahan',
        'deskripsi',
        'kategori',
    ];

    public function tataCara()
    {
        return $this->hasMany(TataCara::class);
    }
}
