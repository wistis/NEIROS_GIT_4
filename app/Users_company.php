<?php

namespace App;

use App\Models\Tarifs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users_company extends Model
{


  use SoftDeletes;
protected $fillable=['*','is_active','ballans','name','tariff_id','created_at'];
    protected $table='users_company';

    public function getTariff(){

     return   $this->hasOne(Tarifs::class,'id','tariff_id');

    }
    public function users(){
        return $this->hasMany(User::class,'my_company_id','id');
    }
public function getadmin(){
        return $this->users()->where('is_first_reg',1)->first();



}
}
