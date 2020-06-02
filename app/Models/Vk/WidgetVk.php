<?php

namespace App\Models\Vk;

use Illuminate\Database\Eloquent\Model;

class WidgetVk extends Model
{


    protected $table='widget_vk';
    public function widget(){
        return $this->belongsTo('App\Widgets','widget_id');
    }


}
