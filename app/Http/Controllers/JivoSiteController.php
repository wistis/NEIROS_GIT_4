<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Api\WidgetApiController;
use Log;
use App\Project;
use Illuminate\Http\Request;
use DB;
class JivoSiteController extends Controller
{
    public function jivosite($key,Request $request){

        $site = DB::table('sites')->where('hash', $key)->first();
        if (!$site) {
            Log::info('Error site');
            return '1';
        }

        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 21) ->where('status', 1) ->first();
           if (!$widget) {
            Log::info('Error widget');
            return 'error02';

        }



        Log::info('benefis jivo');
        Log::info($request->all());
$inputdata=$request->all();




        $data_w['neiros_visit'] = '';
        $data_w['fio'] =$inputdata['visitor']['name'];
        $data_w['phone'] =$inputdata['visitor']['phone'];
        $data_w['email'] = $inputdata['visitor']['email'];
        $data_w['sub_widget'] = 'jivosite';

        $WidgetApiController = new WidgetApiController();
        $getallwid = Project::where('widget_id', $widget->id)->count();
        $getallwid++;
        $projectId = $WidgetApiController->create_lead([
            'name' => $widget->name . ' № ' . $getallwid,
            'stage_id' => $widget->stage_id,
            'user_id' => $widget->user_id,
            'summ' => 0,
            'comment' => $widget->name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'fio' => '',
            'company' => '',
            'widget_id' => $widget->id,

            'my_company_id' => $widget->my_company_id,
            'neiros_visit' => $data_w['neiros_visit'],
            'vst' => 0,
            'pgs' => 0,
            'url' => '',
            'site_id' => $widget->sites_id,
            'week' => date("W", time()),
            'hour' => date("H", time())
        ], $data_w);

$data_for_jivo['chat_id']=$inputdata['chat_id'];
$data_for_jivo['visitor_name']=$inputdata['visitor']['name'];
$data_for_jivo['visitor_email']=$inputdata['visitor']['email'];
$data_for_jivo['visitor_phone']=$inputdata['visitor']['phone'];
$data_for_jivo['visitor_description']=$inputdata['visitor']['description'];
$data_for_jivo['visitor_number']=$inputdata['visitor']['number'];
$data_for_jivo['visitor_social']=$inputdata['visitor']['social'];
$data_for_jivo['agent_id']=$inputdata['agent']['id'];
$data_for_jivo['agent_name']=$inputdata['agent']['name'];
$data_for_jivo['agent_email']=$inputdata['agent']['email'];
$data_for_jivo['region']=isset($inputdata['session']['geoip']['city'])?$inputdata['session']['geoip']['city']:'';
$data_for_jivo['utm']=$inputdata['session']['utm'];
$data_for_jivo['url']=isset($inputdata['page']['url'])?$inputdata['page']['url']:'';

$data_for_jivo['my_company_id']=$widget->my_company_id;
$data_for_jivo['my_company_id']= $widget->id;
$data_for_jivo['project_id']=$projectId;
DB::table('jivosite_data')->insert($data_for_jivo);
    }
}

