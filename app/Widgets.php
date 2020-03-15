<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widgets extends Model
{
    protected $casts=[

        'params'=>'json'

    ];

    protected $table='widgets';
    public function sites(){
        return $this->belongsTo('App\Sites','sites_id');
    }

public function get_name(){
        return $this->hasOne('App\Models\WidgetName','widget_id','tip');
}

    public function w7(){
        return $this->hasOne('App\Models\Fb\WidgetFb','widget_id');
    }
    public function w18(){
        return $this->hasOne('App\Models\WidgetsRoistat','widget_id');
    }
    public function w10(){
        return $this->hasOne('App\Models\Widgets\WidgetMetrika','widget_id');
    }
    public function w22(){
        return $this->hasOne('App\Models\Widgets\WidgetMetrika','widget_id');
    }
    public function w12(){
        return $this->hasOne('App\Widgets_chat','widget_id');
    }
    public function w20(){
        return $this->hasOne('App\Models\Widgets\WidgetAdwords','widget_id');
    }
}
