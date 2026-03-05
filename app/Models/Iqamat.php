<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iqamat extends Model
{
    protected $fillable = ['waktu', 'teks_arab', 'transliterasi', 'terjemahan'];
}
