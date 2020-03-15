<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;

class Reports_groping extends Model
{

    protected $fillable=['*','id','name','code', 'created_at','updated_at'];
    protected $table='reports_groping';


}
