<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function status()
    {
//        return $this->belongsTo('App\Models\Status');
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
