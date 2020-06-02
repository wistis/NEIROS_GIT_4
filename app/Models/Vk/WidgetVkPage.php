<?php

namespace App\Models\Vk;

use Illuminate\Database\Eloquent\Model;

class WidgetVkPage extends Model
{


    protected $table='widget_vk_pages';

   public function widgetvk(){

   return  $this->belongsTo(\App\Models\Vk\WidgetVk::class,'widget_vk_id' ,'id' );
                              }

}
