<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin_messages extends Model
{
    protected $fillable = ['*','id', 'admin_id', 'message', 'created_at', 'updated_at','send_email','tema','tickets'];


    protected $table='admin_messages';
}
