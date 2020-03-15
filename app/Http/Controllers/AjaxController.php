<?php

namespace App\Http\Controllers;
use App\Models\MetricaCurrent;
use App\Models\Reports\AsteriskCall;
use DateInterval;
use DatePeriod;
use DateTime;
use App\Http\Controllers\AsteriskController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ProjectController;
use App\Models\WidgetCanal;
use App\PartnersClientPay;
use App\Project;
use App\User;
use App\Widgets_chat;
use App\Widgets_chat_url_operator;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;

use App\Widgets;
class AjaxController extends Controller
{
    public function router($tip, Request $request)
    {

        $ProjectController=new ProjectController();
        switch ($tip) {

            case 'add_ajax_lead_promocod':

                return $ProjectController->add_ajax_lead_promocod($request);

                break;

            case 'uploadfilechatavatar':

                return $this->uploadfilechatavatar($request);

                break;
            case 'safe_operator':

                return $this->safe_operator($request);

                break;
            case 'get_operator':

                return $this->get_operator($request->id);

                break;
            case 'delete_routiing_calltrack':

                return $this->delete_routiing_calltrack($request->ids);

                break;
            case 'delete_from_routing':

                return $this->delete_from_routing($request->numbers);

                break;
            case 'edit_routing_get':

                return $this->edit_routing_get($request->ids, $request->widget_id);

                break;
            case 'load_free_numbers':

                return $this->load_free_numbers($request->widget_id);

                break;
            case 'load_free_numbers3':

                return $this->load_free_numbers3($request->widget_id,$request->id);

                break;
            case 'get_dialog':

                return $this->get_dialog($request->id);

                break;

            case 'wchat_save':

                return $this->wchat_save($request->all());

                break;
            case 'payschet':

                return $this->payschet($request->id);

                break;
            case 'addcanal':

                return $this->addcanal($request);

                break;
            case 'addfast':

                return $this->addfast($request);

                break;

            case 'deletecanal':

                return $this->deletecanal($request);

                break;

            case 'addcanalpromocod':

                return $this->addcanalpromocod($request);

                break;
            case 'deletecanalcpomocod':

                return $this->deletecanalcpomocod($request);

                break;
/*static email*/

            case 'addcanalems':

                return $this->addcanalems($request);

                break;
            case 'deletecanalems':

                return $this->deletecanalems($request);

                break;
            case 'deletefast':

                return $this->deletefast($request);

                break;
/*static email*/


            case 'billingphones':

                return $this->billingphones($request);

                break;
            case 'billingphonesrecs':

                return $this->billingphonesrecs($request);

                break;
            case 'get_audio':

                return $ProjectController->get_audio_ajax($request);

                break;
            case 'get_inputcall':

                return $this->get_inputcall($request);

                break;
            case 'get_inputcall_back':

                return $this->get_inputcall_back($request);

                break;

            case 'get_client_info':

                return $ProjectController->get_client_info($request->id);

                break;
            case 'set_form_fields':

                return $this->set_form_fields($request );

                break;
            case 'send_call':

                return $this->send_call($request );

                break;

            case 'client_edit_safe':

                return \App\Http\Controllers\ClientController::client_edit_safe($request );

                break;

            case 'chatsearch':

                 return \App\Http\Controllers\ChatController::chatsearch($request );
                break;
            case 'setchatsite':

                return \App\Http\Controllers\ChatController::setchatsite($request );
                break;
            case 'setchatsitetext':

                return \App\Http\Controllers\ChatController::setchatsitetext($request );
                break;
        }


    }
    public function send_call(Request $request){

        $phone = trim($request->phone, '');
        $phone = trim($phone, '+');
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);
        $phone = str_replace("(", "", $phone);
        $phone = str_replace(")", "", $phone);
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);
        $phone = str_replace("(", "", $phone);
        $phone = str_replace(")", "", $phone);

        $random_id =rand(1,999999);


            $tocall = 'SIP/3105';



          $sendArray = array(
            'id' => $random_id, // Мой ID звонка
            'aonA' => '79216356232',  //увидит менеджер
            'aonB' => $phone,//номер увидит клиент
            'dialstringA' => 'SIP/runexis/'.$phone,//это номер менеджера
            'dialstringB' => $tocall,//Это номер клиента?
        );

//print_r($sendArray);

        $server = 'http://82.146.43.227/call/callback.php';

        $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $headers[] = "Accept-Language: ru,en;q=0.7,en-us;q=0.3";
        $headers[] = "Accept-Encoding: gzip,deflate";
        $headers[] = "Accept-Charset: UTF-8,*";
        $headers[] = "Keep-Alive: 300";
        $headers[] = "Connection: keep-alive";
        $user_agent = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.8) Gecko/20100214 Centos/6.5 (main) Firefox/3.5.8 brost-scripts";


        $process = curl_init($server);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, false);
        curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($process, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($process, CURLOPT_TIMEOUT, 60);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($sendArray));


         $data = curl_exec($process);
        curl_close($process);
        DB::table('input_call_if')->insert([
            'random_id' => $random_id,
            'created_at' => date('Y-m-d')
        ]);
        return $data;
    }

