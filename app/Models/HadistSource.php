<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HadistSource extends Model
{
    protected $fillable = ['doa_id', 'hadist_id', 'book', 'number', 'narrator', 'status', 'notes'];

    public function doa()
    {
        return $this->belongsTo(Doa::class);
    }

    public function hadist()
    {
        return $this->belongsTo(Hadist::class);
    }
}
