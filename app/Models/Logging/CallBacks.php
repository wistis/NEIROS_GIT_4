<?php

namespace App\Models\Logging;

use Illuminate\Database\Eloquent\Model;

class CallBacks extends Model
{

    protected $fillable=['*','id', 'my_company_id', 'random_id', 'phone', 'sub_widget', 'tocall', 'array_call', 'project_id', 'step', 'response', 'created_at', 'updated_at','comment'];
    protected $connection='neiros_callback_log';
    protected $table='call_backs';


}
