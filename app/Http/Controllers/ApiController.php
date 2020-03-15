<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Api\GaCallController;
use App\Models\Servies\BlackListNeirosIds;
use App\Models\Settings\CompanyDefaultSetting;
use App\Models\Widgets\WidgetCallbackRouting;
use App\Widgets;
use Meiji\YandexMetrikaOffline\Conversion;
use App\Http\Controllers\Api\RoistatController;
use App\Http\Controllers\Api\WidgetApiController;
use App\Http\Controllers\WidgetChatController;
use App\Project_log;
use DB;
use Illuminate\Http\Request;
use Log;
use App\Project;
use DateTime;
use App\Models\Logging\CallBacks;
class ApiController extends Controller
{
protected $is_catch=0;
    public $new_project_id=0;

    public function gdrive(){

    }

public function fromasteraudio(){
info(request()->all());
info('myaudio');
    return 'ok';
}

    public function tilda($key)
    {

        $param = request()->all();

        if (isset($param['Name'])) {
            $name = $param['Name'];
        }
        if (isset($param['Phone'])) {
            $phone = $param['Phone'];
        }
if(isset($param['COOKIES'])){
    $cook=explode('; ',$param['COOKIES']);info($cook);
for($i=0;$i<count($cook);$i++){


    $f=explode('=',$cook[$i]);info($f);

        if(isset($f[0])){


            if($f[0]=='neiros_visit_v1'){
                info('find1');
                $neiros_visit=$f[1];
            }

            $pos = strpos( $f[0],'neiros_visit_v1');
            if ($pos === false) {

            } else {
                if(isset($f[1])){



                info('find');
                $neiros_visit=$f[1];


                }



            }



        }


    }




}






        $site = DB::table('sites')->where('hash', $key)->first();
        if (!$site) {
            Log::info('Error site');
            return '1';
        }



        $widget_tilda =Widgets::where('sites_id', $site->id)->where('status',1)->where('tip', 27)->first();
        if (!$widget_tilda) {
            Log::info('Error widget');
            return 'error02';

        }

        $widget =Widgets::where('sites_id', $site->id)->where('tip', 3)->first();
        if (!$widget) {
            Log::info('Error widget');
            return 'error02';

        }


        if(!isset($neiros_visit)){
            Log::info('Error widget neiros widget');    return'';
        }
        if(!isset($phone)){
            Log::info('Error widget neiros phone');   return'';
        }
        $data_w['phone']=$phone;
        $data_w['email']='';;
        $data_w['fio']=$name;
        $data_w['phone']=$this->format_phone($data_w['phone']);

        $block=BlackListNeirosIds::where('neiros_visit',$neiros_visit)->first();
        if($block){
info(911);
            return '911';
        }

            $data_w['neiros_visit'] = $neiros_visit;

            if ($widget->params['callback'] == 1) {

                $widget_for_call = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 1)->first();
                $data_w['widget']=$widget_for_call;
                $data_w['gl_wid']=$widget;
                $this->callback_form($data_w);


            } else {
                $WidgetApiController = new WidgetApiController();
                $getallwid = Project::where('widget_id', $widget->id)->count();
                $getallwid++;
                $projectId = $WidgetApiController->create_lead([
                    'name' => 'Заявка с форм № ' . $getallwid,
                    'stage_id' => $widget->stage_id,
                    'user_id' => $widget->user_id,
                    'summ' => 0,
                    'comment' => $widget->name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'fio' => '',
                    'company' => '',
                    'widget_id' => $widget->id,
                    'sub_widget' => 'callback_form',
                    'my_company_id' => $widget->my_company_id,
                    'neiros_visit' => $data_w['neiros_visit'],
                    'vst' => 0,
                    'pgs' => 0,
                    'url' => '',
                    'site_id' => $widget->sites_id,
                    'week' => date("W", time()),
                    'hour' => date("H", time())
                ], $data_w);;
            }

        //    }

