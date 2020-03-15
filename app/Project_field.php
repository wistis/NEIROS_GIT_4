<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_field extends Model
{
    protected $fillable = ['*','field_id','project_id','field_tip_id','val','my_company_id'];
    protected $table='project_field';
}
