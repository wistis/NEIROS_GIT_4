<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;

class My_reports_dashboard extends Model
{

    protected $fillable=['*','id','my_company_id','grouping','resourse','created_at','updated_at','name','type'];
    protected $table='my_reports_dashboard';
    protected $casts=[
        'grouping'=>'json',
        'resourse'=>'json',

    ];

}
