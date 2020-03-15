<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirectOtchetParcer extends Model
{


    protected $connection='neiros_direct1';
    public $table="direct_otchet_parcer_";

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
