<?php

namespace App\Models\Fb;

use Illuminate\Database\Eloquent\Model;

class WidgetFb extends Model
{


    protected $table='widget_fb';
    public function widget(){
        return $this->belongsTo('App\Widgets','widget_id');
    }


}
