<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $guarded = [];

    public function workplace(){
        return $this->hasOne('App\Models\Workplace');
    }
}
