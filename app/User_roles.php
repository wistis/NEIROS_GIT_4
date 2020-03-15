<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_roles extends Model
{
    protected $fillable = ['*','modul','user_id','read','edit','create','delete'];
    protected $table='user_roles';
}