public function set_form_fields($request){
DB::table('neiros_hash_fields')->where('id',$request->id_field)->update([
'tip'=>$request->value_field
]);


}

    public function addcanalems($request){
        $user=Auth::user();
        $widget=DB::table('widgets')->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 9)->first();
        $promocod=rand(111,999);
        $costId=DB::table('widgets_email_static')->insertGetId([
            'my_company_id'=>$user->my_company_id,

            'name_cod'=>'s'.$promocod,
            'widget_id'=>$widget->id,
            'canal'=>$request->canal,
            'created_at'=>date('Y-m-d'),
        ]);

        $widget_email=DB::table('widgets_email')->where('widget_id', $widget->id)->where('my_company_id', $user->my_company_id)->first();

        $search_email=explode("@",$widget_email->email);
        if(count($search_email)==2){
            $start=$search_email[0];
            $end=$search_email[1];
        }else{
            $start='';
            $end='';
        }
        $costs=DB::table('widgets_email_static')->where('id',$costId)->first();
        /* <tr id="cost{{$cost->id}}">
                                <td >{{$cost->canal}}</td>
                                <td >{{$cost->promocod}}</td>
                                <td >{{date('d-m-Y'),strtotime($cost->created_at)}}</td>
                                <td >{{$cost->summ}}</td>

                                <td ><i class="fa fa-trash" onclick="deletecanal({{$cost->id}})"></i> </td>
                            </tr>*/

        $result=' <tr id="cost'.$costs->id.'">
                  <td >'.$costs->canal.'</td>
                  <td >'.$start.'+'.$costs->name_cod.'@'.$end.'</td>
                  <td >'.date('d-m-Y',strtotime($costs->created_at)).'</td>
               
                  <td ><i class="fa fa-trash" onclick="deletecanalems('.$costs->id.')"></i> </td>


              </tr>';

        return $result;

    }

public function deletecanalems($request){
    $user=Auth::user();

    DB::table('widgets_email_static')->where('id',$request->id)->where('my_company_id',$user->my_company_id)->delete();
}
    public function deletecanalcpomocod($request){
        $user=Auth::user();

        DB::table('widgets_off_promokod')->where('id',$request->id)->where('my_company_id',$user->my_company_id)->delete();
    }
    public function addcanalpromocod($request){
        $user=Auth::user();
        $widget=DB::table('widgets')->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 15)->first();
$promocod=rand(111111,999999);
        $costId=DB::table('widgets_off_promokod')->insertGetId([
            'my_company_id'=>$user->my_company_id,
            'site_id'=>$user->site,
             'promocod'=>$promocod,
            'widget_id'=>$widget->id,
            'canal'=>$request->canal,
            'created_at'=>date('Y-m-d'),
        ]);


        $costs=DB::table('widgets_off_promokod')->where('id',$costId)->first();
