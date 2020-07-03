<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function exchanges()
    {
        return $this->belongsToMany(Exchange::class);
    }
}