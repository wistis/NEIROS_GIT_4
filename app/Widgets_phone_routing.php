<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widgets_phone_routing extends Model
{
    protected  $table='widgets_phone_routing';

    protected $casts=['canals'=>'json'];

    public function phones(){

     return   $this->hasMany(\App\Widgets_phone::class,'routing');

    }
}
