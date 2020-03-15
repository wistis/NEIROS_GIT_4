<?php

namespace App\Models\Widgets;

use Illuminate\Database\Eloquent\Model;

class WidgetMetrika extends Model
{


    protected $table='widget_metrika';
    public function widget(){
        return $this->belongsTo('App\Widgets','widget_id');
    }


}
