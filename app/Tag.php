<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $guarded = [];

    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }
}