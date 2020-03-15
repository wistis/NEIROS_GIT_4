<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costs extends Model
{
    protected $fillable = ['*','id', 'site_id', 'my_company_id', 'canal_id', 'period_start', 'period_end', 'summ', 'created_at', 'updated_at'];


    protected $table='Costs';
}
