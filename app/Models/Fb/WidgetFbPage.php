<?php

namespace App\Models\Fb;

use Illuminate\Database\Eloquent\Model;

class WidgetFbPage extends Model
{


    protected $table='widget_fb_pages';

   public function widgetfb(){

   return  $this->belongsTo(\App\Models\Fb\WidgetFb::class,'widget_fb_id' ,'id' );
                              }

}
