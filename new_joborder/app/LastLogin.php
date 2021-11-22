<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LastLogin extends Model
{
    protected $table = "last_login";

    public $timestamps = false;
}
