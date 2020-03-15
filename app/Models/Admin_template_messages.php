<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_template_messages extends Model
{
    protected $fillable = ['*','id', 'name', 'tip','period','time', 'text', 'created_at', 'updated_at'];


    protected $table='admin_template_messages';
}
