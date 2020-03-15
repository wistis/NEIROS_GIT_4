<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widgets_phone extends Model
{
    protected  $table='widgets_phone';

    public function routingm(){

        return   $this->belongsTo(\App\Widgets_phone_routing::class,  'routing');

    }
}
