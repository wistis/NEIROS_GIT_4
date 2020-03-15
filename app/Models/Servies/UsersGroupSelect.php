<?php

namespace App\Models\Servies;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UsersGroupSelect extends Model
{

protected $fillable=['*','user_id','group_id'];
    protected $table='group_user';


}
