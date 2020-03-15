<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class CompanyDefaultSetting extends Model
{


    protected $table='company_default_settings';

protected $fillable=['*','id', 'my_company_id', 'skey', 'value', 'created_at', 'updated_at', 'comment'];

    public function get_values_all(){

        return $this->pluck('name','id')->toArray();


    }
    public function get_value ($value){

        $znach= $this->where('skey',$value)->first();
        if(!$znach){
            return '';
        }
return $znach->value;

    }
}
