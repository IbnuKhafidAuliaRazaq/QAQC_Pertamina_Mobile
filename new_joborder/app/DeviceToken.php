<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $table = 'device_token';
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\Users', 'user_id');
    }
}
