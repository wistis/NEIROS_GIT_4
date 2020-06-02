<?php

namespace App\Models;
use  Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Tarifs extends Model
{
    use SoftDeletes;
    protected $fillable = ['*','id', 'name', 'month', 'year', 'moduls', 'phone', 'minuta', 'created_at', 'updated_at'];
    

    protected $table='tarifs';

public function widgets(){

         return $this->belongsToMany(WidgetName::class, 'tarif_widgets', 'tariff_id', 'widget_id');
}
public static function start_tarif(){


  return  Tarifs::where('month',0)->where('for_all',1)->where('satatus',1)->first();
}

}
