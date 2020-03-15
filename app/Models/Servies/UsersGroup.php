<?php

namespace App\Models\Servies;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UsersGroup extends Model
{


    protected $table = 'groups';

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user',  'group_id','user_id' );
    }

}
