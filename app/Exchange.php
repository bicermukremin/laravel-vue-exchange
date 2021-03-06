<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function opportunities()
    {
        return $this->belongsToMany(Opportunity::class);
    }
}