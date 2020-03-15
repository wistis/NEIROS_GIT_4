<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifs extends Model
{
    protected $fillable = ['*','id', 'name', 'month', 'year', 'moduls', 'phone', 'minuta', 'created_at', 'updated_at'];
    protected $costs= [
    'moduls'=>'json'
    ];

    protected $table='tarifs';
}
