<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field_tip extends Model
{
    protected $fillable = ['*','name','field_id','tip','my_company_id'];
    protected $table='field_tip';

    public function gettip()
    {
        return $this->hasOne('App\Field','id','field_id');
    }
    public function getvalue()
    {
        return $this->hasMany('App\Field_tip_param','field_tip_id','id');
    }
}