/* <tr id="cost{{$cost->id}}">
                        <td >{{$cost->canal}}</td>
                        <td >{{$cost->promocod}}</td>
                        <td >{{date('d-m-Y'),strtotime($cost->created_at)}}</td>
                        <td >{{$cost->summ}}</td>

                        <td ><i class="fa fa-trash" onclick="deletecanal({{$cost->id}})"></i> </td>
                    </tr>*/

        $result=' <tr id="cost'.$costs->id.'">
                  <td >'.$costs->canal.'</td>
                  <td >'.$costs->promocod.'</td>
                  <td >'.date('d-m-Y',strtotime($costs->created_at)).'</td>
               
                  <td ><i class="fa fa-trash" onclick="deletecanalcpomocod('.$costs->id.')"></i> </td>


              </tr>';

        return $result;

    }


    public function generatecallback(){
        $status_call['CANCEL']='Вызов отменен';
        $status_call['ANSWER']='Отвечено';
        $status_call['NO ANSWER']='Без ответа';
        $status_call['ANSWERED']='Отвечено';
        $status_call['NOANSWER']='Без ответа';
        $status_call['CONGESTION']='Канал перегружен';
        $status_call['CHANUNAVAIL']='Канал недоступен';
        $status_call['BUSY']='Занято';
$companys=\DB::table('users_company')->get();

foreach ($companys as $company) {
    $data['phones_unic'] = Project::where('my_company_id', $company->id)->pluck('call_back_random_id')->where('created_aster_call','!=',1)->toArray();


    $data['input_calls'] = DB::connection('asterisk')->table('callback_calls')->wherein('callback_id', $data['phones_unic'])->orderby('id', 'desc') ->where('in_new_table', '!=', 1) ->get();

    foreach ($data['input_calls'] as $item) {


        $project = Project::where('my_company_id', $company->id)
            ->where('call_back_random_id', $item->callback_id)->first();
        $project->created_aster_call=1;
        $project->save();
        if ($data['phones_unic']) {
            $newdata=AsteriskCall::where('my_company_id',$company->id)->where('unique_id',$item->callback_id)->first();
            if(!$newdata) {

                $newdata = new AsteriskCall();
                $newdata->my_company_id = $company->id;
                $newdata->site_id = $project->site_id;
                $newdata->type = 1;
                $newdata->calldate = $item->calldate;
                $newdata->did = $project->phone;
                $newdata->src = '';
                $newdata->call_id = $item->id;
                $newdata->widget_id = $project->widget_id;
                $newdata->ogidanie = $item->duration - $item->billsec;
                $newdata->timing = $item->billsec;
                $newdata->unique_id = $item->callback_id;

                if (isset($status_call[$item->disposition])) {
                    $newdata->status = $status_call[$item->disposition];
                }
                $newdata->record = date('Y', strtotime($item->calldate)) . '/' . date('m', strtotime($item->calldate)) . '/' . date('d', strtotime($item->calldate)) . '/' . $item->record_file . '.mp3';
                $newdata->save();
                DB::connection('asterisk')->table('callback_calls')->where('id', '=', $item->id)->update(['in_new_table' => 1]);
            }else{

                if($item->record_file!=''){
                    $newdata->record = date('Y', strtotime($item->calldate)) . '/' . date('m', strtotime($item->calldate)) . '/' . date('d', strtotime($item->calldate)) . '/' . $item->record_file . '.mp3';
                    $newdata->save();
                    DB::connection('asterisk')->table('callback_calls')->where('id', '=', $item->id)->update(['in_new_table' => 1]);
                }



            }
        }
    }

}

    }
