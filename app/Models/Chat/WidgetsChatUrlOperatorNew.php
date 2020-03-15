<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;

class WidgetsChatUrlOperatorNew extends Model
{


    protected $table='widgets_chat_url_operator_new';
    public function widget(){
        return $this->belongsTo('App\Widgets','widget_id');
    }

    public function operator(){
        return $this->belongsTo('App\User','operator_id');
    }

}
