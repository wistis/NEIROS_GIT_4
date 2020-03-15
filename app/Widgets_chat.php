<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widgets_chat extends Model
{
protected $fillable=["*",'id', 'widget_id', 'my_company_id', 'user_id', 'email', 'updated_at', 'created_at', 'first_message', 'logo', 'phone', 'operator_name', 'timer', 'create_project', 'job', 'active_chat', 'active_callback', 'active_formback', 'active_map', 'active_social', 'callback_tip', 'callback_phone', 'callback_timer', 'callback_phonepassword', 'formback_email', 'formback_tema', 'map_html'];
    protected $table='widgets_chat';
    protected $casts = [
        'active_chat' => 'boolean'
    ];
}
