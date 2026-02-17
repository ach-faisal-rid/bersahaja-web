<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinnedDay extends Model
{
    protected $table = 'pinned_days';

    protected $fillable = [
        'year',
        'month',
        'day',
        'note',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'day' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
