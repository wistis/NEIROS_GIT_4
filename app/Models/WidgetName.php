<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\SoftDeletes;
class WidgetName extends Model
{
use SoftDeletes;

    protected $table='widget_names';
    protected $fillable=['*','name','widget_id'];

}
