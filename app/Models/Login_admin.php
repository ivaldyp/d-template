<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Login_admin extends Authenticatable
{
    use notifiable;

    protected $table = 'sec_logins';
    // protected $guard = 'admin';
    public $timestamps = false;
    protected $connection = 'sqlsrv2';
	// protected $primaryKey = "usname"; 
	// public $incrementing = 'false';
}
