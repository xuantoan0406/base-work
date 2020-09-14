<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = [];

    public function activity(){
        return $this->hasOne('App\Models\Activity');
    }
}


