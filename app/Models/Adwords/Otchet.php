<?php

namespace App\Models\Adwords;

use Illuminate\Database\Eloquent\Model;

class Otchet extends Model
{


    protected $connection='neiros_cloud_adwords';
    public $table="adwords_otchet_parcer_";

    public function __construct($my_company_id =null)
    {
        if((is_null($my_company_id))||is_array((is_null($my_company_id)))){
            $this->table=$this->table.auth()->user()->my_company_id;

        }else{
        try{
            $this->table=$this->table.$my_company_id;}catch (\Exception $e){

        }
        }

    }




}
