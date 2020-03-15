<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmoWebhook extends Model
{



    protected $table='amo_webhooks';
    protected $casts=['data'=>'json','data_lead_1'=>'json','data_lead_2'=>'json'];
}
