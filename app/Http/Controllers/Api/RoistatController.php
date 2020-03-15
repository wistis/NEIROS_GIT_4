<?php

namespace App\Http\Controllers\Api;

use App\Project;
use App\Widgets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use InstagramAPI\Request\Location;
use Log;

class RoistatController extends Controller
{
    public $is_webhook = 0;
    public $is_callback = 0;
    public $project_id = 0;
    public $project = [];
    public $roistat_visit = 0;
    public $widget_r = false;
    public $data_to_sand = [];
    public $type_widget = 0;
    public $audio = false;

    public function get_type_widget()
    {

        $widget2 = Widgets::with('w18')
            ->where('my_company_id', $this->project->my_company_id)->where('id', $this->project->widget_id)
  ->where('status',1)
            ->first();
info("get_widget");
info($this->project->site_id);
info($this->project->my_company_id);
info($this->project->widget_id);
        if (!$widget2) {
            return false;
        }
        $this->type_widget = $widget2->tip;

    }

    public function get_widget_r()
    {

        $widget = Widgets::with('w18')
            ->where('my_company_id', $this->project->my_company_id)->where('tip', 18)
            ->where('sites_id', $this->project->site_id) ->where('status',1)
            ->first();


        if (is_null($widget)) {
            return '';
        }
        $this->widget_r = $widget;
    }

    public function get_roystatt_visit()
    {

        $get_roystat_visit = DB::table('metrica_roistat')->where('neiros_visit', $this->project->neiros_visit)->first();

        if (!$get_roystat_visit) {
            Log::info('not found roistat');
            return '';

        }
        if (strlen($get_roystat_visit->roistat_visit) < 5) {
            Log::info('not found roistat short');
            return '';
        }
        $this->roistat_visit = $get_roystat_visit->roistat_visit;
        $this->data_to_send['roistat_visit']=$get_roystat_visit->roistat_visit;
        Log::info('send with ristata');
        Log::info( $this->data_to_send);
    }

    public function form_lead($pr_id)
    {

        $this->project = Project::where('id', $pr_id)->first();

        if (!$this->project) {
            info('101');
            return '101';

        }

        $this->get_widget_r();

        if (!$this->widget_r) {
            info('201');
            return '201';
        }

        $this->get_type_widget();

        if ($this->is_webhook == 1) {

            $this->collect_data_webhook();

        } else {
            $this->collect_data();
        }


        $this->get_roystatt_visit();

        if ($this->roistat_visit == 0) {
            info('301');
            return '301';
        }


$this->send_to_roistat();

    }

    public function collect_data_webhook()
    {
        if( $this->project->phone_to_call==''){
            $this->data_to_send['callee'] = '';

        }else{
            $this->data_to_send['callee'] = $this->project->phone_to_call;
        }

        $this->data_to_send['callee'] = $this->project->phone_to_call;

        if($this->type_widget==19){

            $phon=DB::table('widget_catch_lead')->where('widget_id', $this->project->widget_id)->first();
            if($phon){
                if($phon->callback_phone0!=''){
                    $this->data_to_send['callee']=$phon->callback_phone0;
                }

            }

        }
        if($this->type_widget==1){
            $phon=DB::table('widget_callback')->where('widget_id', $this->project->widget_id)->first();

            if($phon){
                if($phon->callback_phone0!=''){
                    $this->data_to_send['callee'] =$phon->callback_phone0;
                }

            }

        }


        $this->data_to_send['caller'] = $this->project->phone;
        $this->data_to_send['date'] = date('Y-m-d H:i:s',strtotime($this->project->created_at));


        $this->data_to_send['neiros'] =(string)$this->project->id;
        $this->data_to_send['status'] = $this->audio->disposition;
        $this->data_to_send['duration'] = $this->audio->duration;
        $this->data_to_send['link'] = 'http://82.146.43.227/records/' . date('Y', strtotime($this->audio->calldate)) . '/' . date('m', strtotime($this->audio->calldate)) . '/' . date('d', strtotime($this->audio->calldate)) . '/' . $this->audio->record_file . '.mp3';

        Log::info('Webhoook');
        Log::info(json_encode($this->data_to_send));
    }

