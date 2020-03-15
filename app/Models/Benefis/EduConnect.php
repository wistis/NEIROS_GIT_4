<?php

namespace App\Models\Benefis;

use Illuminate\Database\Eloquent\Model;

class EduConnect extends Model
{


    protected $table='edu_connects';
  protected  $connection='benefis';
    public function contract()
    {
        return $this->hasMany('App\Models\Benefis\EduContract','connect_id','id');
    }
}