        header('Access-Control-Allow-Origin:*');
        $responsea = "(" . json_encode('') . ")";
        return $responsea;



    }

    public function myasterwebhock(Request $request){

        $roistat_api=new RoistatController();
        $roistat_api->get_data_from_webhook($request->all());

        $ga_api=new GaCallController();

        $ga_api->get_data_from_webhook($request->all());

    }
    public function route_widget($apitouter, $devise, $hash, $widget, Request $request)
    {
        $re = $request->apitouter;
        $WidgetChatController = new WidgetChatController();;
        switch ($re) {
            case 'catch_lead':

                return $WidgetChatController->catch_lead(['request' => $request, 'devise' => $devise, 'hash' => $hash, 'widget' => $widget]);

                break;
        }


    }

    public function ajax_form($key,Request $request)
    {
/*  '{"neiros_visit":null,"type":"event","name_event":"test-event","data_event":{"type":"form","data":{"name":"test","email":"test@mail_ru","phone":"test"}}}' => NULL,
)
[2019-08-27 22:59:51] production.INFO: 3f188daa3e3a9527fdd3273aa883fbeb_47  */







        $neiros_key = '';
        $neiros_hash = '';
        $data_w = [];


        $site = DB::table('sites')->where('hash', $key)->first();
        if (!$site) {
            Log::info('Error site');
            return '1';
        }

        $widget =Widgets::where('sites_id', $site->id)->where('tip', 3)->where('status', 1)->first();
      if (!$widget) {
            Log::info('Error widget');
            return 'error02';

        }




$datainput=json_decode($request->data);

if(!isset($datainput->data_event)){
    return '';
}
        $data_w['phone']=isset($datainput->data_event->data->phone)?$datainput->data_event->data->phone:'';
        $data_w['email']=isset($datainput->data_event->data->email)?$datainput->data_event->data->email:'';;
        $data_w['fio']=isset($datainput->data_event->data->name)?$datainput->data_event->data->name:'';;
        $data_w['phone']=$this->format_phone($data_w['phone']);

        $block=BlackListNeirosIds::where('neiros_visit',$datainput->neiros_visit)->first();
        if($block){

             return '911';
        }
if($widget->params['create_lead']==1) {
    $data_w['neiros_visit'] = $datainput->neiros_visit;

    if ($widget->params['callback'] == 1) {

        $widget_for_call = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 1)->first();
        $data_w['widget']=$widget_for_call;
        $data_w['gl_wid']=$widget;
        $this->callback_form($data_w);


    } else {
        $WidgetApiController = new WidgetApiController();
        $getallwid = Project::where('widget_id', $widget->id)->count();
        $getallwid++;
        $projectId = $WidgetApiController->create_lead([
            'name' => 'Заявка с форм № ' . $getallwid,
            'stage_id' => $widget->stage_id,
            'user_id' => $widget->user_id,
            'summ' => 0,
            'comment' => $widget->name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'fio' => '',
            'company' => '',
            'widget_id' => $widget->id,
            'sub_widget' => 'callback_form',
            'my_company_id' => $widget->my_company_id,
            'neiros_visit' => $data_w['neiros_visit'],
            'vst' => 0,
            'pgs' => 0,
            'url' => '',
            'site_id' => $widget->sites_id,
            'week' => date("W", time()),
            'hour' => date("H", time())
        ], $data_w);;
   $this->create_email_notifi($projectId);
    }
}
    //    }




        header('Access-Control-Allow-Origin:*');
        $responsea = "(" . json_encode('') . ")";
        return $responsea;
    }
