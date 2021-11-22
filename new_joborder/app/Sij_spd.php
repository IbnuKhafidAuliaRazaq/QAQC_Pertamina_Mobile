<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sij_spd extends Model
{
    protected $table = "sij_spd";

    public function inspection(){
        return $this->belongsTo('App\Inspection', 'inspection_id');
    }
}