public function generatecalltrack(){
    $status_call['CANCEL']='Вызов отменен';
    $status_call['ANSWER']='Отвечено';
    $status_call['NO ANSWER']='Без ответа';
    $status_call['ANSWERED']='Отвечено';
    $status_call['NOANSWER']='Без ответа';
    $status_call['CONGESTION']='Канал перегружен';
    $status_call['CHANUNAVAIL']='Канал недоступен';
    $status_call['BUSY']='Занято';
    $companys=\DB::table('users_company')->get();

    foreach ($companys as $company) {
$infowid=[];
         $widget_array=Widgets::where('my_company_id',$company->id)->get();
         foreach ($widget_array as $wid){

            $infowid[$wid->id]=$wid;

         }




        $phones_unic = \App\Widgets_phone::where('my_company_id', $company->id)->select('input', 'created_at','widget_id')->get();
        foreach($phones_unic as $pc) {

            if(isset($infowid[$pc->widget_id])){

                $site=$infowid[$pc->widget_id]->sites_id;
            }else{
                $site=0;
            }

            $pc_created_at=$pc->created_at;
         try {
             if(is_null($pc_created_at)){
                 $inpcalls = DB::connection('asterisk')->table('calls')->where('in_new_table', '!=', 1)->where('did', $pc->input) ->orderby('id', 'desc')->get();
             }else{
                 $inpcalls = DB::connection('asterisk')->table('calls')->where('in_new_table', '!=', 1)->where('did', $pc->input)->where('calldate', '>', $pc_created_at)->orderby('id', 'desc')->get();
             }

         }catch (\Exception $e){
          dd($e);
         }
            $status_call['CANCEL'] = 'Вызов отменен';
            $status_call['ANSWER'] = 'Отвечено';
            $status_call['NO ANSWER'] = 'Без ответа';
            $status_call['ANSWERED'] = 'Отвечено';
            $status_call['NOANSWER'] = 'Без ответа';
            $status_call['CONGESTION'] = 'Канал перегружен';
            $status_call['CHANUNAVAIL'] = 'Канал недоступен';
            $status_call['BUSY'] = 'Занято';

            foreach ($inpcalls as $item) {

                $newdata = new AsteriskCall();
                $newdata->my_company_id =$company->id;
                $newdata->site_id = $site;
                $newdata->type = 0;
                $newdata->uploaded = 0;
                $newdata->calldate = $item->calldate;
                $newdata->did = $item->did;
                $newdata->src = $item->src;
                $newdata->call_id = $item->id;
                $newdata->widget_id = $pc->widget_id;
                $newdata->ogidanie = $item->duration - $item->billsec;
                $newdata->timing = $item->billsec;
                $newdata->status = $item->billsec;
                if (isset($status_call[$item->disposition])) {
                    $newdata->status = $status_call[$item->disposition];
                }
                $newdata->record = date('Y', strtotime($item->calldate)) . '/' . date('m', strtotime($item->calldate)) . '/' . date('d', strtotime($item->calldate)) . '/' . $item->record_file . '.mp3';
                $newdata->save();
                DB::connection('asterisk')->table('calls')->where('id', '=', $item->id)->update(['in_new_table' => 1]);
            }
        }

    }
}


    public function generatecallback_user(){
        $status_call['CANCEL']='Вызов отменен';
        $status_call['ANSWER']='Отвечено';
        $status_call['NO ANSWER']='Без ответа';
        $status_call['ANSWERED']='Отвечено';
        $status_call['NOANSWER']='Без ответа';
        $status_call['CONGESTION']='Канал перегружен';
        $status_call['CHANUNAVAIL']='Канал недоступен';
        $status_call['BUSY']='Занято';
        $companys=\DB::table('users_company')->where('id',auth()->user()->my_company_id)->get();

        foreach ($companys as $company) {
            $data['phones_unic'] = Project::where('my_company_id', $company->id)->pluck('call_back_random_id')->where('created_aster_call','!=',1)->toArray();


            $data['input_calls'] = DB::connection('asterisk')->table('callback_calls')->wherein('callback_id', $data['phones_unic'])->orderby('id', 'desc') ->where('in_new_table', '!=', 1) ->get();

            foreach ($data['input_calls'] as $item) {


                $project = Project::where('my_company_id', $company->id)
                    ->where('call_back_random_id', $item->callback_id)->first();
                $project->created_aster_call=1;
                $project->save();
                if ($data['phones_unic']) {

                    $newdata=AsteriskCall::where('my_company_id',$company->id)->where('unique_id',$item->callback_id)->first();
                    if(!$newdata) {

                        $newdata = new AsteriskCall();
                        $newdata->my_company_id = $company->id;
                        $newdata->site_id = $project->site_id;
                        $newdata->type = 1;
                        $newdata->uploaded = 0;
                        $newdata->calldate = $item->calldate;
                        $newdata->did = $project->phone;
                        $newdata->src = '';
                        $newdata->call_id = $item->id;
                        $newdata->widget_id = $project->widget_id;
                        $newdata->ogidanie = $item->duration - $item->billsec;
                        $newdata->timing = $item->billsec;
                        $newdata->unique_id = $item->callback_id;

                        if (isset($status_call[$item->disposition])) {
                            $newdata->status = $status_call[$item->disposition];
                        }
                        $newdata->record = date('Y', strtotime($item->calldate)) . '/' . date('m', strtotime($item->calldate)) . '/' . date('d', strtotime($item->calldate)) . '/' . $item->record_file . '.mp3';
                        $newdata->save();
                        DB::connection('asterisk')->table('callback_calls')->where('id', '=', $item->id)->update(['in_new_table' => 1]);
                    }else{

if($item->record_file!=''){
    $newdata->record = date('Y', strtotime($item->calldate)) . '/' . date('m', strtotime($item->calldate)) . '/' . date('d', strtotime($item->calldate)) . '/' . $item->record_file . '.mp3';
    $newdata->save();
    DB::connection('asterisk')->table('callback_calls')->where('id', '=', $item->id)->update(['in_new_table' => 1]);
}



                    }

                }
            }

        }

    }
    public function generatecalltrack_user(){
        $status_call['CANCEL']='Вызов отменен';
        $status_call['ANSWER']='Отвечено';
        $status_call['NO ANSWER']='Без ответа';
        $status_call['ANSWERED']='Отвечено';
        $status_call['NOANSWER']='Без ответа';
        $status_call['CONGESTION']='Канал перегружен';
        $status_call['CHANUNAVAIL']='Канал недоступен';
        $status_call['BUSY']='Занято';
        $companys=\DB::table('users_company')->where('id',auth()->user()->my_company_id)->get();

        foreach ($companys as $company) {
            $infowid=[];
            $widget_array=Widgets::where('my_company_id',$company->id)->get();
            foreach ($widget_array as $wid){

                $infowid[$wid->id]=$wid;

            }




            $phones_unic = \App\Widgets_phone::where('my_company_id', $company->id)->select('input', 'created_at','widget_id')->get();
            foreach($phones_unic as $pc) {

                if(isset($infowid[$pc->widget_id])){

                    $site=$infowid[$pc->widget_id]->sites_id;
                }else{
                    $site=0;
                }

                $pc_created_at=$pc->created_at;
                try {
                    if(is_null($pc_created_at)){
                        $inpcalls = DB::connection('asterisk')->table('calls')->where('in_new_table', '!=', 1)->where('did', $pc->input) ->orderby('id', 'desc')->get();
                    }else{
                        $inpcalls = DB::connection('asterisk')->table('calls')->where('in_new_table', '!=', 1)->where('did', $pc->input)->where('calldate', '>', $pc_created_at)->orderby('id', 'desc')->get();
                    }

                }catch (\Exception $e){
                    dd($e);
                }
                $status_call['CANCEL'] = 'Вызов отменен';
                $status_call['ANSWER'] = 'Отвечено';
                $status_call['NO ANSWER'] = 'Без ответа';
                $status_call['ANSWERED'] = 'Отвечено';
                $status_call['NOANSWER'] = 'Без ответа';
                $status_call['CONGESTION'] = 'Канал перегружен';
                $status_call['CHANUNAVAIL'] = 'Канал недоступен';
                $status_call['BUSY'] = 'Занято';

                foreach ($inpcalls as $item) {

                    $newdata = new AsteriskCall();
                    $newdata->my_company_id =$company->id;
                    $newdata->site_id = $site;
                    $newdata->uploaded = 0;
                    $newdata->type = 0;
                    $newdata->calldate = $item->calldate;
                    $newdata->did = $item->did;
                    $newdata->src = $item->src;
                    $newdata->call_id = $item->id;
                    $newdata->widget_id = $pc->widget_id;
                    $newdata->ogidanie = $item->duration - $item->billsec;
                    $newdata->timing = $item->billsec;
                    $newdata->status = $item->billsec;
                    if (isset($status_call[$item->disposition])) {
                        $newdata->status = $status_call[$item->disposition];
                    }
                    $newdata->record = date('Y', strtotime($item->calldate)) . '/' . date('m', strtotime($item->calldate)) . '/' . date('d', strtotime($item->calldate)) . '/' . $item->record_file . '.mp3';
                    $newdata->save();
                    DB::connection('asterisk')->table('calls')->where('id', '=', $item->id)->update(['in_new_table' => 1]);
                }
            }

        }
    }
