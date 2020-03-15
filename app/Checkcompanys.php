<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkcompanys extends Model
{
    protected $fillable = ['*','id', 'my_company_id', 'company_id', 'summ', 'status', 'created_at', 'updated_at'];


    protected $table='Checkcompanys';
}
