<?php

namespace App\Http\Controllers\Api;

use App\Models\NeirosGaSid;
use App\Project;
use App\Widgets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use InstagramAPI\Request\Location;
use Log;

class GaCallController extends Controller
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
        Log::useFiles(base_path() . '/storage/logs/GACALL.log', 'info');

        $widget2 = Widgets::where('my_company_id', $this->project->my_company_id)->where('id', $this->project->widget_id)
            ->where('status', 1)
            ->first();
        info("get_widget --");
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
        Log::useFiles(base_path() . '/storage/logs/GACALL.log', 'info');

        $widget = Widgets::where('my_company_id', $this->project->my_company_id)->where('tip', 22)
            ->where('sites_id', $this->project->site_id)->where('status', 1)
            ->first();


        if (is_null($widget)) {
            return '';
            info("get_widget_r NOT FOUND");
        }
        $this->widget_r = $widget;
    }

    public function get_ga_visit()
    {
        Log::useFiles(base_path() . '/storage/logs/GACALL.log', 'info');
        info('ищес мделку ГА' . $this->project->neiros_visit);

        $get_roystat_visit = NeirosGaSid::where('neiros_visit', $this->project->neiros_visit)->first();

        if (!$get_roystat_visit) {
            Log::info('get_ga_visit not found  $get_roystat_visit    gaA' . $this->project->neiros_visit);
            return '';

        }
        if (strlen($get_roystat_visit->_ym_uid) < 5) {
            Log::info('not found ga short' . $this->project->neiros_visit . '-----');
            Log::info('get_ga_visit ($get_roystat_visit->roistat_visit) < 5)');
            return '';
        }
        $this->roistat_visit = $get_roystat_visit->_ym_uid;
        $this->data_to_send['roistat_visit'] = $get_roystat_visit->_ym_uid;
        Log::info('send with gaA');
        Log::info($this->data_to_send);
    }

    public function form_lead($pr_id,$is_webhook=null)
    {
        Log::useFiles(base_path() . '/storage/logs/GACALL.log', 'info');

        $this->project = Project::where('id', $pr_id)->first();

        if (!$this->project) {
            info('101');
            Log::info('form_lead !$this->project');
            return '101';

        }

        $this->get_widget_r();

        if (!$this->widget_r) {
            info('201');
            Log::info('form_lead !$this->project');
            return '201';
        }

        $this->get_type_widget();

        if ($this->is_webhook == 1) {

            $this->collect_data_webhook();

        }

if(!is_null($is_webhook)){

    $this->is_webhook=0;
    $widgetinput = Widgets::with('w10')
        ->where('my_company_id', $this->project->my_company_id)->where('id', $this->project->widget_id)
        ->where('status', 1)
        ->first();
    if (!$widgetinput) {
        info('Не найден виджет #' . $this->project->id);
        return '';
    }
    $tip = $widgetinput->tip;

    info('  $tip = $widgetinput->tip;#' .$tip);
if($tip!=12){
    return '';
}else{
    $this->data_to_sand['tipaction'] = 'neiros_chat';

}


}
        $this->get_ga_visit();

        if ($this->roistat_visit == 0) {
            info('301');
            Log::info('form_lead $this->roistat_visit');
            return '301';
        }


        $this->send_to_ga();

    }

    public function collect_data_webhook()
    {
        Log::useFiles(base_path() . '/storage/logs/GACALL.log', 'info');

        $this->data_to_send['caller'] = $this->project->phone;
        $this->data_to_send['date'] = date('Y-m-d H:i:s', strtotime($this->project->created_at));

        $this->data_to_send['status'] = $this->audio->disposition;
        $this->data_to_send['duration'] = $this->audio->duration;
        Log::info('collect_data_webhook');
        Log::info('Webhoook');
        Log::info(json_encode($this->data_to_send));
    }


    public function send_to_ga()
    {
        Log::useFiles(base_path() . '/storage/logs/GACALL.log', 'info');


        Log::info('SENDED GA');


        $caunter = $this->widget_r->element;
        $cid = $this->data_to_send['roistat_visit'];
        if(  $this->data_to_sand['tipaction']=='neiros_chat'){
            $callerId=$this->project->neiros_visit;
            $time=1;


        }else {
            $callerId = $this->project->phone;//телефон
            $time = $this->data_to_send['duration'];//Длитильность  Log::info('collect_data_webhook'  );
        }
        file_get_contents('https://www.google-analytics.com/collect?' . "v=1&tid=" . $caunter . "&cid=" . $cid . "&t=event&ec=" . $this->data_to_sand['tipaction'] . "&ea=" . $callerId . "&el=" . $time . "");
        info('https://www.google-analytics.com/collect?' . "v=1&tid=" . $caunter . "&cid=" . $cid . "&t=event&ec=zvonok&ea=" . $callerId . "&el=" . $time . "");
        /*   if( $curl = curl_init() ) {
               Log::info("v=1&tid=".$caunter."&cid=".$cid."&t=event&ec=".$this->data_to_sand['tipaction']."&ea=".$callerId."&el=".$time."" );
               curl_setopt($curl, CURLOPT_URL, 'https://www.google-analytics.com/collect');
               curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
               curl_setopt($curl, CURLOPT_POST, true);
               curl_setopt($curl, CURLOPT_POSTFIELDS, );
               $out = curl_exec($curl);
               Log::info($out );
               curl_close($curl);

           }*/

    }

    public function get_data_from_webhook($data)
    {
        Log::useFiles(base_path() . '/storage/logs/GACALL11.log', 'info');
        info('310588 '.time());
        sleep(2);
        info('Data from web 1');
        info($data);
        $this->is_webhook = 1;

        if ($data['type'] == 'calltracking') {
            $this->prov_is_coll_track($data);
            Log::info('get_data_from_webhook calltracking');
            $this->data_to_sand['tipaction'] = 'neiros_calltracking';
        } else {
            $this->data_to_sand['tipaction'] = 'neiros_callback';
            Log::info('get_data_from_webhook !calltracking');
            $this->prov_is_callback($data);
        }
        info('Data from web 2');
        Log::info($this->project_id . ' найдена сделка GA');

        if ($this->project_id != 0) {

            $this->form_lead($this->project_id);

        }


    }

    public function prov_is_coll_track($data)
    {
        Log::useFiles(base_path() . '/storage/logs/GACALL.log', 'info');
        info('Ищем запимь');
        info($data['uniqueid']);
        Log::info('prov_is_coll_track ');
        $audio = DB::connection('asterisk')->table('calls')->where('uniqueid', $data['uniqueid'])->orderby('id', 'desc')->first();
        if (!$audio) {
            info('Ищем запимь NO');
            Log::info('prov_is_coll_track  !$audio');
            return '';
        }
        $this->audio = $audio;
        $pr = Project::where('uniqueid', $data['uniqueid'])->first();
        if ($pr) {
            Log::info('prov_is_coll_track  !$pr');
            $this->project_id = $pr->id;
        }
    }

    public function prov_is_callback($data)
    {
        Log::useFiles(base_path() . '/storage/logs/GACALL.log', 'info');
        if (is_null($data['uniqueid'])) {
            Log::info('prov_is_callback  prov_is_callback');
            $t = explode('_', $data['record_file']);
            if (!is_array($t)) {
                return '';
                Log::info('prov_is_callback (!is_array($t))');
            }
            $kod = $t[(count($t) - 1)];
            $audio = DB::connection('asterisk')->table('callback_calls')->where('callback_id', $kod)->where('shoulder', 'B')->orderby('id', 'desc')->first();
            if (!$audio) {
                return '';
                Log::info('prov_is_callback  !$audio');
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
        Log::useFiles(base_path() . '/storage/logs/GACALL.log', 'info');

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
