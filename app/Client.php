<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['*','fio','email','phone','company_id','my_company_id'];


    public function getcompany()
    {
        return $this->hasOne('App\Company','id','company_id');
    }
    public function getClient()
    {
        return $this->hasMany('App\Clients_contacts','client_id','id');
    }
}
