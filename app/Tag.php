<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }
}