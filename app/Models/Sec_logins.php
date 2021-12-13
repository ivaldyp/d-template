<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sec_logins extends Model
{
    protected $table = "sec_logins";
    protected $connection = 'sqlsrv2'; 
    public $timestamps = false;
    // protected $guard = 'internal';
	// public $incrementing = 'false';
}
