<?php

namespace App\Models\Widgets;

use Illuminate\Database\Eloquent\Model;

class WidgetVkUsers extends Model
{

protected $fillable=['*','id', 'my_company_id', 'user_id', 'widget_id', 'vk_user_id', 'first_name', 'last_name', 'photo_50', 'photo_200', 'city', 'created_at', 'updated_at', 'widget_vk_input_id', 'tema_id'];
    protected $table='widget_vk_users';



}
