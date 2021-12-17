<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master_Profile extends Model
{
    protected $connection = 'server88';
    protected $table      = "bpadmaster.dbo.master_profile";
    protected $primaryKey = 'id_kolok';
    protected $keyType    = 'string';
}
