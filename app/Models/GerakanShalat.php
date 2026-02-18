<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GerakanShalat extends Model
{
    protected $table = 'gerakan_shalats';
    
    protected $fillable = [
        'nama_gerakan',
        'urutan_global',
        'icon_url',
        'deskripsi_singkat',
        'kategori',
    ];

    protected $casts = [
        'urutan_global' => 'integer',
    ];
}
