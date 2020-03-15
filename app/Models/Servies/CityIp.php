<?php

namespace App\Models\Servies;

use App\Servies\Dadata;
use Illuminate\Database\Eloquent\Model;
use DB;
class CityIp extends Model
{


    protected $table='city_ips';



    public static function get_ip($neiros_visit,$ip){
$prov_ip_neiros=DB::table('metrika_current_region')->where('neiros_visit',$neiros_visit)->first();
if($prov_ip_neiros){return '1'; }



      $prov_id=CityIp::where('ip',$ip)->first();
if($prov_id){
    DB::table('metrika_current_region')->insert([
        'city' => $prov_id->city,
        'region' => $prov_id->region,
        'ip' => $ip,
        'neiros_visit' => $neiros_visit,

    ]);
return '2';
}

        $dadata = new Dadata("e07930f5614b8f86f5699f4e631b02f8dd59c635");
        $dadata->init();

        $result = $dadata->iplocate($ip);

        $data['city']='';
        $data['region']='';
        $error=0;
if(isset($result['location'])){

if(isset($result['location']['value'])){$error=1;
    $data['city']=$result['location']['value'];
}

    if(isset($result['location']['unrestricted_value'])){$error=2;
        $data['region']=$result['location']['unrestricted_value'];
    }

}

if($error>0){
    $citip=new CityIp();
    $citip->ip=$ip;
    $citip->city=$data['city'];
    $citip->region=$data['region'];
    $citip->save();
    DB::table('metrika_current_region')->insert([
        'city' => $data['city'],
        'region' => $data['region'],
        'ip' => $ip,
        'neiros_visit' => $neiros_visit,

    ]);


}

    }

}

