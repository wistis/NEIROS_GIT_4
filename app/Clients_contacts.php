<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients_contacts extends Model
{
    protected $fillable = ['*','id', 'client_id', 'my_company_id', 'keytip', 'val', 'created_at', 'updated_at'];


    public function getClient()
    {
        return $this->hasOne('App\Client','id','client_id');
    }
}
