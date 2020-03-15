<?php

namespace App\Models\Servies;

use App\User;
use Illuminate\Database\Eloquent\Model;

class GroupRoleUser extends Model
{

    protected $fillable=['*','user_id','group_id'];
    protected $table='group_role_user';


}
