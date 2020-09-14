<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    protected $guarded = [];

    public function place(){
        return $this->hasOne(Place::class, 'id', 'place_id');
    }
}
