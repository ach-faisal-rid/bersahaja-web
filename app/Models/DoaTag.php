<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoaTag extends Model
{
    protected $fillable = ['doa_id', 'tag_id'];

    public function doa()
    {
        return $this->belongsTo(Doa::class, 'doa_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
