<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work_overview extends Model
{
    protected $fillable=["user_id","status_id","start_time","end_time","place"];
    public function overviews_user(){
        return $this->belongsTo("App\Models\User","user_id","id");
    }

    public function overviews_status(){
        return $this->belongsTo("App\Models\Work_status","status_id","id");
    }
}