    public function collect_data()
    {
        Log::useFiles(base_path() . '/storage/logs/toroistat.log', 'info');
if( $this->project->phone_to_call==''){
    $this->data_to_send['callee'] = '';

}else{
    $this->data_to_send['callee'] = $this->project->phone_to_call;
}

        if ($this->project->fio = '') {
            $this->data_to_send['name'] = $this->project->name;
        } else {
            $this->data_to_senddata_to_send['name'] = $this->project->fio;
        }
info('widget tip'.$this->type_widget);


if($this->type_widget==19){

$phon=DB::table('widget_catch_lead')->where('widget_id', $this->project->widget_id)->first();
if($phon){
if($phon->callback_phone0!=''){
    $this->data_to_send['callee']=$phon->callback_phone0;
}

}

}
            if($this->type_widget==1){
                $phon=DB::table('widget_callback')->where('widget_id', $this->project->widget_id)->first();

                if($phon){
                    if($phon->callback_phone0!=''){
                        $this->data_to_send['callee'] =$phon->callback_phone0;
                    }

                }

            }




            /*Данные для колтрекинга*/

            $this->data_to_send['caller'] = $this->project->phone;
            $this->data_to_send['type']=$this->type_widget;
            $this->data_to_send['neiros'] = (string)$this->project->id;
            $this->data_to_send['date'] = date('Y-m-d H:i:s',strtotime($this->project->created_at));


            Log::info('CallTracking');
            Log::info(json_encode($this->data_to_send));


        Log::info('CallTracking');
        Log::info($this->data_to_send);
    }

    public function send_to_roistat()
    {



       // $ch = curl_init('https://cloud.roistat.com/integration/webhook?key=' . $this->widget_r->w18->server1);
        $ch = curl_init( $this->widget_r->w18->server1);

        $payload = json_encode($this->data_to_send,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
try{
   if ($this->project->my_company_id == 40) {

       if ($this->project->widget_id == 629) {
           if ($curl = curl_init()) {
               curl_setopt($curl, CURLOPT_URL, "https://cloud.roistat.com/api/site/1.0/1483/event/register?event=zayavka_sformi&visit=" . $this->data_to_send['roistat_visit'] . "&data[name]=" . $this->project->fio . "&data[phone]=" . $this->data_to_send['caller'] . "");
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
               $out = curl_exec($curl);
           }

           if ($curl = curl_init()) {
               curl_setopt($curl, CURLOPT_URL, "https://cloud.roistat.com/api/site/1.0/1483/event/register?event=zayavka_callback&visit=" . $this->data_to_send['roistat_visit'] . "&data[name]=" . $this->project->fio . "&data[phone]=" . $this->data_to_send['caller'] . "");
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
               $out = curl_exec($curl);
           }
       }
   }

   }catch(\Exception $e){
    info($e);
}
    }

    public function get_data_from_webhook($data)
    {
        sleep(2);
        info('Data from web');
        info($data);
        $this->is_webhook = 1;

        if($data['type']=='calltracking') {
            $this->prov_is_coll_track($data);
        }else{

            $this->prov_is_callback($data);
        }     info('Data from web');
Log::info($this->project_id);

        if ($this->project_id != 0) {

            $this->form_lead($this->project_id);

        }


    }

    public function prov_is_coll_track($data)
    {
        info('Ищем запимь');
        info($data['uniqueid']);
        $audio = DB::connection('asterisk')->table('calls')->where('uniqueid', $data['uniqueid'])->orderby('id', 'desc')->first();
        if (!$audio) {
            info('Ищем запимь NO');
            return '';
        }
        $this->audio = $audio;
        $pr = Project::where('uniqueid', $data['uniqueid'])->first();
        if ($pr) {
            $this->project_id = $pr->id;
        }
    }

    public function prov_is_callback($data)
    {
        if (is_null($data['uniqueid'])) {

            $t = explode('_', $data['record_file']);
            if (!is_array($t)) {
                return '';
            }
            $kod = $t[(count($t) - 1)];
            $audio = DB::connection('asterisk')->table('callback_calls')->where('callback_id', $kod)->where('shoulder', 'B')->orderby('id', 'desc')->first();
            if (!$audio) {
                return '';
            }

            $this->audio = $audio;
            $pr = Project::where('call_back_random_id', $kod)->first();
            if ($pr) {
                $this->project_id = $pr->id;

                $this->is_callback = 1;


            }
        }


    }


    public function index()
    {

        $key = '474b8254ff4bbf08bbc84340ef76a279';
        if ($curl = curl_init()) {
            $data = [];

            $data[0]['id'] = "310588";
            $data[0]['name'] = "Нейрос тест сделка 22";
            $data[0]['date_create'] = "" . time() . "";
            $data[0]['status'] = "0";
            $data[0]['roistat'] = "329340";

            $data[0]['price'] = "0";
            $data[0]['cost'] = "0";
            $data[0]['client_id'] = "11232";
            $data[0]['fields'][]['phone'] = '79530986997';


            $rr = json_encode($data);


            /*curl_setopt($curl, CURLOPT_URL, 'https://cloud.roistat.com/api/v1/project/add-orders?key=' . $key . '&project=21518');*/
            curl_setopt($curl, CURLOPT_URL, 'https://cloud.roistat.com/api/v1/project/add-orders?key=' . $key . '&project=21518');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $rr);
            $out = curl_exec($curl);
            info('Roistat response');
            info($out);
            echo $out;
            curl_close($curl);
        }


    }
}
