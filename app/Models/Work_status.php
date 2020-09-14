<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work_status extends Model
{
    protected $fillable=["status_name","color"];
    public function status_overViews(){
        return $this->hasMany("App\Models\Work_overview","status_id","id");
    }
}
