<?php

namespace App\Models\Benefis;

use Illuminate\Database\Eloquent\Model;

class EduContract extends Model
{
    protected $table = 'edu_contract';
    protected  $connection='benefis';

    public function connect()
    {
        return $this->hasOne('App\Models\Edu\EduConnect','id','connect_id');
    }


}
