<?php

namespace App\Models\Widgets;

use Illuminate\Database\Eloquent\Model;

class WidgetCallbackRouting extends Model
{


    protected $table='widget_callback_routing';
    public function widget(){
        return $this->belongsTo('App\Widgets','widget_id');
    }


}