public function create_email_notifi($project_id){

   $project=Project::find($project_id);
   if(!$project){return '';}
    $widget_to_sand = Widgets::where('tip', 1)
        ->where('sites_id', $project->site_id)->first();
   if(!$widget_to_sand){
       return '';
   }
     $widget_callback = DB::table('widget_callback')->where('widget_id', $widget_to_sand->id)->first();
   if(!$widget_callback){
       return '';
   }


    $subject = 'Запрос обратного звонка ' . $widget_to_sand->site;
    $text = '<table style="width: 400px">
<tr>
<td>№ Сделки</td>
<td>' . $project->client_project_id . '</td>
</tr>
<tr>
 
<tr>
<td>Телефон</td>
<td>' . $project->phone . '</td>
</tr>
 
<td>Время заявки</td>
<td>' . date(' H:i:s d.m.y') . '</td>
</tr>
</table>';

        if ($widget_callback->dop_form_email_status == 1) {
            $WidgetApiController=new WidgetApiController();
            $WidgetApiController->send_email($widget_callback->dop_form_email, $subject, $text);
        }




}
    /*eiros_hash_fields`(`id`, `field`, `tip`, `widget_id`, `site_id`, `my_company_id`, `updated_at`, `created_at`)*/

    public function callback_form($data_w)
    {
        $model_log=new CallBacks();

        $model_log->save();





        $pnone_email['phone'] = $data_w['phone'];
        $pnone_email['sub_widget'] = 'form_callback';
        //    $pnone_email['hash'] = $data_w['hash'];
        if (isset($data_w['fio'])) {
            $pnone_email['fio'] = $data_w['fio'];

        }

        $widget_chat = DB::table('widget_callback')->where('widget_id', $data_w['widget']->id)->first();
        //  if ($widget_chat->create_project == 1) {
        Log::info('Создать сделку');


        $random_id = rand(11111, 99999);

        $random_id = $widget_chat->my_company_id . $widget_chat->id . $random_id;
        $model_log->random_id=$random_id;
        $model_log->my_company_id=$widget_chat->my_company_id;
        $model_log->step=1;
        $model_log->save();

        $model_log->phone= $data_w['phone'];
        $model_log->step=2;
        $model_log->save();


        $pnone_email['call_back_random_id'] = $random_id;
        //$pnone_email['neiros_url_vst'] = $data_w['neiros_url_vst'];

        $pnone_email['uniqueid'] = $random_id;
        $pnone_email['uniqueid'] =  'Заявка с форм ' ;


        $block=BlackListNeirosIds::where('neiros_visit',$data_w['neiros_visit'])->first();
        if($block){

            return '911';
        }


        $WidgetApiController = new WidgetApiController();
        $pr_id=$WidgetApiController->create_project('neiros_visit', $data_w['neiros_visit'], $data_w['gl_wid'], $pnone_email);
        $this->create_email_notifi($pr_id);
        //  }
        $model_log->project_id=$pr_id;
        $model_log->step=3;
        $model_log->save();
$this->new_project_id=$pr_id;
        $user=DB::table('users')->where('my_company_id',$widget_chat->my_company_id)->first();
        if($user->is_active!=1){

            $model_log->comment= 'Юсер нот актив';
            $model_log->step=5;
            $model_log->save();
            return '';


        }

        /*+7 (953) 098-69-97*/
        $phone =$pnone_email['phone'] ;

        if ($widget_chat->callback_tip == 0) {
            $tocall = 'SIP/runexis/' . $widget_chat->callback_phone0;
        }
        if ($widget_chat->callback_tip == 1) {
            $tocall = 'SIP/' . $widget_chat->callback_phone1;
        }
        if ($widget_chat->callback_tip == 2) {
            $tocall = 'SIP/' . $widget_chat->callback_phone2;
        }


        $sendArray=$this->get_array_to_aster($random_id,$widget_chat,$phone,$tocall);
//
        $weekday[1] = 'Понедельник';
        $weekday[2] = 'Вторник';
        $weekday[3] = 'Среда';
        $weekday[4] = 'Четверг';
        $weekday[5] = 'Пятница';
        $weekday[6] = 'Суббота';
        $weekday[7] = 'Воскресенье';

        $datavivod1['day'] = '';


        $timestart1 = 0;
$mega=Widgets::find($widget_chat->widget_id);
        $time_work = DB::table('widget_callback_worktime')->where('sites_id', $mega->sites_id)
            ->where('my_company_id', $widget_chat->my_company_id)->where('is_work', 1)->get();
        $datarr = [];
        foreach ($time_work as $time_w) {

            $datarr[$time_w->day] = $time_w;


        }
        $wChat=new WidgetChatController();


        $datavivod1 = $wChat->get_first_day($datarr, $weekday);
        if ($datavivod1['day'] !== date('N')) {


           $off = 1;
        } else {
            $off = 0;
            if((int)date('H')>(int)$datavivod1['hour_end']){$data['off']=1;}
            if((int)date('H')<(int)$datavivod1['hour']){$data['off']=1;}
        }



if($phone{0}==7) {
    if ($off == 0) {
        $http_response = $this->send_to_aster($sendArray, $model_log);
    }
    return 'ok'.$off;
}
    }


    public function prov_field($field, $widget_id, $site_id, $my_company_id, $val)
    {
        $prov = DB::table('neiros_hash_fields')->where([
            'field' => $field,
            'widget_id' => $widget_id,
            'site_id' => $site_id,
            'my_company_id' => $my_company_id,

        ])->first();
        if ($prov) {

            return $prov->tip;


        } else {
            DB::table('neiros_hash_fields')->insert([
                'field' => $field,
                'widget_id' => $widget_id,
                'site_id' => $site_id,
                'my_company_id' => $my_company_id,
                'xval' => $val,

            ]);

            return null;
        }


    }

    public function callback(Request $request)
    {
        $model_log=new CallBacks();
        $model_log->save();
        if ($request->apikey == '') {
            Log::info('Errorkey');
            return '0-Errorkey';

        }
        $user = DB::table('users')->where('apikey', $request->apikey)->first();
        if (!$user) {
            Log::info('Error user');
            return '2 Error user';
        }


        $site = DB::table('sites')->where('hash', $request->site)->first();
        if (!$site) {
            Log::info('Error site');
            return 'error01-Error site.' . $request->site;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 12)->first();
        if (!$widget) {
            Log::info('Error widget');
            return 'error02 Error site';

        }
        $random_id=rand(11111,99999);

        $random_id=$widget->my_company_id.$site->id.$random_id;
        $model_log->random_id=$random_id;
        $model_log->step=1;
        $model_log->save();

        $pnone_email['phone'] =$this->format_phone( $request->phone);
        $model_log->phone= $request->phone;
        $model_log->step=1;
        $model_log->save();


        $pnone_email['sub_widget'] = 'callback';
        $pnone_email['promocod'] = $request->promo;
        $pnone_email['uniqueid'] = $random_id;

        $project_id=0;
        $widget_chat = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();


        $block=BlackListNeirosIds::where('neiros_visit',$request->user_hash)->first();
        if($block){

            return '911';
        }


        if ($widget_chat->create_project == 1) {
            Log::info('Создать сделку');
            $WidgetApiController = new WidgetApiController();
            $project_id=$WidgetApiController->create_project('hash', $request->user_hash, $widget, $pnone_email);
        }
Log::info('stepok 2');
        $model_log->project_id=$project_id;
        $model_log->step=2;
        $model_log->save();
        /*+7 (953) 098-69-97*/
        $phone =$this->format_phone( $request->phone);;




        if ($widget_chat->callback_tip == 0) {
            $tocall = 'SIP/runexis/' . $widget_chat->callback_phone0;
        }
        if ($widget_chat->callback_tip == 1) {
            $tocall = 'SIP/' . $widget_chat->callback_phone1;
        }
        if ($widget_chat->callback_tip == 2) {
            $tocall = 'SIP/' . $widget_chat->callback_phone2;
        }
        $this->new_project_id=$project_id;
        $sendArray=$this->get_array_to_aster($random_id,$widget_chat,$phone,$tocall);
        $model_log->array_call=json_encode($sendArray);
        $model_log->step=3;
        $model_log->save();
//print_r($sendArray);
        $user=DB::table('users')->where('my_company_id',$widget_chat->my_company_id)->first();
        if($user->is_active!=1){
            return ' Error is_active  ';
        }


        $wChat=new WidgetChatController();
        $mega=Widgets::find($widget_chat->widget_id);
        $time_work = DB::table('widget_callback_worktime')->where('sites_id',$mega->sites_id)
            ->where('my_company_id', $widget_chat->my_company_id)->where('is_work', 1)->get();
        $datarr = [];
        foreach ($time_work as $time_w) {

            $datarr[$time_w->day] = $time_w;


        }
        $weekday[1] = 'Понедельник';
        $weekday[2] = 'Вторник';
        $weekday[3] = 'Среда';
        $weekday[4] = 'Четверг';
        $weekday[5] = 'Пятница';
        $weekday[6] = 'Суббота';
        $weekday[7] = 'Воскресенье';

        $datavivod1 = $wChat->get_first_day($datarr, $weekday);
        if ($datavivod1['day'] !== date('N')) {


            $off = 1;
        } else {
            $off = 0;
            if((int)date('H')>(int)$datavivod1['hour_end']){$data['off']=1;}
            if((int)date('H')<(int)$datavivod1['hour']){$data['off']=1;}
        }
if($off==0){
        $http_response=$this->send_to_aster($sendArray,$model_log);
    }


        return 'ok';

    }


    public function form_call_v1_old(Request $request)
    {


        $WidgetApiController = new WidgetApiController();
        $site = DB::table('sites')->where('hash', $request->widget_key)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', $request->tip)->first();
        if (!$widget) {
            return 'error02';

        }


        $projectId = 0;
        $pnone_email['phone'] =$this->format_phone( $request->phone);;;
        $pnone_email['sub_widget'] = 'callback_form_old';

        $pnone_email['neiros_visit'] = $request->neiros_visit;

        $pnone_email['comment'] = 'Заказ звонка ';

        $widget_chat = DB::table('widget_callback')->where('widget_id', $widget->id)->first();
        $block=BlackListNeirosIds::where('neiros_visit',$request->neiros_visit)->first();
        if($block){

            return '911';
        }


        $projectId = $WidgetApiController->create_project('hash', $request->neiros_visit, $widget, $pnone_email);


        $subject = 'Запрос обратного звонка ' . $widget->site;
        $text = '<table style="width: 400px">
<tr>
<td>№ Сделки</td>
<td>101' . $widget->my_company_id . '' . $projectId . '</td>
</tr>
<tr>
 
<tr>
<td>Телефон</td>
<td>' . $request->phone . '</td>
</tr>
 
<td>Время заявки</td>
<td>' . date(' H:i:s d.m.y') . '</td>
</tr>
</table>';
        $WidgetApiController->send_email($widget_chat->dop_form_email, $subject, $text);
        $all = $request->all();

        header('Access-Control-Allow-Origin:*');
        $datam['ans'] = true;
        echo "(" . json_encode($datam) . ")";

        //  return $responsea;


    }

    public function form_mail_v1_old(Request $request)
    {
        $WidgetApiController = new WidgetApiController();
        $site = DB::table('sites')->where('hash', $request->widget_key)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 1)->first();
        if (!$widget) {
            return 'error02';

        }


        $projectId = 0;
        $pnone_email['phone'] =$this->format_phone( $request->phone);;;
        $pnone_email['sub_widget'] = 'callback_form_old';
        $pnone_email['email'] = $request->email;
        $pnone_email['fio'] = $request->name;
        $pnone_email['neiros_visit'] = $request->neiros_visit;

        $pnone_email['comment'] = $request->text . '    ' . $request->date . ' в ' . $request->time;
        $widget_chat = DB::table('widget_callback')->where('widget_id', $widget->id)->first();

        $block=BlackListNeirosIds::where('neiros_visit',$request->neiros_visit)->first();
        if($block){

            return '911';
        }
        $projectId = $WidgetApiController->create_project('neiros_visit', $request->neiros_visit, $widget, $pnone_email);


        $subject = 'Оставить сообщение ' . $widget->site;
        $text = '<table style="width: 400px">
