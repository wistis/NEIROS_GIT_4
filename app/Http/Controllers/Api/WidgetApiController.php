<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\LeadPayController;
use App\Http\Controllers\PayCompanyController;
use App\Models\NeirosClientId;
use App\Models\NeirosGaSid;
use App\Models\NeirosMetricaSid;
use App\Models\NeirosUtm;
use App\Models\Servies\BlackListNeirosIds;
use App\Models\Servies\CityIp;
use App\Models\SrcCompact;
use App\Models\WidgetCanal;
use App\Models\WidgetsRoistat;
use App\Models\MetricaCurrent;
use App\Widgets_phone_routing;
use Google\AdsApi\AdWords\v201802\cm\Location;
use Illuminate\Contracts\Cookie\Factory;
use App\Http\Controllers\AmoCrmApiController;
use App\Http\Controllers\BitrixController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClientController;
use App\Project;
use App\Projects_tag;
use App\Widget_tags;
use App\Widgets;
use DB;
use Illuminate\Http\Request;
use Log;
use Mail;

class WidgetApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function create_lead($data, $pnone_email, $is_amo = null)
    {


if(!isset(  $data['reports_date'] )){
    $data['reports_date'] = date('Y-m-d');
}
if(!isset($data['phone'])) {
    $data = array_merge($data, $pnone_email);
}
$my_pr= Project::create($data);






        $projectId=$my_pr->id;



$pr=Project::where('id',$projectId)->first();

$df['phone']=$pr->phone;
$df['email']=$pr->email;
        $ncl_id=$this->get_ncl_id($pr->my_company_id,$df,$pr->neiros_visit,$pr->site_id,$pr->phone);
        $pr->ncl_id=$ncl_id;
        $pr->save();

$datakm['sdelka']=1;
$datakm['lead']=0;
$datakm['summ']=0;


$datakm['project_id']=$pr->id;
      $this->update_mertica_to_neiros_visit('neiros_visit',$pr->neiros_visit,$datakm,$pr);
if($pr->summ>0){

    LeadPayController::createPayment($pr);


}

        NeirosClientId::updatedata($pr->id);
        $my_pr->set_max();
        if (count($pnone_email) > 0) {

            if (isset($pnone_email['neiros_visit'])) {

                $geturl = DB::table('metrica_visits')->where('neiros_visit', $pnone_email['neiros_visit'])->orderby('id', 'desc')->first();
                if ($geturl) {
                    $pnone_email['neiros_url_vst'] = $geturl->id;
                }


            }


            $pnone_email['reports_date'] = date('Y-m-d');
            Project::where('id', $projectId)->update($pnone_email);
        }
        if (is_null($is_amo)) {
            $AmoCrmApiController = new AmoCrmApiController();
            $AmoCrmApiController->start_prov($projectId);

            $BitrixController = new BitrixController();
            $BitrixController->start_prov($projectId);

        }
        $ClientController = new  ClientController();
        $ClientController->createClientFromLead($projectId);



$this->send_online($my_pr);

$roistat_api=new RoistatController();

$roistat_api->form_lead($my_pr->id);




        return $projectId;

    }




    public function get_ncl_id_withiut_neiros($my_company_id,$phone,$site_id){

        if((isset($phone))&&(strlen($phone)>5)) {
            $data_to_insert[]=$phone;
            $search = NeirosClientId::where('dvalue', $phone)->where('my_company_id', $my_company_id)->first();
            if ($search) {

                return $search->ncl_id;

            }

        }

        $neiros_visit = DB::table('neiros_user_all')->insertGetId([
            'site_id' => $site_id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),

        ]);
        $search=new NeirosClientId();
        $search->ncl_id=$neiros_visit;
        $search->dvalue=$phone;
        $search->my_company_id=$my_company_id;
        $search->save();


        $search=new NeirosClientId();
        $search->ncl_id=$neiros_visit;
        $search->dvalue=$neiros_visit;
        $search->my_company_id=$my_company_id;
        $search->save();
        return  $search->ncl_id;



    }




