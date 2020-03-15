<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;

class WidgetsChatMessRuleTable extends Model
{


    protected $table='widgets_chat_mess_rules_table';
    public function rules(){
        return $this->belongsTo(WidgetsChatMessRule::class,'id','rules_id');
    }

}
