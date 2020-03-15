<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;

class WidgetsChatMessRule extends Model
{


    protected $table='widgets_chat_mess_rules';
    public function widget(){
        return $this->belongsTo('App\Widgets','widget_id');
    }
    public function rules(){
        return $this->hasMany(WidgetsChatMessRuleTable::class,'rules_id','id');
    }

}
