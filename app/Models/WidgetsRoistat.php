<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetsRoistat extends Model
{


    protected $table='widgets_roistar';
    public function widget(){
        return $this->belongsTo('App\Widgets','widget_id');
    }


}
