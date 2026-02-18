<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wudu extends Model
{
    protected $table = 'wudus';
    
    protected $fillable = [
        'nama_langkah',
        'urutan',
        'deskripsi',
        'doa_arab',
        'transliterasi',
        'terjemahan',
        'tips_penting',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];
}