<tr>
<td>№ Сделки</td>
<td>101' . $widget->my_company_id . '' . $projectId . '</td>
</tr>
<tr>
 
<tr>
<td>Email</td>
<td>' . $request->email . '</td>
</tr>
<tr>
<td>Имя</td>
<td>' . $request->name . '</td>
</tr>
 <tr>
<td>Сообщение</td>
<td>' . $request->text . '</td>
</tr>
<td>Время заявки</td>
<td>' . date(' H:i:s d.m.y') . '</td>
</tr>
</table>';
        $WidgetApiController->send_email($widget_chat->dop_form_email, $subject, $text);
        $all = $request->all();

        header('Access-Control-Allow-Origin:*');
        $datam['ans'] = true;
        echo "(" . json_encode($datam) . ")";

        //  return $responsea;


    }


    public function form_call_v1(Request $request)
    {

        $site = DB::table('sites')->where('hash', $request->site)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }

        $widget_to_sand = Widgets::where('tip', 1)
            ->where('sites_id', $site->id)->first();
        if ($widget_to_sand) {
            $widget_callback = DB::table('widget_callback')->where('widget_id', $widget_to_sand->id)->first();
        }

        if (isset($request->tip)) {
            $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', $request->tip)->first();
            $widget_chat = DB::table('widget_callback')->where('widget_id', $widget->id)->first();
        } else {
            $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 12)->first();
            $widget_chat = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();
        }

        if (!$widget) {
            return 'error02';

        }
        if (isset($request->ab)) {
            if ($request->ab > 0) {
                DB::table('widget_catch_lead_ab')->where('id', $request->ab)->increment('leads');
            }
        }
        $projectId = 0;

        if (!isset($request->day)) {
            $todate = date('Y-m-d', strtotime($request->date));
            $tim = $request->time;
        } else {
            try {
                $dte = $this->findNearestDayOfWeek(new DateTime(date('Y-m-d') . 'T10:00:01.0000000Z'), $request->day);

                $todate = $dte->format('Y-m-d');
                $tim = $request->time . ":00:00";
            } catch (\Exception $e) {
                $todate = date('Y-m-d', strtotime($request->day));
                $tim = $request->time . ":00";
            }


        }

        $pnone_email['phone'] = $this->format_phone($request->phone);;;
        $pnone_email['sub_widget'] = 'callback_later';
        $pnone_email['promocod'] = $request->promo;
        $pnone_email['neiros_visit'] = $request->neiros_visit;
        $pnone_email['comment'] = 'Заказ звонка   ' . $todate . ' в ' . $request->time . ':00';

        $block = BlackListNeirosIds::where('neiros_visit', $request->neiros_visit)->first();
        if ($block) {

            return '911';
        }
        $WidgetApiController = new WidgetApiController();


        $projectId = $WidgetApiController->create_project('neiros_visit', $request->neiros_visit, $widget, $pnone_email);


        DB::table('widget_callback_later')->insert([
            'my_company_id' => $widget->my_company_id,
            'site_id' => $site->id,
            'widget_id' => $widget->id,
            'time_to_call' => strtotime($todate . ' ' . $tim),
            'phone' => $this->format_phone($request->phone),
            'project_id' => $projectId,
            'status'=>0



        ]);

        Project_log::insert(
            [
                'project_id' => $projectId,
                'info' => 'Заказ обратного звонка на ' . date('d.m.Y H:i', strtotime($todate . ' ' . $tim)),
                'created_at' => date("Y-m-d H:i:s", time()),
                'user_id' => 0,
                'my_company_id' => $widget->my_company_id
            ]
        );