public function insert_intable_aster($request){
    $user = Auth::user();
 
$this->generatecallback_user();
$this->generatecalltrack_user();
}



    public function get_inputcall($request){
       ;
        $this->insert_intable_aster($request);



$data['input_calls']=AsteriskCall::where('my_company_id',auth()->user()->my_company_id)->orderby('calldate','desc')->where('site_id',auth()->user()->site)->paginate(20);

          $datas['dat']= view("widgets.render.calltracking.inputcalltable",$data)->render();;
         $datas['pagin']= view("widgets.render.calltracking.pagin",$data)->render();;








return json_encode($datas);


    }
    public function get_inputcall_back($request){
        $user = Auth::user();


         $data['phones_unic'] = Project::where('my_company_id', $user->my_company_id) ->pluck('call_back_random_id')->toArray();
        $data['phones_unic']=array_unique($data['phones_unic']);
          $data['input_calls'] =  DB::connection('asterisk')->table('callback_calls')->wherein('callback_id', $data['phones_unic'])->where('shoulder','B')->orderby('id', 'desc')->paginate(20);


        $datas['dat']= view("widgets.render.callback.inputcalltable",$data)->render();;
        $datas['pagin']= view("widgets.render.calltracking.pagin",$data)->render();;

        return json_encode($datas);


    }
    public function billingphonesrecs($request){
        $BillingController=new BillingController();
        $user=Auth::user();
        $amountday=$BillingController->get_amount_day($request->hidden_end,$request->hidden_start);

        $number = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $data['tarif']=DB::table('tarifs')->where('id',$user->tarif)->first();
        $summ_day=round($data['tarif']->phone/$number,2);


        $minuta=$data['tarif']->minuta;
        $datas =$BillingController->get_tablica_calltrack($request->clients,date('Y-m-d',strtotime($request->hidden_start)),date('Y-m-d',strtotime($request->hidden_end)), $minuta,$request->tip);
        $datar['mytable']='  ';
        $datas['day']=$summ_day;
        $datas['tarif']=DB::table('tarifs')->where('id',$user->tarif)->first();
        $datas['month']= $data['tarif']->phone;
        if(!isset($datas['phones'])){ $datar['mytable']='  ';}else{
            $datar['mytable']=view('billing.mytable2',$datas)->render();}





        $datar['mysumm']=$datas['total_summ'];
        return json_encode($datar);
    }
    public function billingphones($request){
$BillingController=new BillingController();
$user=Auth::user();
         $amountday=$BillingController->get_amount_day($request->hidden_end,$request->hidden_start);

        $number = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $data['tarif']=DB::table('tarifs')->where('id',$user->tarif)->first();
           $summ_day=round($data['tarif']->phone/$number,2);

            $datas =$BillingController->get_tablica($request->clients,date('Y-m-d',strtotime($request->hidden_start)),date('Y-m-d',strtotime($request->hidden_end)),$amountday,$summ_day);
        $datar['mytable']='  ';
        $datas['day']=$summ_day;
        $datas['tarif']=DB::table('tarifs')->where('id',$user->tarif)->first();
        $datas['month']= $data['tarif']->phone;
if(count($datas['phones'])==0){ $datar['mytable']='  ';}else{
   $datar['mytable']=view('billing.mytable',$datas)->render();}





$datar['mysumm']=$datas['total_summ'];
return json_encode($datar);
    }

    public function deletecanal(Request $request){

        $user=Auth::user();

        $costId=DB::table('Costs')->where('id',$request->id)->where('my_company_id',$user->my_company_id)->delete();




        return '';
    }

    public function deletefast(Request $request){
        $user=Auth::user();



        $costId=DB::table('widgets_chat_fastotvet')->where('id',$request->id)->where('my_company_id',$user->my_company_id)->delete();



    }
    public function addfast(Request $request){
        $user=Auth::user();

        $widget=DB::table('widgets')->where('tip',12)->where('sites_id',$user->site)->first();

        $costId=DB::table('widgets_chat_fastotvet')->insertGetId([

            'my_company_id'=>$user->my_company_id,
            'widget_id'=>$widget->id,
            'name'=>$request->name,


        ]);


        $costs=DB::table('widgets_chat_fastotvet')->where('id',$costId)->first();


        $result=' <tr id="cost'.$costs->id.'">
                  <td >'.$costs->name.'</td>
                 
                  <td ><i class="fa fa-trash" onclick="deletefast('.$costs->id.')"></i> </td>


              </tr>';

        return $result;
    }