public function send_online($pr){



   if($pr->my_company_id==40) {


       if ($curl = curl_init()) {

           $headers=['Content-Type: application/json'           ];
           curl_setopt($curl, CURLOPT_URL, 'https://my.teatr-benefis.ru/api/fromneiros');
           curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
           curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($pr));
           $out = curl_exec($curl);
       }
   }

    if($pr->my_company_id==14) {


        if ($curl = curl_init()) {

            $headers=['Content-Type: application/json'           ];
            curl_setopt($curl, CURLOPT_URL, 'http://my.artestom.ru/api/fromneiros');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($pr));
            $out = curl_exec($curl);
        }
    }
}
public function get_ncl_id($my_company_id,$data,$neiros_visit,$site_id,$phone=null){

if(strlen($phone)>4){
    $search=NeirosClientId::where('dvalue',$phone)->where('my_company_id',$my_company_id)->orderby('id','acs')->first();
if($search){
    return $search->ncl_id;
}


}

 $search=NeirosClientId::where('ncl_id',$neiros_visit)->where('my_company_id',$my_company_id)->first();
 if($search){
if($neiros_visit>0){
    return $search->ncl_id;
    }else{

    $neiros_visit = DB::table('neiros_user_all')->insertGetId([
        'site_id' => $site_id,
        'created_at' => date('Y-m-d'),
        'updated_at' => date('Y-m-d'),

    ]);
}

 }
    $search=NeirosClientId::where('dvalue',$neiros_visit)->where('my_company_id',$my_company_id)->first();
    if($search){

        return $search->ncl_id;

    }
if((isset($data['phone']))&&(strlen($data['phone'])>5)) {
    $data_to_insert[]=$data['phone'];
    $search = NeirosClientId::where('dvalue', $data['phone'])->where('my_company_id', $my_company_id)->first();
    if ($search) {

        return $search->ncl_id;

    }

}
    if((isset($data['email']))&&(strlen($data['email'])>5)) {

        $data_to_insert[]=$data['email'];
        $search = NeirosClientId::where('dvalue', $data['phone'])->where('my_company_id', $my_company_id)->first();
        if ($search) {

            return $search->ncl_id;

        }

    }

  $search=new NeirosClientId();
    $search->ncl_id=$neiros_visit;
    $search->dvalue=$neiros_visit;
    $search->my_company_id=$my_company_id;
    $search->save();
    return  $search->ncl_id;



}
    public function  create_project($pole_metriki, $param_metriki, $widget, $pnone_email)
    {

        $MetricaCurrent=new MetricaCurrent();
        $MetricaCurrent->setTable('metrica_'.$widget->my_company_id);

        $metrika = $MetricaCurrent->where($pole_metriki, $param_metriki)->orderby('id', 'desc')->first();
        $z0 = 0;
        $hash = '';
        if ($metrika) {

            $hash = $metrika->neiros_visit;
        }
            /*$metrika = DB::table('metrika_first')->where($pole_metriki, $param_metriki)->orderby('id', 'desc')->first();
            if ($metrika) {
                $z0 = 1;
                $hash = $metrika->neiros_visit;
            } else {
                $hash = '';
            }*/


        $getallwid = Project::where('widget_id', $widget->id)->count();
        $getallwid++;

        $projectId = $this->create_lead([
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
            'neiros_visit' => $hash,
            'vst' => 0,
            'pgs' => 0,
            'url' => '',
            'site_id' => $widget->sites_id,
            'week' => date("W", time()),
            'hour' => date("H", time())
        ], $pnone_email);



        if ($metrika) {

            if ($z0 == 0) {





                Project::where('id', $projectId)->update([
                    'vst' => $metrika->visit,
                    'url' => $metrika->ep
                ]);


            } else {
                Project::where('id', $projectId)->update([
                    'vst' => 1,
                    'url' => $metrika->ep
                ]);
               /* DB::table('metrika_first')->where('id', $metrika->id)->update(['project_id' => $projectId]);*/

            }

            try {
                $this->generate_1($widget->sites_id, $metrika->typ, $widget->tip, $widget->my_company_id, $projectId, $metrika->src, $metrika->trim);
            } catch (\Exception $e) {
                Log::info($e);
            }

        }


        $provbitrix = Widgets::where('my_company_id', $widget->my_company_id)->where('sites_id', $widget->sites_id)->where('tip', 16)->where('status', 1)->first();
        if ($provbitrix) {

            if (count($pnone_email) > 0) {
                $dt = $pnone_email;
            }
            $dt['project_id'] = $projectId;
            try {
                $BitrixController = new BitrixController();
                $BitrixController->index($dt, $provbitrix);
            } catch (\Exception $e) {

            }

        }

        return $projectId;

    }

    public function create_from_callback($request)
    {


        $widget = DB::table('widgets')->where('id', $request->widget_id)->first();


        $z0 = 0;

        $MetricaCurrent=new MetricaCurrent();
        $MetricaCurrent->setTable('metrica_'.$widget->my_company_id);

        $metrika = $MetricaCurrent->where('olev_phone_track', $request->did)->orderby('id', 'desc')->first();$hash = '';
        if ($metrika) {
            $hash = $metrika->hash;
        }/* else {
            $metrika = DB::table('metrika_first')->where('olev_phone_track', $request->src)->orderby('id', 'desc')->first();
            if ($metrika) {
                $z0 = 1;
                $hash = $metrika->hash;
            } else {

            }
        }*/

        $getallwid = Project::where('widget_id', $widget->id)->count();
        $getallwid++;

        $projectId = $this->create_lead([
            'name' => $widget->name . '№ ' . $getallwid,
            'stage_id' => $widget->stage_id,
            'user_id' => $widget->user_id,
            'summ' => 0,
            'comment' => $widget->name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'fio' => '',
            'company' => '',
            'widget_id' => $widget->id,
            'email' => '',
            'phone' => $request->src,
            'my_company_id' => $widget->my_company_id,
            'client_hash' => $hash,
            'vst' => 0,
            'pgs' => 0,
            'url' => '',
            'uniqueid' => $request->uniqueid,
            'site_id' => $widget->sites_id,
            'week' => date("W", time()),
            'hour' => date("H", time())
        ], []);
        if ($metrika) {

            if ($z0 == 0) {

                Project::where('id', $projectId)->update([
                    'vst' => $metrika->visit,
                    'url' => $metrika->ep
                ]);



            } else {
                Project::where('id', $projectId)->update([
                    'vst' => 1,
                    'url' => $metrika->ep
                ]);
               /* DB::table('metrika_first')->where('id', $metrika->id)->update(['project_id' => $projectId]);*/

            }

            try {
                $this->generate_1($widget->sites_id, $metrika->typ, $widget->tip, $widget->my_company_id, $projectId, $metrika->src, $metrika->trim);
            } catch (\Exception $e) {
                Log::info($e);
            }

        }


        if (isset($widget)) {
            $widget_id = $widget->id;
            $my_company_id = $widget->my_company_id;
        } else {
            $widget_id = 0;
            $my_company_id = 0;
        }


    }

    public function index($request)
    {

        $hash = '';
        $widget_phone = DB::table('widgets_phone')->where('input', $request->did)->first();
        $did=$request->did;
        if(!$widget_phone){
            info('ERROR call E11');
            info( $request->did);
         info($request->all());

            return
 ;        }
        $widget = DB::table('widgets')->where('id', $widget_phone->widget_id)->first();
$did='';
$is_static=0;
        if ($widget_phone) {
            if ($widget_phone->tip == 2) {
                $is_static = 1;
                $routing = Widgets_phone_routing::where('id', $widget_phone->routing)->first();
info('проверка статистического звонка');
                if ($routing) {
                    $canals = WidgetCanal::where('id', 3)->get();
                    if(is_array($routing->canals)) {
                        $canals = WidgetCanal::wherein('id', $routing->canals)->get();

                    }

                    $hash = $this->get_ncl_id_withiut_neiros($widget->my_company_id, $request->src, $widget->sites_id);
foreach ($canals as $canal){

    $metrika = new MetricaCurrent();
    $metrika->setTable('metrica_' . $widget->my_company_id);
    $metrika->key_user = '';
    $metrika->fd = '';
    $metrika->ep = '';
    $metrika->rf = '';
    $metrika->neiros_visit = $hash;
    $metrika->typ = $canal->code;
    $metrika->mdm ='';
    $metrika->src = '';
    $metrika->cmp = '';
    $metrika->cnt = '';
    $metrika->trim = '';
    $metrika->uag = '';
    $metrika->visit =1;
    $metrika->promocod ='';
    $metrika->_gid = '';
    $metrika->_ym_uid ='';
    $metrika->olev_phone_track =$did;
    $metrika->ip ='';
    $metrika->utm_source = '';
    $metrika-> site_id=$widget->sites_id;
    $metrika-> my_company_id= $widget->my_company_id;
    $metrika->reports_date = date('Y-m-d');
    $metrika->updated_at = date('Y-m-d H:i:s');
    $metrika->created_at = date('Y-m-d H:i:s');
    $metrika->reports_date = date('Y-m-d');
    $metrika->bot = 0;
    $metrika->save();
    
    
    
}

                }


            }


            $z0 = 0;

            if ($is_static == 0) {
                $MetricaCurrent = new MetricaCurrent();


            $MetricaCurrent->setTable('metrica_' . $widget->my_company_id);

            $metrika = $MetricaCurrent->where('olev_phone_track', $request->did)->orderby('id', 'desc')->first();
            if ($metrika) {
                $hash = $metrika->neiros_visit;
            } else {
                $hash = $this->get_ncl_id_withiut_neiros($widget->my_company_id, $request->src, $widget->sites_id);
            }

        }
            $getallwid = Project::where('widget_id', $widget->id)->count();
            $getallwid++;

         /*   $provss=Project::where('phone',$request->src)->where('site_id' , $widget->sites_id)
                ->where('reports_date',date('Y-m-d'))
                ->where('hour', date("H", time()))->first();*/
         /*   if($provss){Log::info('INPUT CALL 7');
                return '';
            }*/

            $projectId = $this->create_lead([
                'name' => $widget->name . '№ ' . $getallwid,
                'stage_id' => $widget->stage_id,
                'user_id' => $widget->user_id,
                'summ' => 0,
                'comment' => $widget->name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'fio' => '',
                'company' => '',
                'widget_id' => $widget->id,
                'email' => '',
                'phone' => $request->src,
                'my_company_id' => $widget->my_company_id,
                'neiros_visit' => $hash,
                'vst' => 0,
                'pgs' => 0,
                'url' => '',
                'phone_to_call' =>$did,
                'reports_date' => date('Y-m-d'),
                'uniqueid' => $request->uniqueid,
                'site_id' => $widget->sites_id,
                'week' => date("W", time()),
                'hour' => date("H", time())
            ], []);

            if ((isset($metrika))&&($metrika)) {

                if ($z0 == 0) {

                   /* Project::where('id', $projectId)->update([
                        'vst' => $metrika->visit,
                        'url' => $metrika->ep
                    ]);*/



                } else {
                    Project::where('id', $projectId)->update([
                        'vst' => 1,
                        'url' => $metrika->ep
                    ]);
                    

                }

                try {
                    $this->generate_1($widget->sites_id, $metrika->typ, $widget->tip, $widget->my_company_id, $projectId, $metrika->src, $metrika->trim);
                } catch (\Exception $e) {
                    Log::info($e);
                }

            }


           

        }else{

        }

    }


    public function inputjs($key, Request $request)
    {
        $site = $this->getSite($key);
        if (!$site) {
            return '';
        }


        $widget = $this->getWidget_site_first($site->id, 3);


        if ($widget) {
            $z0 = 0; $hash = '';
            $MetricaCurrent=new MetricaCurrent();
            $MetricaCurrent->setTable('metrica_'.$widget->my_company_id);
            $metrika = $MetricaCurrent->where('hash', $request->hash)->orderby('id', 'desc')->first();
            if ($metrika) {
                $hash = $metrika->hash;
            } /*else {
                $metrika = DB::table('metrika_first')->where('hash', $request->hash)->orderby('id', 'desc')->first();
                if ($metrika) {
                    $z0 = 1;
                    $hash = $metrika->hash;
                } else {

                }
            }*/
            $getallwid = Project::where('widget_id', $widget->id)->count();
            $getallwid++;
            $projectId = $this->create_lead([
                'name' => $widget->name . '№ ' . $getallwid,
                'stage_id' => $widget->stage_id,
                'user_id' => $widget->user_id,
                'summ' => 0,
                'comment' => $request->info,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'fio' => "Заказ от " . $request->name,
                'company' => '',
                'widget_id' => $widget->id,
                'email' => $request->email,
                'phone' => $request->phone,
                'my_company_id' => $widget->my_company_id,
                'client_hash' => $request->hash,
                'vst' => 0,
                'pgs' => 0,
                'url' => '',
                'week' => date("W", time()),
                'hour' => date("H", time()),
                'site_id' => $widget->sites_id
            ], []);




            if ($metrika) {

                if ($z0 == 0) {


                    Project::where('id', $projectId)->update([
                        'vst' => $metrika->visit,
                        'url' => $metrika->ep
                    ]);


                } else {
                    Project::where('id', $projectId)->update([
                        'vst' => 1,
                        'url' => $metrika->ep
                    ]);
                   /* DB::table('metrika_first')->where('id', $metrika->id)->update(['project_id' => $projectId]);*/


                }


            }

            header('Access-Control-Allow-Origin:*');
            $responsea = $request->jsoncallback . "(" . json_encode('') . ")";
            return $responsea;

        }
    }

    public function form_call(Request $request)
    {
        /*/*http://cloud.neiros.ru/api/widget/form/call?format=json&jsoncallback=?&hash=a5f3faaa-36c0-4329-bca1-98c3835972a4&visit=5&pgs=1&phone=79530986997&url=http://wistis.ru/&widget_key=werwerwer&callback=jsonp_callback_37604*/;
        $widget = $this->getWidget($request->widget_key);
        if ($widget) {
            $getallwid = Project::where('widget_id', $widget->id)->count();
            $getallwid++;
            $projectId = $this->create_lead([
                'name' => $widget->name . '№ ' . $getallwid,
                'stage_id' => $widget->stage_id,
                'user_id' => $widget->user_id,
                'summ' => 0,
                'comment' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'fio' => '',
                'company' => '',
                'email' => '',
                'widget_id' => $widget->id,
                'phone' => $request->phone,
                'my_company_id' => $widget->my_company_id,
                'client_hash' => $request->hash,
                'vst' => $request->visit,
                'pgs' => $request->pgs,
                'url' => $request->url,
                'week' => date("W", time()),
                'hour' => date("H", time())
            ], []);




            $widget_tags = Widget_tags::where('project_id', $widget->id)->get();
            foreach ($widget_tags as $widget_tag) {

                Projects_tag::insert([
                    'project_id' => $projectId,
                    'tag_id' => $widget_tag->tag_id

                ]);
            }


            $subject = 'Запрос обратного звонка с сайта ' . $widget->site;
            $text = '<table style="width: 400px">
<tr>
<td>№ Сделки</td>
<td>101' . $widget->my_company_id . '' . $projectId . '</td>
</tr>
<tr>
<td>Телефон</td>
<td>' . $request->phone . '</td>
</tr>
<tr>
<td>URL</td>
<td>' . $request->url . '</td>
</tr>
<td>Время</td>
<td>' . date(' H:i:s d.m.y') . '</td>
</tr>
</table>';
            $this->send_email($widget, $subject, $text);

            return '';

        } else {
            return '';
        }


    }


    public function widgetcallbackjs($id)
    {
        $widgets_promokod = DB::table('widget_callback')->where('id', $id)->first();
        $data['widget'] = $widgets_promokod;

        return view('jsview.callback', $data)->render();
    }

    public function widgetcatchlead($id)
    {
        $widgets_promokod = DB::table('widget_catch_lead')->where('id', $id)->first();
        $data['widget'] = $widgets_promokod;

        return view('jsview.catch_lead', $data)->render();
    }

    public function widgetchatjs($id)
    {

        $data['widget_soc']['social_vk_url']='';
        $data['widget_soc']['social_ok_url']='';
        $data['widget_soc']['social_fb_url']='';
        $data['widget_soc']['social_viber_url']='';
        $data['widget_soc']['social_tele_url']='';

        $widgets_promokod = DB::table('widgets_chat')->where('id', $id)->first();
        $data['widget'] = $widgets_promokod;

        $wts1=DB::table('widgets')->where('id',$widgets_promokod->widget_id)
            ->first();
        $wts=DB::table('widgets')->where('tip',12)->where('sites_id',$wts1->sites_id)->first();

            $widgets_ss = DB::table('widgets_chat')
                ->where('my_company_id', $widgets_promokod->my_company_id)
                ->where('widget_id',$wts->id)->first();  ;
;            if($widgets_ss){
                $data['widget_soc']['social_vk_url']=$widgets_ss->social_vk_url;
                $data['widget_soc']['social_ok_url']=$widgets_ss->social_ok_url;
                $data['widget_soc']['social_fb_url']=$widgets_ss->social_fb_url;
                $data['widget_soc']['social_viber_url']=$widgets_ss->social_viber_url;
                $data['widget_soc']['social_tele_url']=$widgets_ss->social_tele_url;


            }




        return view('chat.chatjs', $data)->render();
    }

    public function get_widget_site($key, Request $request)
    {


        $site = $this->getSite($key);
        if (!$site) {
            return '';
        }


        $widgets = $this->getWidget_site($site->id);


        $pathVersion = [
            'version' => '1',
            'sub_version' => '28.02.' . time()
        ];
        $phon = '';

        $data['widget']['version'] = $pathVersion['version'];
        $data['site'] = $site->name;
        $data['widget']['key'] = $key;
        $data['path']['formCall'] = $_ENV['APP_URL'] . "/api/v" . $pathVersion['version'] . "/widget/form/call";
        $data['path']['formMail'] = $_ENV['APP_URL'] . "/api/v" . $pathVersion['version'] . "/widget/form/mail";
        $data['widget']['element'] = [];
        $data['widget']['tip_9'] = 0;
        $data['widget']['tip_email'] = '';
        $data['widget']['tip_email_1'] = '';
        $data['widget']['tip_email_2'] = '';
        $data['widget']['tip_email_3'] = '';
        $data['widget']['tip_2_routing'] = [];

        $data['widget']['tip_email_4'] = 0;
        $data['widget']['phone'] = '';
        $data['widget']['phone2'] = '';
        $data['widget']['withurl'] = 0;
        $data['widget']['phone_status'] = 0;
        $data['widget']['phone_status_dinamic'] = 0;
        $data['widget']['tip_0'] = 0;
        $data['widget']['tip_1'] = 0;
        $data['widget']['tip_1_timer'] = 0;
        $data['widget']['tip_1_dop'] = 0;
        $data['widget']['tip_1_osn'] = 0;
        $data['widget']['tip_1_form'] = 0;
        $data['widget']['tip_1_form_url'] = '';
        $data['widget']['tip_1_dop_url'] = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/js/modul_form.min.js?ver=" . $pathVersion['sub_version'];
        $data['widget']['tip_1_osn_url'] = '';
        $data['widget']['tip_12_url'] = '';
        $data['widget']['tip_2'] = 0;
        $data['widget']['tip_0_color'] = '';
        $data['widget']['tip_0_background'] = '';
        $data['widget']['tip_0_position_x'] = '';
        $data['widget']['tip_0_position_y'] = '';
        $data['widget']['tip_3'] = 0;
        $data['widget']['tip_12'] = 0;
        $data['widget']['tip_12_write_chat'] = 1;
        $data['widget']['tip_timer_12'] = 0;
        $data['widget']['tip_mess_12'] = '';
        $data['widget']['tip_name_12'] = '';
        $data['widget']['tip_who_12'] = '';
        $data['widget']['tip_13'] = 0;
        $data['widget']['phone_static'] = [];
        $data['widget']['tip_13_url'] = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/js/modul_popup.js?ver=" . $pathVersion['sub_version'];
        $data['widget']['tip_13_forms'] = [];
        $data['widget']['tip_13_form_timer'][0] = '';;
        $data['widget']['tip_13_doit'][0]['send'] = '';
        $data['widget']['tip_13_doit'][0]['close'] = '';
        $data['widget']['tip_13_doitmass'] = [];
        $data['widget']['tip_1_social_on'] = 0;
        $data['widget']['tip_13_wistisform'] = [];
        $data['widget']['tip_13_wistisformid'] = [];

        $data['widget']['tip_19_timer'] = 0;
        $data['widget']['tip_19_status'] = 0;
        $data['widget']['tip_19_show'] = 0;
        $data['widget']['tip_19_url'] = '';
        /*  echo "var CBU_GLOBAL = {}; var neiros_visit='';var neiros_url_vst;CBU_GLOBAL['config'] = {widget: {element: '" . $widget->element . "',phone:'" . $phon . "'} };";*/
        $data['widget']['tip_1_soc']['social_vk_url']='';
        $data['widget']['tip_1_soc']['social_ok_url']='';
        $data['widget']['tip_1_soc']['social_fb_url']='';
        $data['widget']['tip_1_soc']['social_viber_url']='';
        $data['widget']['tip_1_soc']['social_tele_url']='';
        $js = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/js/f.min.js?ver=" . time() . "" . $pathVersion['sub_version'];
        $char = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 12)->first();
        $widgets_promokodz = DB::table('widgets_chat')->where('widget_id', $char->id)->first();
        $data['widget']['tip_12_url'] = $_ENV['APP_URL'] . "/api/widgetchatjs/" . $widgets_promokodz->id;
        foreach ($widgets as $widget) {

            $data['widget']['tip_' . $widget->tip] = 1;

            if ($widget->tip == 23) {

                $data['widget']['tip_1_social_on'] = (int)$widget->status;
            }

            if ($widget->tip == 1) {
                $widgets_popup = DB::table('widget_callback')->where('widget_id', $widget->id)->first();
                $data['widget']['tip_1_timer'] = (int)$widgets_popup->timer;
                if ($widgets_popup->dop_form == 1) {
                    $data['widget']['tip_1_dop'] = 1;
                }
                if ($widgets_popup->active_form == 1) {
                    $data['widget']['tip_1_form'] = 1;
                }
                if ($widgets_popup->active_osn == 1) {
                    $data['widget']['tip_1_osn'] = 1;
                    $data['widget']['tip_1_osn_url'] = $_ENV['APP_URL'] . "/api/widgetcallback/" . $widgets_popup->id;
                }






            }
            if ($widget->tip == 19) {
                $widgets_popup = DB::table('widget_catch_lead')->where('widget_id', $widget->id)->first();
                $data['widget']['tip_19_timer'] = (int)$widgets_popup->callback_timer;
                $data['widget']['tip_19_status'] = 1;
                $data['widget']['tip_19_url'] = $_ENV['APP_URL'] . "/api/widgetcatchlead/" . $widgets_popup->id;
                $data['widget']['tip_19_show'] = (int)$widgets_popup->everyday;
            }


            if ($widget->tip == 13) {
                $widgets_popup = DB::table('widgets_popup')->where('widget_id', $widget->id)->first();
                if ($widgets_popup) {

                    $widgets_popup_forms = DB::table('widgets_popup_form')->where('widget_popup_id', $widgets_popup->id)->where('parent_id', 0)->get();
                    $fi = 0;


                    echo "(function(s,o,g,a,m){a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.rel='stylesheet';a.href=g;m.parentNode.insertBefore(a,m)})(document,'link','https://cloud.neiros.ru/vendor/formeo/demo/assets/css/new.css');";

                    foreach ($widgets_popup_forms as $widgets_popup_form) {
                        if ($widgets_popup_form->is_ab == 1) {
                            $widgets_popup_form_ab = DB::table('widgets_popup_form')->where('widget_popup_id', $widgets_popup->id)->where('parent_id', $widgets_popup_form->id)->first();

                            if ($widgets_popup_form->fshow <= $widgets_popup_form_ab->fshow) {
                                $vivod_form = $widgets_popup_form;
                            } else {
                                $vivod_form = $widgets_popup_form_ab;
                            }


                        } else {

                            $vivod_form = $widgets_popup_form;
                        }

                        $data['widget']['tip_13_forms'][$fi]['id'] = $vivod_form->id;
                        $data['widget']['tip_13_forms'][$fi]['openTrigger'] = 'time';/*  click, modal, time*/
                        $data['widget']['tip_13_forms'][$fi]['openIn'] = intval($vivod_form->timer); /*miliseconds*/
                        $data['widget']['tip_13_forms'][$fi]['openOnUrls'] = [];//массив где открывается форма
                        $data['widget']['tip_13_forms'][$fi]['triggerModal'] = "44";//ID модалки которую открывает форма
                        $data['widget']['tip_13_forms'][$fi]['formAction'] = "https://cloud.neiros.ru/api/popup/" . $site->hash;//Куда отправлять форму
                        $data['widget']['tip_13_forms'][$fi]['formHtml'] = '<form class="wistisform" id="wistisform' . $vivod_form->id . '">' . str_replace('id="', 'id="wis_', $vivod_form->html_form) . '</form>';

                        $data['widget']['tip_13_forms'][$fi]['openOnce'] = false;
                        $buttondoit = DB::table('widgets_popup_template_pole')->where('form_id', $vivod_form->id)->wherein('doit', [5, 6])->get();
                        foreach ($buttondoit as $bduit) {
                            if ($bduit->doit == 5) {
                                $data['widget']['tip_13_doit'][$fi] ['send'] = 'wis_' . $bduit->pole_id;
                                $data['widget']['tip_13_doitmass']['wis_' . $bduit->pole_id] = $fi;
                                $data['widget']['tip_13_wistisform']['wis_' . $bduit->pole_id] = $vivod_form->id;

                            }
                            if ($bduit->doit == 6) {
                                $data['widget']['tip_13_doit'][$fi] ['close'] = 'wis_' . $bduit->pole_id;
                                $data['widget']['tip_13_doitmass']['wis_' . $bduit->pole_id] = $fi;
                                $data['widget']['tip_13_wistisform']['wis_' . $bduit->pole_id] = $vivod_form->id;
                            }


                        }


                        $fi++;
                    }/*конец цикла*/

                }

            }


            if ($widget->tip == 12) {

                Log::useFiles(base_path() . '/storage/logs/steam_apps_sync.log', 'info');


                $widgets_promokod = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();
                $data['widget']['tip_12_url'] = $_ENV['APP_URL'] . "/api/widgetchatjs/" . $widgets_promokod->id;
                $data['widget']['tip_timer_12'] = $widgets_promokod->timer;
               if(is_null($widgets_promokod->first_message)){
                   $data['widget']['tip_mess_12'] = 'Здравствуйте! Чем могу Вам помочь?';
               }else{
                   $data['widget']['tip_mess_12'] = $widgets_promokod->first_message;
               }

                if(is_null( $widgets_promokod->operator_name)){
                    $data['widget']['tip_name_12'] = 'Оператор';
                }else{
                    $data['widget']['tip_name_12'] = $widgets_promokod->operator_name;
                }


                if(is_null( $widgets_promokod->job)){
                    $data['widget']['tip_who_12'] = '';
                }else{
                    $data['widget']['tip_who_12'] = $widgets_promokod->job;
                }






                if ($request->server('HTTP_REFERER')) {


                    $set_oper = DB::table('widgets_chat_url_operator')->where('widget_id', $widgets_promokod->id)->where('url', $request->server('HTTP_REFERER'))->first();

                    if ($set_oper) {
                        $data['widget']['tip_timer_12'] = $set_oper->timer;
                        if(is_null($set_oper->first_message)){
                            $data['widget']['tip_mess_12'] = 'Здравствуйте! Чем могу Вам помочь?';
                        }else{
                            $data['widget']['tip_mess_12'] = $set_oper->first_message;
                        }

                        if(is_null( $set_oper->operator_name)){
                            $data['widget']['tip_name_12'] = 'Оператор';
                        }else{
                            $data['widget']['tip_name_12'] = $set_oper->operator_name;
                        }


                        if(is_null( $set_oper->job)){
                            $data['widget']['tip_who_12'] = '';
                        }else{
                            $data['widget']['tip_who_12'] = $set_oper->job;
                        }
                    } else {

                        $set_opers = DB::table('widgets_chat_url_operator')->where('widget_id', $widgets_promokod->id)->where('url', "LIKE", "%*%")->get();

                        foreach ($set_opers as $set_oper) {
                            $mystring = 'abc';
                            $findme = 'a';
                            $pos = strpos($request->server('HTTP_REFERER'), trim($set_oper->url, "*"));

// Заметьте, что используется ===.  Использование == не даст верного
// результата, так как 'a' находится в нулевой позиции.
                            if ($pos === false) {

                            } else {
                                $data['widget']['tip_timer_12'] = $set_oper->timer;
                                if(is_null($set_oper->first_message)){
                                    $data['widget']['tip_mess_12'] = 'Здравствуйте! Чем могу Вам помочь?';
                                }else{
                                    $data['widget']['tip_mess_12'] = $set_oper->first_message;
                                }

                                if(is_null( $set_oper->operator_name)){
                                    $data['widget']['tip_name_12'] = 'Оператор';
                                }else{
                                    $data['widget']['tip_name_12'] = $set_oper->operator_name;
                                }


                                if(is_null( $set_oper->job)){
                                    $data['widget']['tip_who_12'] = '';
                                }else{
                                    $data['widget']['tip_who_12'] = $set_oper->job;
                                }

                            }


                        }


                    }


                }


            }
            $js = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/js/f.min.js?ver=" . time() . $pathVersion['sub_version'];
            $js2 = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/js/sourcebuster.min.js?ver=" . $pathVersion['sub_version'];
            if ($widget->tip == 0) {
                $widgets_promokod = DB::table('widgets_promokod')->where('widget_id', $widget->id)->first();
                if ($widgets_promokod) {
                    $data['widget']['tip_0_color'] = $widgets_promokod->color;
                    $data['widget']['tip_0_background'] = $widgets_promokod->background;
                    $data['widget']['tip_0_position_x'] = $widgets_promokod->position_x;
                    $data['widget']['tip_0_position_y'] = $widgets_promokod->position_y;


                }
            }

            if ($widget->tip == 2) {
                /*$data['widget']['tip_2_routing']*/

                $widget_canals=WidgetCanal::pluck('code','id')->toArray();
                $phone_routing=Widgets_phone_routing::where('widget_id', $widget->id)->where('status',1)->get();
                $fs=0;
foreach ($phone_routing as $itemrout) {



            $data['widget']['tip_2_routing'][$fs]['id'] = $itemrout->id;
        $data['widget']['tip_2_routing'][$fs]['type'] = $itemrout->tip_calltrack;


        $all_class_replace=json_decode($itemrout->all_class_replace);
      $textzamen=[];
        if(is_array($all_class_replace)){
            $imm=0;
            for($k=0;$k<count($all_class_replace);$k++){
             if((isset($all_class_replace[$k]->ar_class_replace_type))&&(isset($all_class_replace[$k]->ar_class_replace))){

if($all_class_replace[$k]->ar_class_replace==''){
    $textzamen[]='';

}else{
    $textzamen[]=$all_class_replace[$k]->ar_class_replace_type.''.$all_class_replace[$k]->ar_class_replace;
}


             }


            }

            $data['widget']['tip_2_routing'][$fs]['class_replace']=implode(',',$textzamen);

           /* if($itemrout->class_replace==''){
                $data['widget']['tip_2_routing'][$fs]['class_replace'] ='';
            }else{
                $data['widget']['tip_2_routing'][$fs]['class_replace'] =$itemrout->ar_class_replace_type.$itemrout->class_replace;
            }*/

        }


        $data['widget']['tip_2_routing'][$fs]['phone_replace'] = $itemrout->phone_replace;
        $data['widget']['tip_2_routing'][$fs]['is_default'] = $itemrout->is_default;
        $data['widget']['tip_2_routing'][$fs]['canals'] = [];
        if ((is_array($itemrout->canals)) && (count($itemrout->canals) > 0)) {

            for ($kl = 0; $kl < count($itemrout->canals); $kl++) {

                if (isset($widget_canals[$itemrout->canals[$kl]])) {
                    $data['widget']['tip_2_routing'][$fs]['canals'][] = $widget_canals[$itemrout->canals[$kl]] . '1';
                }


            }

        }

        if ($itemrout->tip_calltrack == 1) {
            $phone = DB::table('widgets_phone')->where('routing', $itemrout->id)->where('rezerv', 0)->where('time', '<', time())->first();
         if ($phone) {
                $data['widget']['tip_2_routing'][$fs]['phone'] = $phone->phone;
                $data['widget']['tip_2_routing'][$fs]['phone2'] = $phone->input;

            } else {
                $phone_rez = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('routing', $itemrout->id)->where('rezerv', 1) ->first();




             if ($phone_rez) {
                    $data['widget']['tip_2_routing'][$fs]['phone'] = $phone_rez->phone;
                    $data['widget']['tip_2_routing'][$fs]['phone2'] = $phone_rez->input;


                }  else{
                     $data['widget']['tip_2_routing'][$fs]['phone_status'] = 122;
                 }

             } 



        } else {

            $phone = DB::table('widgets_phone')->where('routing', $itemrout->id)->first();
            if ($phone) {
                $data['widget']['tip_2_routing'][$fs]['phone'] = $phone->phone;
                $data['widget']['tip_2_routing'][$fs]['phone2'] = $phone->input;
            }
        }


        $fs++;


}








                $data['widget']['phone_status'] = 1;
                if($widget->phone_status_dinamic==1){
                $data['widget']['phone_status_dinamic'] = 1;}
                $phon = '';
                $phon2 = '';
                $data['widget']['element'] = explode(',', $widget->element);
                $data['widget']['withurl'] = $widget->withurl;
                $phone = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('rezerv', 0)->where('tip', '1')->where('time', '<', time())->first();
                if ($phone) {
                    $phon = $phone->phone;
                    $phon2 = $phone->input;
                } else {
                    $phone_rez = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('rezerv', 1)->where('tip', '1')->first();
                    if ($phone_rez) {
                        $phon = $phone_rez->phone;
                        $phon2 = $phone_rez->input;
                    } else {

                        $data['widget']['phone_status'] = 122;
                    }

                }
                $data['widget']['phone'] = $phon;
                $data['widget']['phone2'] = $phon2;

                $phone_statics = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('tip', 2)->select('utm_campaign as cmp', 'utm_content as cnt', 'utm_medium as mdm', 'utm_source as src', 'utm_term as trm', 'static_url as reffer', 'phone', 'input')->get();


                $l = 0;

                foreach ($phone_statics as $phone_static) {
                    if (!isset($data['widget']['phone_static'][$l]['utms'])) {
                        $data['widget']['phone_static'][$l]['utms'] = [];
                    }
                    if ($phone_static->cmp != '') {
                        $data['widget']['phone_static'][$l]['utms'][] = 'cmp:' . $phone_static->cmp;
                    }
                    if ($phone_static->cnt != '') {
                        $data['widget']['phone_static'][$l]['utms'][] = 'cnt:' . $phone_static->cnt;
                    }
                    if ($phone_static->mdm != '') {
                        $data['widget']['phone_static'][$l]['utms'][] = 'mdm:' . $phone_static->mdm;
                    }
                    if ($phone_static->trm != '') {
                        $data['widget']['phone_static'][$l]['utms'][] = 'trm:' . $phone_static->trm;
                    }
                    if ($phone_static->src != '') {
                        $data['widget']['phone_static'][$l]['utms'][] = 'src:' . $phone_static->src;
                    }
                    if ($phone_static->reffer != '') {
                        $data['widget']['phone_static'][$l]['utms'][] = 'reffer:' . $phone_static->reffer;
                    }
                    if ($phone_static->phone != '') {
                        $data['widget']['phone_static'][$l]['phone'] = $phone_static->phone;
                    }
                    if ($phone_static->input != '') {
                        $data['widget']['phone_static'][$l]['input'] = $phone_static->input;
                    }


                    $l++;

                }


            }
            if ($widget->tip == 9) {
                $email = DB::table('widgets_email')->where('widget_id', $widget->id)->first();
                if ($email) {
                    $data['widget']['tip_9'] = 1;
                    $data['widget']['tip_email'] = $email->email;
                    $em = explode('@', $email->email);
                    $data['widget']['tip_email_1'] = $em[0];
                    $data['widget']['tip_email_2'] = $em[1];
                    $data['widget']['tip_email_3'] = $email->element;

                    if ($email->url == 1) {
                        $data['widget']['tip_email_4'] = 1;
                    }

                }
            }
            //js +


        }
        echo "var CBU_GLOBAL = {};var neiros_visit='';var neiros_url_vst='';var DINAMICPHONE='';CBU_GLOBAL['config'] = " . json_encode($data) . "; ";

        echo "(function (s, o, g, a, m) {
    a = s.createElement(o),
        m = s.getElementsByTagName('head')[0];
    a.async = 1;
    a.charset = 'utf-8';
    a.src = g;
    m.appendChild(a);
})(document,'script','" . $js . "');";


        /*Подключение силей*/
        $css = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/css/f.min.css?ver=" . $pathVersion['sub_version'];
        echo "(function (s, o, g, a, m) {
    a = s.createElement(o),
        m = s.getElementsByTagName('head')[0];
    a.async = 1;
    a.rel = 'stylesheet';
    a.href = g;
    m.appendChild(a);
})(document,'link','" . $css . "');";


    }

    public function get($key, Request $request)
    {


        $widget = $this->getWidget($key);


        //if ($widget && gethostbyname($_SERVER['HTTP_REFERER']) == $widget->domain_ip){
        if ($widget) {
            //if ($widget) {

            $pathVersion = [
                'version' => '0',
                'sub_version' => '1.0.1'
            ];


            if ($widget->tip == 1) {

                $css = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/css/f.min.css?ver=" . $pathVersion['sub_version'];
                $js = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/js/f.min.js?ver=" . time() . $pathVersion['sub_version'];
                $js2 = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/js/sourcebuster.min.js?ver=" . $pathVersion['sub_version'];
            }
            if ($widget->tip == 0) {

                $css = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/css/fs.min.css?ver=" . $pathVersion['sub_version'];
                $js2 = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/js/sp.js?ver=" . $pathVersion['sub_version'];


            }
            if ($widget->tip == 2) {


                $js2 = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/js/ct.js?ver=" . $pathVersion['sub_version'];

            }

            //js +
            if ($widget->tip < 2) {

                echo "var CBU_GLOBAL = {};var neiros_visit='';var neiros_url_vst='';var DINAMICPHONE='';CBU_GLOBAL['config'] = {widget: {key: '" . $widget->hash . "'},path: {formCall: '" . $_ENV['APP_URL'] . "/api/widget/form/call',formMail: '" . $_ENV['APP_URL'] . "/api/widget/form/mail'}};";
            } else {

                $phone = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('rezerv', 0)->where('tip', '1')->where('time', '<', time())->first();
                if ($phone) {
                    $phon = $phone->phone;
                } else {
                    $phone = DB::table('widgets_phone')->where('tip', '1')->where('widget_id', $widget->id)->where('rezerv', 1)->first();
                    $phon = $phone->phone;
                }


                echo "var CBU_GLOBAL = {};var DINAMICPHONE='';var neiros_visit='';var neiros_url_vst;='';CBU_GLOBAL['config'] = {widget: {element: '" . $widget->element . "',phone:'" . $phon . "'} };";
            }

            echo "(function(s,o,g,a,m){a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.charset='utf-8';a.src=g;m.parentNode.insertBefore(a,m)})(document,'script','" . $js2 . "'); ";
            if ($widget->tip == 1) {

                echo "(function(s,o,g,a,m){a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.charset='utf-8';a.src=g;m.parentNode.insertBefore(a,m)})(document,'script','" . $js . "');";
            }


            if ($widget->tip < 2) {
                echo "(function(s,o,g,a,m){a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.rel='stylesheet';a.href=g;m.parentNode.insertBefore(a,m)})(document,'link','" . $css . "');";

            }

        } else {
            $error = "console.error('%c : Please, check your widget script! Administrator E-mail ->  . Thank you!', 'color:white;background:#DB2828;font-weight:bold;font-size:16px;');";
            echo $error;
        }

    }

    public function get_bot_metrika($key, Request $request)
    {



        $ua = $request->myua;

        $bot_url = $request->myurl;

        $clearn_bot_url = explode('?', $bot_url)[0];

        $isbot_yandex = $this->isBot_y($ua);
        $isbot_goggle = $this->isBot_g($ua);

        /*Заход яндекса*/
        if ($isbot_yandex == 1) {
            $url_bot = DB::table('widgets_catcher_bots_url_map')->where('url', '=', $clearn_bot_url)->where('stek_y', 1)->first();
            if ($url_bot) {
                $come_y = $url_bot->come_y + 1;
                DB::table('widgets_catcher_bots_url_map')->where('id', $url_bot->id)->update([
                    'come_y' => $come_y,
                    'time_y_come' => date('Y-m-d'),


                ]);
            }

        }
        /*Заход гугла*/
        if ($isbot_goggle == 1) {
            $url_bot = DB::table('widgets_catcher_bots_url_map')->where('url', '=', $clearn_bot_url)->where('stek_g', 1)->first();
            if ($url_bot) {
                $come_g = $url_bot->come_g + 1;
                DB::table('widgets_catcher_bots_url_map')->where('id', $url_bot->id)->update([
                    'come_g' => $come_g,
                    'time_g_come' => date('Y-m-d'),


                ]);
            }

        }
        $widget = DB::table('widgets_catcher_bots')->where('id', $key)->first();
        if (!$widget) {
            return '';
        }
        $data['res'] = 0;
        $data['new_url'] = '<ul class="class_ul">';
        if ($isbot_yandex == 1) {
            $new_urls = DB::table('widgets_catcher_bots_url_map')->where('stek_y', 1)->limit($widget->amount_url)
                ->where('show_y', 0)->where('come_y', 0)->get();
            foreach ($new_urls as $new_url) {
                $data['new_url'] .= '<li><a href="' . $new_url->url . '">' . $new_url->title . '</a>';


            }
            $data['res'] = 1;
        }
        if ($isbot_goggle == 1) {
            $new_urls = DB::table('widgets_catcher_bots_url_map')->where('stek_g', 1)->limit($widget->amount_url)
                ->where('show_g', 0)->where('come_g', 0)->get();
            foreach ($new_urls as $new_url) {
                $data['new_url'] .= '<li><a href="' . $new_url->url . '">' . $new_url->title . '</a>';


            }
            $data['res'] = 1;
        }

        $data['new_url'] .= '</ul>';

        $data['id_replace'] = $widget->id_replace;


        header('Access-Control-Allow-Origin:*');
        $responsea = $request->jsoncallback . json_encode($data);

        return $responsea;


    }

    public function get_bot($key, Request $request)
    {
        $widget = DB::table('widgets_catcher_bots')->where('id', $key)->first();
        if (!$widget) {
            return '';
        }


        echo "var CBU_GLOBAL1 =$key;";

        $pathVersion = [
            'version' => '1',
            'sub_version' => '1.0.1'
        ];


        $js2 = $_ENV['APP_URL'] . "/cdn/v" . $pathVersion['version'] . "/js/bot.js?ver=" . $pathVersion['sub_version'];


        echo "(function(s,o,g,a,m){a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.charset='utf-8';a.src=g;m.parentNode.insertBefore(a,m)})(document,'script','" . $js2 . "'); ";


    }


    public function isBot_y($ua)
    {
        /* Эта функция будет проверять, является ли посетитель роботом поисковой системы */
        $bots = array('YandexBot', 'YandexBot');
        foreach ($bots as $bot) {
            if (isset($ua)) {
                if (stripos($ua, $bot) !== false) {


                    return 1;
                }
            }


        }
        return 0;

    }

    public function isBot_g($ua)
    {
        /* Эта функция будет проверять, является ли посетитель роботом поисковой системы */
        $bots = array('Googlebot', 'Googlebot','AdsBot-Google');
        foreach ($bots as $bot) {
            if (isset($ua)) {
                if (stripos($ua, $bot) !== false) {


                    return 1;
                }
            }


        }
        return 0;

    }

    public function isBot_all($ua)
    {
        /* Эта функция будет проверять, является ли посетитель роботом поисковой системы */
        $bots = array('Googlebot', 'Googlebot', 'YandexBot');
        foreach ($bots as $bot) {
            if (isset($ua)) {
                if (stripos($ua, $bot) !== false) {


                    return 1;
                }
            }


        }
        return 0;

    }
