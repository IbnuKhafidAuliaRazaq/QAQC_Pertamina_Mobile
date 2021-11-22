<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestInspection extends Model
{
    protected $table = "requestinspection";

    public function user(){
        return $this->belongsTo('App\Users', 'user_id');
    }
    public function sercom(){
        return $this->belongsTo('App\Sercom', 'sercom_id');
    }
}
