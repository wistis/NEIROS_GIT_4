<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects_tag extends Model
{
    protected $fillable = ['*','tag_id','project_id','my_company_id'];
}