public function neiros_utm($input_data,$metrika,$my_company_id,$site_id){

if(isset($input_data['neiros'])){
$neiros_array=explode('_',$input_data['neiros']);
if(count($neiros_array)>0){
    $utm=new NeirosUtm();
    for ($i=0;$i<5;$i++) {
if(isset($neiros_array[$i])) {
    $utm->{'neiros_p' . $i} = trim($neiros_array[$i],'"');
}

    }
}else{return '';}
}else{
    return;
}
    if(isset($input_data['neiros_referrer'])){
$utm->neiros_referrer=$input_data['neiros_referrer'];
    }
    if(isset($input_data['neiros_position'])){
        $neiros_position=explode('_',$input_data['neiros_position']);
        if(count($neiros_array)>0){

            for ($i=0;$i<2;$i++) {
                if(isset($neiros_array[$i])) {
                $utm->{'neiros_p' . $i} =trim($neiros_array[$i],'"');
                }

            }
        }
    }
    if(isset($input_data['neiros_visit'])){

        $utm->neiros_visit=$input_data['neiros_visit'];
    }else{
        $utm->neiros_visit=0;
    }

    $utm->metrica_current_id=$metrika;
    $utm->my_company_id=$my_company_id;
    $utm->site_id=$site_id;
    $utm->save();
}
    public function metrika_first($key, Request $request)
    {


        Log::useFiles(base_path() . '/storage/logs/WidgetApiController.log', 'info');
        $data = $request->input();

        $data_user = DB::table('sites')->where('hash', $key)->first();
        if (!$data_user) {
            return '';
        }


        $neiros_visit = DB::table('neiros_user_all')->insertGetId([
            'site_id' => $data_user->id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),

        ]);

