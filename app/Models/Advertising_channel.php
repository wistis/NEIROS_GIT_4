<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertising_channel extends Model
{
    protected $fillable = ['*','id', 'my_company_id', 'site_id', 'name', 'utm', 'created_at', 'updated_at'];


    protected $table='Advertising_channel';
}
