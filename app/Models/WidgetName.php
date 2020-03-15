<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetName extends Model
{


    protected $table='widget_names';
    protected $fillable=['*','name','widget_id'];

}
