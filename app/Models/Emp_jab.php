<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emp_jab extends Model
{
    protected $table = "emp_jab";
    protected $connection = 'sqlsrv2'; 
    public $timestamps = false;
    // protected $guard = 'internal';
	// public $incrementing = 'false';
}
