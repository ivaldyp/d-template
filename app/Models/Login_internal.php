<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Login_internal extends Authenticatable
{
    use notifiable;
    
    protected $table = "emp_data";
    // protected $guard = 'internal';
    public $timestamps = false;
    protected $connection = 'sqlsrv2'; 
	// public $incrementing = 'false';
}
