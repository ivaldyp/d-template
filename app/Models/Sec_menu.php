<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sec_menu extends Model
{
    protected $table = "sec_menu";
    protected $connection = 'sqlsrv'; 
    public $timestamps = false;
    // protected $guard = 'internal';
	// public $incrementing = 'false';
}
