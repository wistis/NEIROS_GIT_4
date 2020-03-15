<?php

namespace App\Models\Widgets;

use Illuminate\Database\Eloquent\Model;

class WidgetAdwords extends Model
{


    protected $table='widget_adwords';
    public function widget(){
        return $this->belongsTo('App\Widgets','widget_id');
    }


}