$pro=Project::find($projectId);
        $subject = 'Запрос обратного звонка ' . $widget->site;
        $text = '<table style="width: 400px">
<tr>
<td>№ Сделки</td>
<td>' . $pro->client_project_id . '</td>
</tr>
<tr>
 
<tr>
<td>Телефон</td>
<td>' . $request->phone . '</td>
</tr>
<tr>
<td>Перезвонить</td>
<td>  ' . date('d.m.Y H:i', strtotime($todate . ' ' . $tim)) . '</td>
</tr>
<td>Время заявки</td>
<td>' . date(' H:i:s d.m.y') . '</td>
</tr>
</table>';
        if ($widget_callback) {
            if ($widget_callback->dop_form_email_status == 1) {

            $WidgetApiController->send_email($widget_callback->dop_form_email, $subject, $text);
        }
    }

        header('Access-Control-Allow-Origin:*');
        $data['ans'] = 'true';

        echo '';
        //  return $responsea;


    }
    public function findNearestDayOfWeek(\DateTime $date, $dayOfWeek_in)
    {

        $datearr[1]='Monday';
        $datearr[2]='Tuesday';
        $datearr[3]='Wednesday';
        $datearr[4]='Thursday';
        $datearr[5]='Friday';
        $datearr[6]='Saturday';
        $datearr[7]='Sunday';

        $dayOfWeek=$datearr[$dayOfWeek_in];

        $dayOfWeek = ucfirst($dayOfWeek);
        $daysOfWeek = array(
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        );
        if(!in_array($dayOfWeek, $daysOfWeek)){

            throw new \InvalidArgumentException('Invalid day of week:'.$dayOfWeek);
        }
        if($date->format('l') == $dayOfWeek){

            return $date;
        }

        $previous = clone $date;
        $previous->modify('last '.$dayOfWeek);

        $next = clone $date;
        $next->modify('next '.$dayOfWeek);

        $previousDiff = $date->diff($previous);
        $nextDiff = $date->diff($next);

        $previousDiffDays = $previousDiff->format('%a');
        $nextDiffDays = $nextDiff->format('%a');

        if($previousDiffDays < $nextDiffDays){

            return $next;
        }

        return $next;
    }
public function sendcall_to_aster(Request $request){
    $model_log=new CallBacks();

    $model_log->save();

        $site = DB::table('sites')->where('hash', $request->site)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }

        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', $request->tip)->first();
        if (!$widget) {
            return 'error02';

        }

        $random_id=rand(11111,99999);

        $random_id=$widget->my_company_id.$site->id.$random_id;
    $model_log->random_id=$random_id;
    $model_log->my_company_id=$widget->my_company_id;