public function addcanal(Request $request){

$user=Auth::user();

    $costId=DB::table('Costs')->insertGetId([
   'site_id'=>$user->site,
   'my_company_id'=>$user->my_company_id,
   'canal_id'=>$request->cost_canal,
   'period_start'=>$request->cost_start_date,
   'period_end'=>$request->cost_end_date,
   'summ'=>$request->canal_summ,

]);

$canal=WidgetCanal::where('id',$request->cost_canal)->first();
$costs=DB::table('Costs')->where('id',$costId)->first();


$result=' <tr id="cost'.$costs->id.'">
                  <td >'.$canal->name.'</td>
                  <td >'.$costs->period_start.'</td>
                  <td >'.$costs->period_end.'</td>
                  <td >'.$costs->summ.'</td>
                  <td ><i class="fa fa-trash" onclick="deletecanal('.$costs->id.')"></i> </td>


              </tr>';
$period=$this->period_dat($costs->period_start,$costs->period_end);

$cost=$costs->summ/count($period);
    $ostatok=0;
if($costs->summ % count($period) >0){

    $ostatok   =$costs->summ % count($period);
    $cost=($costs->summ-$ostatok)/ count($period);
}





for($i=0;$i<count($period);$i++) {


    $metrika = new MetricaCurrent();

    $metrika = $metrika->setTable('metrica_' . $user->my_company_id);
    $metrika->key_user = '';
    $metrika->fd = '';
    $metrika->ep = '';
    $metrika->rf = '';
    $metrika->neiros_visit = 0;
    $metrika->typ = $canal->code;
    $metrika->mdm = '';
    $metrika->src = '';
    $metrika->cmp = '';
    $metrika->cnt = '';
    $metrika->trim = '';
    $metrika->uag = '';
    $metrika->visit = 0;
    $metrika->sdelka = 0;
    $metrika->lead = 0;
    $metrika->summ = 0;
    $metrika->promocod = '';
    $metrika->_gid = '';
    $metrika->_ym_uid = '';
    $metrika->olev_phone_track = '';
    $metrika->ip = '';
    $metrika->utm_source = '';
    $metrika->site_id = $user->site;
    $metrika->my_company_id = $user->my_company_id;
    $metrika->reports_date = $period[$i];
    $metrika->updated_at = date('Y-m-d H:i:s');
    $metrika->created_at = date('Y-m-d H:i:s');

    $metrika->bot = 0;
    if($i==0){
        $metrika->cost = $cost+$ostatok;
    }else{
        $metrika->cost = $cost;
    }

    $metrika->unique_visit = 0;
    $metrika->save();

}


return $result;
}

    public
    function period_dat($date_start,$date_end)
    {
        $period = new DatePeriod(
            new DateTime($date_start),
            new DateInterval('P1D'),
            new DateTime($date_end . ' 23:59:59')
        );
        $arr = [];
        foreach ($period as $key => $value) {
            $arr[] = $value->format('Y-m-d');
        }
        return $arr;
    }
    public function payschet($id){
       $data['status']='';
       $data['solor']='';
       $data['message']='';
       $user=Auth::user();
       if($user->super_admin!=1){

           $data['status']=0;
           $data['color']='danger';
           $data['message']='Оплачивать счет может только админ';
          return json_encode($data);
       }

       $get_chek=\App\Checkcompanys::where('id',$id)->where('status',0)->first();
       if($get_chek){



$get_company=DB::table('users_company')->where('id',$get_chek->my_company_id)->first();
if($get_company){
    $sum=$get_company->ballans+$get_chek->summ;
    DB::table('users_company')->where('id',$get_chek->my_company_id)->update([
        'ballans'=>$sum
    ]);

    $user=User::where('is_first_reg',1)->where('my_company_id',$get_chek->my_company_id)->where('partner_id','>',0)->first();
    if($user){
     $this->parntet_pay($user,$get_chek->summ);
    }

    \App\Checkcompanys::where('id',$id)->update(['status'=>1]);
    $data['status']=1;
    $data['color']='success';
    $data['message']='На счет компании '.$get_company->name.' зачислено '.$get_chek->summ.' руб';
    return json_encode($data);
}else{

    $data['status']=0;
    $data['color']='danger';
    $data['message']='Ошибка оплаты, Компания клиента не существует';
    return json_encode($data);



}

       }else{
           $data['status']=0;
           $data['color']='danger';
           $data['message']='Ошибка оплаты, счет не существует, либо оплачен';
           return json_encode($data);


       }







    }

    public function parntet_pay($user,$summ){
$parent=User::with('partners')->find($user->partner_id);
if($parent){
   $count_partnet=count($parent->partners->where('is_active',1));
    $percent=0.3;

    if($count_partnet<3){
       $percent=0.2;
   }
    if($count_partnet>=5){
        $percent=0.35;
    }

    $nach=round($summ*$percent,2);

    $pay=new PartnersClientPay();
    $pay->user_id=$parent->id;
    $pay->partner_id=$user->id;
    $pay->summ=$nach;
    $pay->save();
}


    }


    public function wchat_save($data)
    {
        unset($data['_token']);
$user=Auth::user();
        Widgets::where('my_company_id', $user->my_company_id)->where('id', $data['widget_id'])->update([
            'status' => $data['status']
        ]);


        unset($data['status']);
        $Widgets_chat = new Widgets_chat();
        $Widgets_chat->where('id', $data['id'])->update($data);
        $Widgets_chat->where('id', $data['id'])->update($data);
    }

    public function get_dialog($id)
    {
        $data['audios'] = DB::table('input_call_text')->where('in_id', $id)->orderby('timers', 'asc')->get();

        return view('modal.dialog', $data)->render();

    }

    public function edit_routing_get($ids, $widget_id)
    {

        $user = Auth::user();


        $widget=Widgets::where('my_company_id',$user->my_company_id)->where('sites_id',$user->site)->pluck('id');


        $widget_call_track  = DB::table('widget_call_track')->wherein('widget_id', $widget)->where('my_company_id', $user->my_company_id)->first();
        $widget_calltrack_regions = DB::table('widget_calltrack_region')->get();


        if($ids>0) {
            $rout = DB::table('widgets_phone_routing')->where('id', $ids)->where('my_company_id', $user->my_company_id)->first();
        }

        $roistatm = Widgets::where('my_company_id', $user->my_company_id)->where('status', 1)->where('sites_id', $user->site)->where('tip', 18)->first();
        $roistat = 0;
        if ($roistatm) {
            $roistat = 1;
        }
        $witget_canals=WidgetCanal::where('site_id',0)->orwhere('site_id',$user->site)->get();
        if($ids>0) {
            $all_class_replace=json_decode($rout->all_class_replace);
$routecanal=json_decode($rout->canals);
            return view('widgets.render.calltracking.nes_scenarii_edit', compact('rout', 'widget_call_track', 'widget_calltrack_regions', 'roistat', 'witget_canals','all_class_replace','routecanal'));
        }else{
            return view('widgets.render.calltracking.nes_scenarii', compact( 'widget_call_track', 'widget_calltrack_regions', 'roistat', 'witget_canals'));

        }

    }
    public function load_free_numbers3($widget_id,$id)
    {
        $user = Auth::user();

        $widget=Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 2)->first();
        $free_phones = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('my_company_id', $user->my_company_id)->where(function ($query) use ($id){
            $query->orwhere('routing', 0)->orwhere('routing', $id);


        })->get();
        $text = '';
        foreach ($free_phones as $free_phone) {

if($free_phone->routing==0){

    $che='';
}else{
    $che="checked";
}
            $text .= '<li><label class="add-number-new-checkbox">' . $free_phone->input . '
                                                            <input type="checkbox"  name="ar_number[]" value="' . $free_phone->input . '" '.$che.'>
                                                            <span class="checkmark"></span>
                                                        </label></li>


 ';

        }




        return $text;

    }
    public function load_free_numbers($widget_id)
    {
        $user = Auth::user();

        $widget=Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 2)->first();
        $free_phones = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('my_company_id', $user->my_company_id)->where('routing', 0)->get();
        $text = '';
        foreach ($free_phones as $free_phone) {


            $text .= '<li><label class="add-number-new-checkbox">' . $free_phone->input . '
                                                            <input type="checkbox"  name="ar_number[]" value="' . $free_phone->input . '">
                                                            <span class="checkmark"></span>
                                                        </label></li>


 ';

        }




        return $text;

    }

    public function delete_from_routing($numbers)
    {
        $user = Auth::user();
        $AsteriskController = new AsteriskController();
        for ($i = 0; $i < count($numbers); $i++) {

            $prov = DB::table('widgets_phone')->where('my_company_id', $user->my_company_id)->where('input', $numbers[$i])->first();
            if ($prov) {


                DB::table('widgets_phone')->where('my_company_id', $user->my_company_id)->where('input', $numbers[$i])->update([
                    'tip' => 0,
                    'rezerv' => 0,
                    'routing' => 0

                ]);

                $AsteriskController->deletete_number($numbers[$i]);

            }


        }
    }

    public function delete_routiing_calltrack($ids)
    {
        $user = Auth::user();

        DB::table('widgets_phone_routing')->where('id', $ids)->where('my_company_id', $user->my_company_id)->delete();


        DB::table('widgets_phone')->where('my_company_id', $user->my_company_id)->where('routing', $ids)->update([
            'tip' => 0,
            'rezerv' => 0,
            'routing' => 0

        ]);
        $AsteriskController = new AsteriskController();
        $AsteriskController->deletete_number_from_rout($ids);
    }

    public function uploadfilechatavatar($request)
    {

        $user = Auth::user();
        return ServiceCodes::uploadFile($request[0], ['image' => 'image'], 'user_upload', $user->my_company_id);
    }

    public function get_operator($id)
    {


        $data = Widgets_chat_url_operator::where('id', $id)->first();
        return json_encode($data);
    }

    public function safe_operator($request)
    {
        $user=Auth::user();
        /*INSERT INTO `widgets_chat_url_operator`(`id`, `widget_id`, `operator_id`, `updated_at`, `created_at`, `first_message`, `logo`, `operator_name`, `timer`, `job`, `url`) */
        /*  datatosend={
            url_modal:$('#url_modal').val(),
            operator_name_modal:$('#operator_name_modal').val(),
            job_modal:$('#job_modal').val(),
            id_modal:$('#id_modal').val(),


            timer_modal:$('#timer_modal').val(),
              }*/
        $data['widget_id'] = $request->widget_id;

        $wid=Widgets::find( $request->widget_id);

        $data['operator_id'] = 0;
        $data['first_message'] = $request->first_message_modal;
        $data['logo'] = $request->logo_modal;
        $data['timer'] = $request->timer_modal;
        $data['job'] = $request->job_modal;
        $data['operator_name'] = $request->operator_name_modal;
        $data['url'] = $request->url_modal;
        $data['my_company_id'] = $user->my_company_id;
if( $data['timer'] ==''){
    $data['timer'] =0;
}
        if ($request->id_modal == 0) {
            Widgets_chat_url_operator::insert($data);


        } else {
            Widgets_chat_url_operator::where('id', $request->id_modal)->update($data);


        }


    }
    public function widget_api_routers(Request $request)
    {







        $data=json_decode($json );



        for($i=0;$i<count($data->offer); $i++) {


            $item=$data->offer[$i];

            $information = new Data([
                'type'           => $item->type,
                'property-type'  => $item->{'property-type'},
                'category'       => $item->category,
                'url'            => $item->url,
                'country'        => $item->location->country,
                'locality-name'  => $item->location->{'locality-name'},
                'address'        => $item->location->address,
                'price-value'    => $item->price->value,
                'price-currency' => $item->price->currency,
                'organization'   => $item->{'sales-agent'}->organization,
                'floor'          => $item->floor,
                'area-value'     => $item->area->value,
                'area-unit'      => $item->area->unit,
                'building-name'  => $item->{'building-name'},
                'image'          => $item->image,
            ]);
            $information->save();
        }

    }
}
