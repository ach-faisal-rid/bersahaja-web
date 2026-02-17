<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HijriEvent extends Model
{
    protected $fillable = [
        'year',
        'month',
        'day',
        'title',
        'description',
        'date_label',
        'color_hex',
        'icon_key',
        'source',
        'fetched_at',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'day' => 'integer',
        'fetched_at' => 'datetime',
    ];
}
