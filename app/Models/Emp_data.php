<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emp_data extends Model
{
    protected $table = "emp_data";
    protected $connection = 'sqlsrv2'; 
    public $timestamps = false;
    // protected $guard = 'internal';
	// public $incrementing = 'false';
}
