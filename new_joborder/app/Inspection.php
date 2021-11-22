<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $table = "inspection";

    public function requestnumber(){
        return $this->belongsTo('App\RequestInspection', 'requestinspection_id');
    }
    public function sij_spd(){
        return $this->hasOne('App\Sij_spd','inspection_id');
    }
}