if(strlen($request->_ym_uid)>9){

        $_ym_id=new NeirosMetricaSid();
        $_ym_id->neiros_visit=$neiros_visit;
        $_ym_id->_ym_uid=$request->_ym_uid;
        $_ym_id->froms=2;
        $_ym_id->save();
}
        if(strlen($request->_gid)>5){

            $_ym_id=new NeirosGaSid();
            $_ym_id->neiros_visit=$neiros_visit;
            $_ym_id->_ym_uid=$request->_gid;
            $_ym_id->froms=2;

            $_ym_id->save();
        }

        $data_request['neiros_url_vst'] = DB::table('metrica_visits')->insert([
            'url' => trim($data['url'], '"'),
            'site_id' => $data_user->id,
            'vst' => 1,
            'neiros_visit' => $neiros_visit,
            'reports_date' => date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ]);

        $data_request['neiros_visit'] = $neiros_visit;
if(is_numeric($request->roistat_visit)){
    $roi=DB::table('metrica_roistat')->where('roistat_visit',$request->roistat_visit)
        ->where('neiros_visit',$neiros_visit)->first();
    if(!$roi){
        DB::table('metrica_roistat')->insert([
            'roistat_visit'=>$request->roistat_visit,
            'neiros_visit'=>$neiros_visit,


        ]) ;
    }

}
        if($request->phone_status_dinamic==0){
            if (strlen($request->olev_phone_track2) > 3) {

                DB::table('widgets_phone')->where('input', $request->olev_phone_track2)->update([
                    'time' => (time() + $data_user->phone_rezerv_time)

                ]);

            }
        }else{
            if (strlen($request->olev_phone_track2) > 3) {
                if($request->show_phone==1) {
                    DB::table('widgets_phone')->where('input', $request->olev_phone_track2)->update([
                        'time' => (time() + $data_user->phone_rezerv_time)

                    ]);
                }
            }


        }

       /* try{
            $rec_all['neiros_visit']=$neiros_visit;
            $this->neiros_utm($rec_all,0,$data_user->my_company_id, $data_user->id);}catch (\Exception $e){

        }*/



        header('Access-Control-Allow-Origin:*');
        $responsea = json_encode($data_request);// $request->jsoncallback . "(" . json_encode('') . ")";
        return $responsea;


    }

    public function metrika($key, Request $request)
    {


        Log::useFiles(base_path() . '/storage/logs/WidgetApiController.log', 'info');
        $data = $request->input();

        $data_user = DB::table('sites')->where('hash', $key)->first();
        if (!$data_user) {
            return '';
        }

        if (!isset($data['current'])) {
            return '';
        }
        if (!isset($data['current_add'])) {
            return '';
        }
        $first_add = json_decode($data['current_add']);
        $current = json_decode($data['current']);


        $neiros_visit_sql = DB::table('neiros_user_all')->where('id', $request->neiros_visit)->first();
        if (!$neiros_visit_sql) {
            return '';
        } else {


        }
        $neiros_visit = $request->neiros_visit;

        $block=BlackListNeirosIds::where('neiros_visit',$neiros_visit)->first();
        if($block){


            header('Access-Control-Allow-Origin:*');
            $responsea = json_encode('911');// $request->jsoncallback . "(" . json_encode('') . ")";
            return $responsea;
        }


        /*установка международных кук */
        if (strlen($request->_ym_uid) > 9) {
            $_ym_id = NeirosMetricaSid::where('neiros_visit', $neiros_visit)->first();
            if (!$_ym_id) {
                $_ym_id = new NeirosMetricaSid();
            }

            $_ym_id->froms = 1;
            $_ym_id->neiros_visit = $neiros_visit;
            $_ym_id->_ym_uid = trim($request->_ym_uid, '"');
            $_ym_id->save();
        }

        if (strlen($request->_gid) > 5) {
            $_ym_id = NeirosGaSid::where('neiros_visit', $neiros_visit)->first();
            if (!$_ym_id) {
                $_ym_id = new NeirosGaSid();
            }

            $_ym_id->froms = 1;
            $_ym_id->neiros_visit = $neiros_visit;
            $_ym_id->_ym_uid = trim($request->_gid, '"');
            $_ym_id->save();
        }


        $udata = json_decode($data['udata']);
        $first_add = json_decode($data['first_add']);
        if (!isset($first_add->hash)) {
            $first_add = json_decode($data['first']);
        }
        if (!isset($first_add->hash)) {
            $first_add = json_decode($data['current_add']);
        }
        $first = json_decode($data['first']);
        if (!isset($first_add->typ)) {
            $first = json_decode($data['first']);
        }


        if (!isset($udata->vst)) {
            return '11';
        }

        $data_request['neiros_url_vst'] = DB::table('metrica_visits')->insertGetId([
            'url' => trim($data['url'], '"'),
            'site_id' => $data_user->id,
            'vst' => $udata->vst,
            'neiros_visit' => $neiros_visit,
            'reports_date' => date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ]);


        if ($request->phone_status_dinamic == 0) {
            if (strlen($request->olev_phone_track2) > 3) {

                DB::table('widgets_phone')->where('input', $request->olev_phone_track2)->update([
                    'time' => (time() + $data_user->phone_rezerv_time)

                ]);

            }
        } else {
            if (strlen($request->olev_phone_track2) > 3) {
                if ($request->show_phone == 1) {
                    DB::table('widgets_phone')->where('input', $request->olev_phone_track2)->update([
                        'time' => (time() + $data_user->phone_rezerv_time)

                    ]);
                }
            }


        }


        $current_add = json_decode($data['current_add']);


        $utm_source = '';
        try {
            $rek = explode("?", $current_add->ep);
            if (isset($rek[1])) {
                $zk = explode("&", $rek[1]);
                for ($i = 0; $i < count($zk); $i++) {
                    $ll = explode('=', $zk[$i]);


                    if ($ll[0] == 'utm_source') {

                        $utm_source = $ll[1];
                    }
                }


            }
        } catch (\Exception $e) {

        }


        try {
            if (isset($current->typ)) {
                $typ = $current->typ;
                $src = $current->src;


            } else {
                $typ = $current_add->typ;
                $src = $current_add->src;

            }
        } catch (\Exception $e) {

            header('Access-Control-Allow-Origin:*');
            $responsea = $request->jsoncallback . "(" . json_encode('') . ")";
            return $responsea;
        }
        if (!isset($src)) {


            header('Access-Control-Allow-Origin:*');
            $responsea = $request->jsoncallback . "(" . json_encode('') . ")";
            return $responsea;

        }
        $ya_arr = ['yandex', 'yandex.ru', 'yandex.by', 'yandex.com', 'yandex.com.tr', 'yandex.fr', 'yandex.kz', 'yandex.ua', 'yandex.uz'];
        if (($current->typ == 'referral') && (in_array($current->src, $ya_arr))) {

            $typ = 'organic';
        }


        if (!isset($current_add->fd)) {


            header('Access-Control-Allow-Origin:*');
            $responsea = $request->jsoncallback . "(" . json_encode('') . ")";
            return $responsea;

        }

        if ($this->isBot_all($udata->uag) == 1) {
            return '';
        }
        $pos = strpos($current_add->rf, $data_user->project_name);


        if ($pos === false) {
$typ2=$typ;
            $prov_src=SrcCompact::where('src', $current->src)->first();
            if($prov_src){

                $src=$prov_src->name;

               if($typ=='referral') {
                   if ($prov_src->typ == 1) {
                       $typ2 = 'organic';
                   }

               }
            }else{
                $src= $current->src;


            }

        $MetricaCurrent = new MetricaCurrent();
        $MetricaCurrent->setTable('metrica_' . $data_user->my_company_id);
        $MetricaCurrent->key_user = $key;
        $MetricaCurrent->fd = $current_add->fd;
        $MetricaCurrent->ep = $current_add->ep;
        $MetricaCurrent->rf = $current_add->rf;
        $MetricaCurrent->neiros_visit = $neiros_visit;
        $MetricaCurrent->typ = $typ2;
        //$MetricaCurrent->osn_typ2 = $typ;
        $MetricaCurrent->mdm = $current->mdm;
        $MetricaCurrent->src = $src;
        $MetricaCurrent->src_old = $current->src;
        $MetricaCurrent->cmp = $current->cmp;
        $MetricaCurrent->cnt = $current->cnt;
       if(isset($current->trm)){
        $MetricaCurrent->trim = $current->trm;}
        $MetricaCurrent->uag = $udata->uag;
        $MetricaCurrent->visit = $udata->vst;
        $MetricaCurrent->promocod = trim($data['promo'], '"');
        $MetricaCurrent->_gid = trim($request->_gid, '"');
        $MetricaCurrent->_ym_uid = trim($request->_ym_uid, '"');
        $MetricaCurrent->olev_phone_track = $request->olev_phone_track2;
        $MetricaCurrent->ip = $request->ip();
        $MetricaCurrent->utm_source = $utm_source;
        $MetricaCurrent->my_company_id = $data_user->my_company_id;
        $MetricaCurrent->site_id = $data_user->id;
        $MetricaCurrent->reports_date = date('Y-m-d');
        $MetricaCurrent->updated_at = date('Y-m-d H:i:s');
        $MetricaCurrent->created_at = date('Y-m-d H:i:s');
        $MetricaCurrent->reports_date = date('Y-m-d');
        $MetricaCurrent->bot = $this->isBot_all($udata->uag);
        $MetricaCurrent->save();
        $met_cur_id = $MetricaCurrent->id;


        $rec_all = $request->all();
        try {
            $this->neiros_utm($rec_all, $met_cur_id, $data_user->my_company_id, $data_user->id);
        } catch (\Exception $e) {

        }
        /* DB::connection('mongodb')->collection('metrica_new')->insert(
            [
                'key_user' => $key,
                'reports_date' => date('Y-m-d'),
                'bot' => $this->isBot_all($udata->uag),
                 'hash' => $first_add->hash,

                'my_company_id' => $data_user->my_company_id,
                'site_id' => $data_user->id,

            ]


        );*/

        try {
            $ip = $request->ip();
CityIp::get_ip($neiros_visit,$ip);


        } catch (\Exception $e) {

           
        }


        if (is_numeric($request->roistat_visit)) {
            $roi = DB::table('metrica_roistat')->where('roistat_visit', $request->roistat_visit)
                ->where('neiros_visit', $neiros_visit)->first();
            if (!$roi) {
                DB::table('metrica_roistat')->insert([
                    'roistat_visit' => $request->roistat_visit,
                    'neiros_visit' => $neiros_visit,


                ]);
            }

        }
    }
        header('Access-Control-Allow-Origin:*');
        $responsea = json_encode($data_request);// $request->jsoncallback . "(" . json_encode('') . ")";
        return $responsea;


    }

    public function popup_doit($key, Request $request)
    {
        $data = $request->input();

        $full_data = json_decode(urldecode($request->formdata));
        $forma = $request->forma;

        $formammm = DB::table('widgets_popup_form')->where('id', $forma)->first();
        if ($request->tipdo == 0) {

            $nf = $formammm->fshow + 1;
            DB::table('widgets_popup_form')->where('id', $forma)->update([
                'fshow' => $nf
            ]);
        }
        if ($request->tipdo == 1) {

            $nf = $formammm->fcloze + 1;
            DB::table('widgets_popup_form')->where('id', $forma)->update([
                'fcloze' => $nf
            ]);
        }


        $all = $request->all();

        header('Access-Control-Allow-Origin:*');
        $data['ans'] = 'true';

        echo $all['callback'] . '(' . json_encode($data) . ')';


        $responsea = $request->jsoncallback . "(" . json_encode('') . ")";
        return $responsea;


    }

    public function popup_input($key, Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $val) {

        }
        $full_data = json_decode(urldecode($request->formdata));
        $forma = $request->forma;

        $formammm = DB::table('widgets_popup_form')->where('id', $forma)->first();
        $nf = $formammm->forder + 1;
        DB::table('widgets_popup_form')->where('id', $forma)->update([
            'forder' => $nf
        ]);


        $email = '';
        $name = '';
        $city = '';
        $phone = '';
        $mes_pochta = '';
        $mes_comment = '';
        $datasformi = explode("&", $full_data);
        for ($datasformiI = 0; $datasformiI < count($datasformi); $datasformiI++) {
            $data_array_f = explode('=', $datasformi[$datasformiI]);
            if (isset($data_array_f[1])) {
                $get_from_table = DB::table('widgets_popup_template_pole')->where('form_id', $forma)->where('pole_id', $data_array_f[0])->first();
                if ($get_from_table) {
                    /*емаид*/
                    if ($get_from_table->doit == 1) {
                        $email = $data_array_f[1];

                    }
                    if ($get_from_table->doit == 2) {
                        $phone = $data_array_f[1];

                    }
                    if ($get_from_table->doit == 3) {
                        $name = $data_array_f[1];

                    }
                    if ($get_from_table->doit == 4) {
                        $city = $data_array_f[1];

                    }
                    $mes_pochta .= '<tr>
<td>' . $get_from_table->tag . '</td>
<td>' . $data_array_f[1] . '</td>
</tr>';
                    $mes_comment .= $get_from_table->tag . ': ' . $data_array_f[1] . "\n";


                }


            }


        }


        $site = $this->getSite($key);
        if (!$site) {
            return 'nonesite';
        }


        $widget = $this->getWidget_site_first($site->id, 13);


        if ($widget) {

            $getallwid = Project::where('widget_id', $widget->id)->count();
            $getallwid++;


            $projectId = $this->create_lead([
                'name' => $widget->name . '№ ' . $getallwid,
                'stage_id' => $widget->stage_id,
                'user_id' => $widget->user_id,
                'summ' => 0,
                'comment' => $mes_comment,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'fio' => $name,
                'company' => '',
                'widget_id' => $widget->id,
                'email' => $email,
                'phone' => $phone,
                'my_company_id' => $widget->my_company_id,
                'client_hash' => $request->first_add,
                'vst' => $request->visit,
                'pgs' => $request->pgs,
                'url' => $request->url,
                'site_id' => $widget->sites_id,
                'week' => date("W", time()),
                'hour' => date("H", time())
            ], []);




            $MetricaCurrent=new MetricaCurrent();
            $MetricaCurrent->setTable('metrica_'.$widget->my_company_id);
            $metrika = $MetricaCurrent->where('project_id', $projectId)->first();
            if ($metrika) {
                try {
                    $this->generate_1($widget->sites_id, $metrika->typ, $widget->tip, $widget->my_company_id, $projectId, $metrika->src, $metrika->trim);
                 } catch ( \Exception $e) {


                }
            }
            $widget_tags = Widget_tags::where('project_id', $widget->id)->get();
            foreach ($widget_tags as $widget_tag) {

                Projects_tag::insert([
                    'project_id' => $projectId,
                    'tag_id' => $widget_tag->tag_id

                ]);
            }
            $subject = 'Форма на сайте ' . $widget->site;
            $text = '<table style="width: 400px">
<tr>
<td>№ Сделки</td>
<td>101' . $widget->my_company_id . '' . $projectId . '</td>
</tr>
 ' . $mes_pochta . '
<tr>
<td>URL</td>
<td>' . $request->url . '</td>
</tr>
<td>Время</td>
<td>' . date(' H:i:s d.m.y') . '</td>
</tr>
</table>';
            $this->send_email($widget, $subject, $text);
            $all = $request->all();

            header('Access-Control-Allow-Origin:*');
            $data['ans'] = 'true';

            echo $all['callback'] . '(' . json_encode($data) . ')';

        } else {
            $all = $request->all();

            header('Access-Control-Allow-Origin:*');
            $data['ans'] = 'nonesite';

            echo $all['callback'] . '(' . json_encode($data) . ')';
        }


        header('Access-Control-Allow-Origin:*');
        $responsea = $request->jsoncallback . "(" . json_encode('') . ")";
        return $responsea;


    }

    public function formCall(Request $request)
    {
        $all = $request->all();

        $data = [];
        //1. Widget_key
        //2. IP
        //3.

        if ($this->checkWidget($all['widget_key'])) {

            $widget = $this->getWidget($all['widget_key']);

            //if ($request->ip() == $widget->domain_ip || true) {
            if (true) {
                //if (1 + 1 == 2) {
                //get user id

                $structure = [
                    "user_id" => $widget->user_id,
                    "widget_id" => $widget->id,
                    "phone" => $all['phone'],
                    "type" => "1",
                    "datetime" => $datetime = (new \DateTime('Europe/Moscow'))->format('Y-m-d h:i:s'),
                    "url" => $all['url'],
                ];

                $this->Mailer->send($widget->email, 'Колбекус | Новый лид: Звонок', 'emails.lead.call_request', $structure);

                if ($this->addLead($structure)) {
                    $data['ans'] = 'true';
                } else {
                    $data['ans'] = 'false';
                }
            } else {
                $data['ans'] = 'false';
            }

        } else {
            $data['ans'] = 'false';
        }

        echo $all['callback'] . '(' . json_encode($data) . ')';
    }

    public function formMail(Request $request)
    {
        $all = $request->all();

        $data = [];
        //1. Widget_key
        //2. IP
        //3.

        if ($this->checkWidget($all['widget_key'])) {

            $widget = $this->getWidget($all['widget_key']);

            //if ($request->ip() == $widget->domain_ip || true) {
            if (true) {

                $structure = [
                    "user_id" => $widget->user_id,
                    "widget_id" => $widget->id,
                    "name" => $all['name'],
                    "email" => $all['email'],
                    "text" => $all['text'],
                    "type" => "2",
                    "datetime" => $datetime = (new \DateTime('Europe/Moscow'))->format('Y-m-d h:i:s'),
                    "url" => $all['url'],
                ];
                //$this->Mailer->send($widget->email, 'Колбекус | Новый лид: Сообщение', 'emails.lead.mail_request', $structure);

                if ($this->addLead($structure)) {
                    $data['ans'] = 'true';
                } else {
                    $data['ans'] = 'false';
                }
            } else {
                $data['ans'] = 'false';
            }

        } else {
            $data['ans'] = 'false';
        }

        echo $all['callback'] . '(' . json_encode($data) . ')';
    }

    private function checkWidget($key)
    {
        return DB::table('widgets')->where('hash', $key)->count() == 1;
    }

    private function getWidget($key)
    {
        return DB::table('widgets')->where('hash', $key)->first();
    }

    public function getWidget_site($site_id)
    {

        return DB::table('widgets')->where('sites_id', $site_id)->where('status', 1)->get();

    }

    public function getWidget_site_first($site_id, $tip)
    {

        return DB::table('widgets')->where('sites_id', $site_id)->where('tip', $tip)->where('status', 1)->first();

    }

    private function getSite($key)
    {
        return DB::table('sites')->where('hash', $key)->first();
    }

    private function checkIp($ip, $w_ip)
    {
        return $ip == $w_ip;
    }

    private function addLead($data)
    {

        return DB::table('leads')->insertGetId($data);
    }

    public function send_email($email, $subject, $text)
    {

        if (strlen($email) > 2) {
            $mail['mail'] = explode(',', $email);
            // $mail['mail']='admin@webklick.ru';
            $mail['subject'] = $subject;
            $data['text'] = $text;

            try {
                Mail::send(['html' => 'email'], $data, function ($message) use ($mail) {


                    $message->to($mail['mail'], '');

                    $message->subject($mail['subject']);
                });
            } catch (Exception $e) {

            }
        }

    }

    public function generate_1($site_id, $typ, $widget_tip, $my_company_id, $project_id, $src, $keyword)
    {


        $prov = DB::table('call_amount')
            ->where('date', date('Y-m-d', time()))
            ->where('site_id', $site_id)
            ->where('my_company_id', $my_company_id)
            ->where('typ', $typ)
            ->where('widget_tip', $widget_tip)->first();
        /*'project_ids'=>$ids*/
        if (!$prov) {
            DB::table('call_amount')->insert([
                'amount' => 1,
                'date' => date('Y-m-d', time()),
                'site_id' => $site_id,
                'my_company_id' => $my_company_id,
                'amount_uniq' => 0,
                'typ' => $typ,
                'widget_tip' => $widget_tip,
                'project_ids' => $project_id

            ]);

        } else {
            $i = $prov->amount + 1;
            $s = $prov->project_ids . ',' . $project_id;
            DB::table('call_amount')
                ->where('id', $prov->id)
                ->update([
                    'amount' => $i,
                    'project_ids' => $s
                ]);


        }
/////////////////////////////////////2 часть
///    DB::table('call_amount_2')->insert([
//        'amount' => $am,
//        'date' => date('Y-m-d', $a),
//        'site_id' => $widget->sites_id,
//        'my_company_id' => $widget->my_company_id,
//        'amount_uniq' => $am2,
//        'typ' => $k[$i],
//        'widget_tip' => $widget->tip,
//        'src' => $all->src,
//        'project_ids' => implode(',',$amxxx)
//
//    ]);
/////////////////////////////////////2 часть
        $prov2 = DB::table('call_amount_2')
            ->where('date', date('Y-m-d', time()))
            ->where('site_id', $site_id)
            ->where('my_company_id', $my_company_id)
            ->where('typ', $typ)
            ->where('src', $src)
            ->where('widget_tip', $widget_tip)->first();
        if (!$prov2) {

            DB::table('call_amount_2')->insert([
                'amount' => 1,
                'date' => date('Y-m-d', time()),
                'site_id' => $site_id,
                'my_company_id' => $site_id,
                'amount_uniq' => 0,
                'typ' => $typ,
                'widget_tip' => $widget_tip,
                'src' => $src,
                'project_ids' => $project_id
            ]);
        } else {
            $i = $prov2->amount + 1;
            $s = $prov2->project_ids . ',' . $project_id;
            DB::table('call_amount_2')
                ->where('id', $prov2->id)
                ->update([
                    'amount' => $i,
                    'project_ids' => $s
                ]);

        }


/////////////////////////////////////2 часть
        if ($typ == 'utm') {

            /* DB::table('call_amount_3')->insert([
                                'amount' => $am,
                                'date' => date('Y-m-d', $a),
                                'site_id' => $widget->sites_id,
                                'my_company_id' => $widget->my_company_id,
                                'amount_uniq' => $am2,
                                'typ' => $k[$i],
                                'widget_tip' => $widget->tip,
                                'src' => $all2->src,
                                'project_ids' => implode(',', $amxxx),
                                'keyword' => $all2->trim,

                            ]);*/


            $prov3 = DB::table('call_amount_3')
                ->where('date', date('Y-m-d', time()))
                ->where('site_id', $site_id)
                ->where('my_company_id', $my_company_id)
                ->where('typ', $typ)
                ->where('src', $src)
                ->where('keyword', $keyword)
                ->where('widget_tip', $widget_tip)->first();
            if (!$prov3) {

                DB::table('call_amount_3')->insert([
                    'amount' => 1,
                    'date' => date('Y-m-d', time()),
                    'site_id' => $site_id,
                    'my_company_id' => $site_id,
                    'amount_uniq' => 0,
                    'typ' => $typ,
                    'widget_tip' => $widget_tip,
                    'src' => $src,
                    'keyword' => $keyword,
                    'project_ids' => $project_id
                ]);
            } else {
                $i = $prov3->amount + 1;
                $s = $prov3->project_ids . ',' . $project_id;
                DB::table('call_amount_3')
                    ->where('id', $prov2->id)
                    ->update([
                        'amount' => $i,
                        'project_ids' => $s
                    ]);

            }


        }


/////////////////////////////////////2 часть


    }




    public function update_mertica_to_neiros_visit($pole1, $val1, $data, $proj){

        $datanew['widget_id'] = $proj->widget_id;
        $datanew['sub_widget'] = $proj->sub_widget;
        $datanew['project_id'] = $proj->id;
        $datanew['reports_date'] = date('Y-m-d');
        $ad_arr = array_merge($datanew, $data);

        try {
            $MetricaCurrent = new MetricaCurrent();
            $MetricaCurrent->setTable('metrica_' . $proj->my_company_id);
            $z = $MetricaCurrent->where($pole1, $val1)->orderby('id', 'desc')->first();
            if($z) {
                $MetricaCurrent = new MetricaCurrent();
                $MetricaCurrent->setTable('metrica_' . $proj->my_company_id)->where('id', $z->id)
                    ->update($ad_arr);
            }
        }catch (\Exception $e){

            dd($proj,$e);
        }

    }





    public function catch_lead_send_step(Request $request)
    {


        DB::table('widget_catch_lead_ab_view')->where('ab_id', $request->ab)->where('hash', $request->hash)->update([
            'step_end' => $request->step,
            'step_2' => $request->step_1,
            'step_1' => $request->step_0,
            'lead' => $request->lead,
            'project_id' => $request->project_id,

        ]);


    }

    public function widget_api_routers(Request $request)
    {



 

    }



public function get_neiros_visit($social,$site_id){

$res=DB::table('widgets_chat_social_click')->where('status',0)->where('sites_id',$site_id)
    ->where('social',$social)->orderby('id','desc')->first();
if($res){
    $time=time()-900;
    if($time<$res->time){
     DB::table('widgets_chat_social_click')->where('id' , $res->id)->update(['status'=>1]);
    return $res->neiros_visit;}
}
return 0;
}


}

