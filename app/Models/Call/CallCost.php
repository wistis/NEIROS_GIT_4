<?php

namespace App\Models\Call;

use App\Models\Tarifs;
use App\Project;
use App\User;
use App\Users_company;
use Illuminate\Database\Eloquent\Model;
use DB;
class CallCost extends Model
{

    protected $fillable=['*','id', 'tip', 'my_company_id', 'site_id', 'table_id', 'duration', 'tariff', 'date', 'created_at', 'updated_at'];

    protected $table='call_costs';



   public static function create_from_calls(){

       $calls=DB::connection('asterisk')->table('calls')->whereNULL('in_timing')->take(3000)->get();
       $i=0;
       $tarif_price=1.6;
       $datainsert=[];
       foreach ($calls as $call){

           $mystring = $call->dialstring;
           $findme   = 'runexis';
           $pos = strpos($mystring, $findme);

// Заметьте, что используется ===.  Использование == не даст верного
// результата, так как 'a' находится в нулевой позиции.
           if ($pos === false) {

           } else {



           $project=Project::where('uniqueid',$call->uniqueid)->first();
           if($project){
               $datainsert[$i]['my_company_id']=$project->my_company_id;
               $datainsert[$i]['site_id']=$project->site_id;
               $datainsert[$i]['tariff_id']=$project->getUserCompany->tafiff_id;
               if($project->getUserCompany->getTariff){
                   $tarif_price=str_replace(',','.',$project->getUserCompany->getTariff->minuta);

               }
           }else{
               $datainsert[$i]['my_company_id']=0;
               $datainsert[$i]['site_id']=0;
               $datainsert[$i]['site_id']=0;
               $datainsert[$i]['tariff_id']=0;
           }

           $sec=$tarif_price/60;
           $datainsert[$i]['price']=$tarif_price;
           $datainsert[$i]['summ']= round($call->duration * $sec , 2);

           $datainsert[$i]['table_id']=$call->id;
           $datainsert[$i]['duration']=$call->duration;
           $datainsert[$i]['date']=$call->calldate;

$datainsert[$i]['tip']=0;
           $call->in_timing=1;
               $i++;
           }
        DB::connection('asterisk')->table('calls')->where('id',$call->id)->update(['in_timing'=>1]);

       }
       CallCost::insert($datainsert);

/*    protected $fillable=['*','id', 'tip', 'my_company_id', 'site_id', 'table_id', 'duration', 'tariff', 'date', 'created_at', 'updated_at'];*/





   }
   public static function create_from_calback(){

       $calls=DB::connection('asterisk')->table('callback_calls')->whereNULL('in_timing')->take(3000)->get();
       $i=0;
       $tarif_price=1.6;
       $datainsert=[];
       foreach ($calls as $call){

           $mystring = $call->dialstring;
           $findme   = 'runexis';
           $pos = strpos($mystring, $findme);

// Заметьте, что используется ===.  Использование == не даст верного
// результата, так как 'a' находится в нулевой позиции.
           if ($pos === false) {

           } else {



           $project=Project::where('call_back_random_id',$call->callback_id)->first();
           if($project){
               $datainsert[$i]['my_company_id']=$project->my_company_id;
               $datainsert[$i]['site_id']=$project->site_id;
               $datainsert[$i]['tariff_id']=$project->getUserCompany->tafiff_id;
               if($project->getUserCompany->getTariff){
                   $tarif_price=str_replace(',','.',$project->getUserCompany->getTariff->minuta);

               }
           }else{
               $datainsert[$i]['my_company_id']=0;
               $datainsert[$i]['site_id']=0;
               $datainsert[$i]['site_id']=0;
               $datainsert[$i]['tariff_id']=0;
           }

           $sec=$tarif_price/60;
           $datainsert[$i]['price']=$tarif_price;
           $datainsert[$i]['summ']= round($call->duration * $sec , 2);

           $datainsert[$i]['table_id']=$call->id;
           $datainsert[$i]['duration']=$call->duration;
           $datainsert[$i]['date']=$call->calldate;

$datainsert[$i]['tip']=1;
           $call->in_timing=1;
               $i++;
           }
        DB::connection('asterisk')->table('callback_calls')->where('id',$call->id)->update(['in_timing'=>1]);

       }
       CallCost::insert($datainsert);

/*    protected $fillable=['*','id', 'tip', 'my_company_id', 'site_id', 'table_id', 'duration', 'tariff', 'date', 'created_at', 'updated_at'];*/





   }
   public static function reprov(){
       $pr=1.6;
       $data=CallCost::get();
       foreach ($data as $item){

           $user_companu=Users_company::find($item->my_company_id);
           if($user_companu){
           $tarif=Tarifs::find($user_companu->tariff_id);
if($tarif){
    $pr=str_replace(',','.',$tarif->minuta);
    $item->price=$pr;
    $item->tariff_id=$tarif->id;
    $item->summ=$pr/60*$item->duration;
    $item->save();
}






           }




       }

   }


}
