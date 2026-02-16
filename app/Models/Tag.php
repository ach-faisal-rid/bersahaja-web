<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['nama'];

    public function doas()
    {
        return $this->belongsToMany(Doa::class, 'doa_tags', 'tag_id', 'doa_id');
    }
}
