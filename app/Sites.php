<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{

    protected $table='sites';


    public function get_all_widget(){

        return $this->hasMany('App\Widgets','sites_id');

    }
    public function get_all_widget_on(){

        return $this->hasMany('App\Widgets','sites_id')->where('status',1);

    }
    public function get_widget_on($tip){

        return $this->get_i()->where('tip',$tip)->first();

    }

    public function get_i(){
        return $this->hasMany('App\Widgets','sites_id') ;
    }
}
