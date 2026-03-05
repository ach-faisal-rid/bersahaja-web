<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoaSetelahSholat extends Model
{
    protected $fillable = ['judul', 'teks_arab', 'transliterasi', 'terjemahan'];
}
