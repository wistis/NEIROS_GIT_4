<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchToCpc extends Model
{



    protected $table='search_to_cpc';


    public static function array_key(){

      return  SearchToCpc::pluck('name')->toArray();

    }


    public static function array_val(){

        $data=[];

       foreach ( SearchToCpc::get() as $item){

           $data[$item->name]=$item;
       }
return $data;
    }

    public static  function iscps($refer,$typ,$src)
    {
        $data['typ']=$typ;
        $data['src']=$src;

        /* Эта функция будет проверять, является ли посетитель роботом поисковой системы */
        $bots = SearchToCpc::where('format','rf')->get();
        foreach ($bots as $bot) {

                if (stripos($refer, $bot->name) !== false) {
$data['typ']=$bot->typ;
$data['src']=$bot->src;

return $data;

                }else{

                }



        }

        $bot = SearchToCpc::where('name',$src)->where('format','src')->first();
       if($bot){

           $data['typ']=$bot->typ;
           $data['src']=$bot->src;
return $data;


       }





return $data;

    }
}
