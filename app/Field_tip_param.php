<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field_tip_param extends Model
{
    protected $fillable = ['*','name','field_id','field_tip_id','my_company_id'];
    protected $table='field_tip_param';
}