$model_log->step=1;
    $model_log->save();


        $pnone_email['phone'] = $this->format_phone( $request->phone);
        $pnone_email['sub_widget'] = 'callback';
        $pnone_email['promocod'] = $request->promo;
        $pnone_email['call_back_random_id'] = $random_id;
        $pnone_email['neiros_visit'] = $request->neiros_visit;
    $block=BlackListNeirosIds::where('neiros_visit',$request->neiros_visit)->first();
    if($block){

        return '911';
    }
    $model_log->phone=$this->format_phone( $request->phone);;;
    $model_log->step=2;
    $model_log->save();

    $new_poject_id=0;

        if ($request->tip == 1) {
            $widget_chat = DB::table('widget_callback')->where('widget_id', $widget->id)->first();
            $widget_routing_model=WidgetCallbackRouting::where('sites_id',$widget->sites_id)->where('status',1) ->get();
            if(count($widget_routing_model)>0){

                $widgetrouting=$widget_routing_model;

            }

        } elseif ($request->tip==19) {
            $widget_chat = DB::table('widget_catch_lead')->where('widget_id', $widget->id)->first();
           $this->is_catch=1;
;
            $widget_routing_model=WidgetCallbackRouting::where('sites_id',$widget->sites_id)->where('status',1) ->get();
            if(count($widget_routing_model)>0){

                $widgetrouting=$widget_routing_model;

            }





            if($request->ab>0){
                DB::table('widget_catch_lead_ab')->where('id', $request->ab)->increment('leads');
            }

        } else {

            $widget_chat = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();
        }

        if (!isset($widget_chat->create_projec)) {
            $WidgetApiController = new WidgetApiController();
            $new_poject_id=    $WidgetApiController->create_project('neiros_visit', $request->neiros_visit, $widget, $pnone_email);
        } else {

            if ($widget_chat->create_project == 1) {
                $WidgetApiController = new WidgetApiController();
                $new_poject_id=$WidgetApiController->create_project('neiros_visit', $request->neiros_visit, $widget, $pnone_email);
            }
        }
$this->create_email_notifi($new_poject_id);
    $model_log->project_id=$new_poject_id;
    $model_log->step=3;
    $model_log->save();

    $phone=$this->format_phone( $request->phone);
    $this->new_project_id=$new_poject_id;

if(isset($widgetrouting)){
   $phone_to_call_array=[];
    foreach ($widgetrouting as $wr){

        if ($wr->callback_tip == 0) {
            $phone_to_call_array[] = 'SIP/runexis/' . $this->format_phone( $wr->phone_to_call);
        }
        if ($wr->callback_tip == 1) {
            $phone_to_call_array[] = 'SIP/' . $wr->phone_to_call;
        }
        if ($wr->callback_tip == 2) {
            $phone_to_call_array[] = 'SIP/' . $wr->phone_to_call;
        }
    }
    $tocall=implode('&',$phone_to_call_array);
$mega=Widgets::find($widget_chat->widget_id);
    $setting=CompanyDefaultSetting::where('my_company_id',$widget_chat->my_company_id)->where('skey','callback_aou_'.$mega->sites_id)->first();

    if($setting){
        $aon=$setting->value;

    }

}else {

    if ($widget_chat->callback_tip == 0) {
        $tocall = 'SIP/runexis/' . $this->format_phone( $widget_chat->callback_phone0);
    }
    if ($widget_chat->callback_tip == 1) {
        $tocall = 'SIP/' . $widget_chat->callback_phone1;
    }
    if ($widget_chat->callback_tip == 2) {
        $tocall = 'SIP/' . $widget_chat->callback_phone2;
    }


}
if(isset($aon)){
    $sendArray=$this->get_array_to_aster($random_id,$widget_chat,$phone,$tocall,$aon);
}else{
    $sendArray=$this->get_array_to_aster($random_id,$widget_chat,$phone,$tocall);
}


    $model_log->array_call=json_encode($sendArray);
    $model_log->step=4;
    $model_log->save();
//print_r($sendArray);
    $user=DB::table('users')->where('my_company_id',$widget_chat->my_company_id)->first();
  if($user->is_active!=1){
        return 'not active';
    }

      $http_response=$this->send_to_aster($sendArray,$model_log);



}


    public function form_mail_v1(Request $request)
    {


        $site = DB::table('sites')->where('hash', $request->site)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 12)->first();
        if (!$widget) {
            return 'error02';

        }


        $projectId = 0;
        $pnone_email['phone'] =$this->format_phone( $request->phone);
        $pnone_email['email'] = $request->email;

        $pnone_email['sub_widget'] = 'formback';
        $pnone_email['promocod'] = $request->promo;
        $pnone_email['neiros_visit'] = $request->neiros_visit;
        $pnone_email['comment'] = "Обращение с сайта  
        Тема: " . $request->tema . "<br>  
        Сообщение: " . $request->text . '<br>';

        $widget_chat = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();
    //    if ($widget_chat->create_project == 1) {
            $WidgetApiController = new WidgetApiController();
        $block=BlackListNeirosIds::where('neiros_visit',$request->user_hash)->first();
        if($block){

            return '911';
        }
            $projectId = $WidgetApiController->create_project('neiros_visit', $request->user_hash, $widget, $pnone_email);
     ///   }


        $subject = 'Обращение с сайта ' . $widget->site;
        $text = '<table style="width: 400px">
