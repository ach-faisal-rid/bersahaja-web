<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TataCara extends Model
{
    protected $table = 'tata_caras';
    
    protected $fillable = [
        'nama_langkah',
        'urutan',
        'deskripsi',
        'gerakan_id',
        'bacaan_arab',
        'transliterasi',
        'terjemahan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function gerakan()
    {
        return $this->belongsTo(GerakanShalat::class, 'gerakan_id');
    }
}