<tr>
<td>№ Сделки</td>
<td>101' . $widget->my_company_id . '' . $projectId . '</td>
</tr>';


        if ($request->phone != '') {
            $text .= '<tr>
 
<tr>
<td>Телефон</td>
<td>' . $request->phone . '</td>
</tr>';
        }

        if ($request->email != '') {
            $text .= '
<tr>
<td>E-mail</td>
<td>' . $request->email . '</td>
</tr>';
        }

        if ($request->tema != '') {
            $text .= '
<tr>
<td>Тема</td>
<td> ' . $request->tema . '</td>
</tr>';
        }

        if ($request->tema != '') {
            $text .= '
<tr>
<td>Сообщение</td>
<td> ' . $request->text . '</td>
</tr>';
        }

        $text .= '
<td>Время заявки</td>
<td>' . date(' H:i:s d.m.y') . '</td>
</tr>
</table>';
        $WidgetApiController=new WidgetApiController();
        $WidgetApiController->send_email($widget_chat->formback_email, $subject, $text);
        $all = $request->all();

        header('Access-Control-Allow-Origin:*');
        $data['ans'] = 'true';

        echo '';
        //  return $responsea;


    }


    public function socialclick(Request $request)
    {
\Log::info($request->all());
        $site = DB::table('sites')->where('hash', $request->site)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 12)->first();
        if (!$widget) {
            return 'error02';

        }
        $block=BlackListNeirosIds::where('neiros_visit',$request->neiros_visit)->first();
        if($block){

            return '911';
        }
        $widget_chat = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();
        DB::table('widgets_chat_social_click')->insert([
            'widget_id' => $widget_chat->id,
            'neiros_visit' => $request->neiros_visit,
            'social' => $request->social,
            'created_at' => date('Y-m-d H:i:s'),
            'sites_id' => $site->id,
            'status' =>0,
            'time'=>time()


        ]);

    }

    public function send_to_aster($sendArray,$model_log){
        $phone=$sendArray['aonA'];

        $sendArray['aonA']=$this->format_phone($sendArray['aonA']);
        if(strlen($sendArray['aonA'])!=11){
            $model_log->comment= 'Неверный формат '.$sendArray['aonA'];
            $model_log->step=5;
            $model_log->save();

            return '';}
        if($sendArray['aonA']{0}!=7){

            $model_log->comment= 'Неверный формат '.$sendArray['aonA'];
            $model_log->step=5;
            $model_log->save();

            return '';}

        $model_log->comment= 'Отправлено';
        $model_log->step=5;
        $model_log->save();


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


        $model_log->response= $data;
        $model_log->step=5;
        $model_log->save();
        return $data;

    }

    public function format_phone($phone){


        $phone = str_replace('+', '', $phone);
        $phone = str_replace('-', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = preg_replace('/^8/', '7', $phone);


if(strlen($phone)==10){
    $phone='7'.$phone;
}


        return $phone;






    }
public  function form_phon(){


$tp=new Project();
$tp->save();

$oauthToken = 'AgAAAAALcyGIAAUc-nsOE6Z6pEPQrTftrYsL1Ok'; // OAuth-токен
$counterId = 52418950; // идентификатор счетчика
$client_id_type = 'CLIENT_ID'; // или USER_ID

$metrikaOffline = new \Meiji\YandexMetrikaOffline\Conversion($oauthToken);
$metrikaConversionUpload = $metrikaOffline->upload($counterId, $client_id_type);

$time=time()-10;
$metrikaConversionUpload->addConversion(1553186518567202865, 'neiros', $time   ); // Добавяем конверсию


$uploadResult = $metrikaConversionUpload->send();


//dd($uploadResult);
}

    public function get_array_to_aster($random_id,$widget_chat,$phone,$tocall,$aou=null){
        /*auth()->user()->getglobalsetting->where('skey','callbach_who_call_first')->first()->value*/
$project=Project::find($this->new_project_id);
  $mega=Widgets::find($widget_chat->widget_id);

        $setting = CompanyDefaultSetting::where('my_company_id', $widget_chat->my_company_id)->where('skey', 'callbach_who_call_first_'.$mega->sites_id)->first();
        $setting_whu = CompanyDefaultSetting::where('my_company_id', $widget_chat->my_company_id)->where('skey', 'callbach_who_man_wooman_'.$mega->sites_id)->first();

        if(!$setting){

            $setting = CompanyDefaultSetting::where('my_company_id', $widget_chat->my_company_id)->where('skey', 'callbach_who_call_first')->first();
            $setting_whu = CompanyDefaultSetting::where('my_company_id', $widget_chat->my_company_id)->where('skey', 'callbach_who_man_wooman')->first();


        }



        if(!$setting){
            $callbach_who_call_first=0;
        }
        else{
            $callbach_who_call_first=$setting->value;
        }

        if(!$setting_whu){
            $callbach_voice=0;
        }
        else{
            $callbach_voice=$setting_whu->value;
        }
info('TEST AUDIO');
info('TEST AUDIO $callbach_who_call_first'.$callbach_who_call_first);
info('TEST AUDIO $callbach_voice'.$callbach_voice);



        if($callbach_who_call_first==0){/*звоним оператору*/
           if($project) {
               $project->callback_client = 'B';
               $project->save();
           }

            if($callbach_voice==0){

                $voise='/opt/background/sounds/calltoclientwooman';

            }else{
                $voise='/opt/background/sounds/calltoopperator';
            }



            info($voise);

            if(is_null($aou)){
                $aou=$widget_chat->callback_phone0;

            }
            $sendArray = array(
                'id' => $random_id, // Мой ID звонка
                'aonB' =>$this->format_phone($aou) ,  //увидит менеджер
                'aonA' => $phone,//номер увидит клиент
                'dialstringB' => 'SIP/runexis/' . $phone,//это номер менеджера
                'dialstringA' => $tocall,//Это номер клиента?
                'play_for_client'=>$voise
            );



        }
        if($callbach_who_call_first==1){
            if($project) {
                $project->callback_client = 'A';
                $project->save();
            }
            if($callbach_voice==0){
                $voise='/opt/background/sounds/calltoopperatorwooman';

            }else{
                $voise='/opt/background/sounds/calltoclient';


            }


            info($voise);

            if(is_null($aou)){
                $aou=$widget_chat->callback_phone0;

            }
            $sendArray = array(
                'id' => $random_id, // Мой ID звонка
                'aonA' => $aou,  //увидит менеджер
                'aonB' =>$this->format_phone( $phone),//номер увидит клиент
                'dialstringA' => 'SIP/runexis/' . $phone,//это номер менеджера
                'dialstringB' => $tocall,//Это номер клиента?
                'play_for_client'=>$voise
            );


        }

/*$project=Project::where('my_company_id',$widget_chat->my_company_id)  */
        return $sendArray;

    }
    public function callback_later($request)
    { $random_id = rand(111, 111119991);
        DB::table('projects')->where('id', $request->project_id)->update(['call_back_random_id' => $random_id]);
        $this->new_project_id=$request->project_id;
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

        $widget = DB::table('widgets')->where('id', $request->widget_id)->first();
        if (!$widget) {
            return 'error02';

        }


        $pnone_email['phone'] = $request->phone;
        $pnone_email['sub_widget'] = 'callback';
        $widget_routing_model=WidgetCallbackRouting::where('sites_id',$widget->sites_id)->where('status',1) ->get();
        if(count($widget_routing_model)>0){

            $widgetrouting=$widget_routing_model;

        }

        if(!isset($widgetrouting)) {

            if ($widget->tip == 12) {
                $widget_chat = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();
            }
            if ($widget->tip == 1) {
                $widget_chat = DB::table('widget_callback')->where('widget_id', $widget->id)->first();
            }
            if ($widget->tip == 19) {
                $widget_chat = DB::table('widget_catch_lead')->where('widget_id', $widget->id)->first();
            }
            /*+7 (953) 098-69-97*/




            if ($widget_chat->callback_tip == 0) {
                $tocall = 'SIP/runexis/' . $widget_chat->callback_phone0;
            }
            if ($widget_chat->callback_tip == 1) {
                $tocall = 'SIP/' . $widget_chat->callback_phone1;
            }
            if ($widget_chat->callback_tip == 2) {
                $tocall = 'SIP/' . $widget_chat->callback_phone2;
            }


            $sendArray = array(
                'id' => $random_id, // Мой ID звонка
                'aonB' => $this->format_phone($widget_chat->callback_phone0),  //увидит менеджер
                'aonA' => $phone,//номер увидит клиент
                'dialstringB' => 'SIP/runexis/' . $phone,//это номер менеджера
                'dialstringA' => $tocall,//Это номер клиента?
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

        }else{
            $phone_to_call_array=[];
            foreach ($widgetrouting as $wr){

                if ($wr->callback_tip == 0) {
                    $phone_to_call_array[] = 'SIP/runexis/' . $wr->phone_to_call;
                }
                if ($wr->callback_tip == 1) {
                    $phone_to_call_array[] = 'SIP/' . $wr->phone_to_call;
                }
                if ($wr->callback_tip == 2) {
                    $phone_to_call_array[] = 'SIP/' . $wr->phone_to_call;
                }
            }
            $tocall=implode('&',$phone_to_call_array);
            $mega=$widget;
            $setting=CompanyDefaultSetting::where('my_company_id',$widget->my_company_id)->where('skey','catch_aou_'.$mega->sites_id)->first();
            if($setting){
                $aon=$setting->value;


            }

            if ($widget->tip == 12) {
                $widget_chat = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();
            }
            if ($widget->tip == 1) {
                $widget_chat = DB::table('widget_callback')->where('widget_id', $widget->id)->first();
            }
            if ($widget->tip == 19) {
                $widget_chat = DB::table('widget_catch_lead')->where('widget_id', $widget->id)->first();
            }

            if(isset($aon)){
                $sendArray=$this->get_array_to_aster($random_id,$widget_chat,$phone,$tocall,$aon);
            }else{
                $sendArray=$this->get_array_to_aster($random_id,$widget_chat,$phone,$tocall);
            }


            $model_log=new CallBacks();
            $model_log->array_call=json_encode($sendArray);
            $model_log->step=4;
            $model_log->save();
//print_r($sendArray);
            $user=DB::table('users')->where('my_company_id',$widget_chat->my_company_id)->first();
            if($user->is_active!=1){
                return 'not active';
            }

            $http_response=$this->send_to_aster($sendArray,$model_log);





        }
    }
}


