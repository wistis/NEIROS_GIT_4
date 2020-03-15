<?php

namespace App\Http\Controllers;

use App\Models\MetricaCurrent;
use App\Project;
use App\Widgets;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;
use App\Http\Controllers\Api\WidgetApiController;

class BitrixController extends Controller
{
    public function android()
    {


        $temas = DB::table('chat_tema')->where('my_company_id', 1)->orderby('status', 'desc')->orderby('updated_at', 'desc')->get();


        return json_encode($temas, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function android2()
    {

        $contfild = DB::table('clients_contacts')->where('client_id', 34)->get();

        $datap['contact']['id'] = 1;
        $data['contact']['name'] = 'Вася Пупкин';
        $i = 0;;
        foreach ($contfild as $item) {

            $data['fields'][$i]['id'] = $item->id;
            $data['fields'][$i]['keytip'] = $item->keytip;
            $data['fields'][$i]['val'] = $item->val;
            $i++;


        }
        $data['keytip'] = DB::table('clients_contacts_tip')->pluck('name', 'keytip');


        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function android3(Request $request)
    {

        Log::info($request);


        return json_encode(['status' => 'ok'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function android4(Request $request)
    {

        Log::info($request);
        /*status:  success | error
        data: token | error code or message*/
        if (($request->login == 'renat') && ($request->password == 'zaripov')) {

            $data['status'] = 'ok';
            $data['key'] = md5(time());

        } else {
            $data['status'] = 'error';
            $data['error_code'] = 401;
        }
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }



    public function start_prov($projectId = null)
    {

        $lead = Project::findOrFail($projectId);
        $widget = DB::table('widgets')->where('tip', 16)->where('my_company_id', $lead->my_company_id)->where('status', 1)->first();
        if ($widget) {

            $widget_crm = DB::table('widgets_bitrix24')->where('widget_id', $widget->id)->first();

            try {
                $this->create_lead($lead, $widget, $widget_crm, $projectId);
            } catch (\Exception $e) {

            }

        }

    }

    public function get_sdelka_id($LEAD_ID, $widget_crm)
    {
        Log::useFiles(base_path() . '/storage/logs/b24_craeatelead.log', 'info');

        $lead = $this->executeREST2('https://' . $widget_crm->server1 . '/rest/crm.deal.list.json?filter[LEAD_ID]=' . $LEAD_ID . '&select[]=ID', 'crm.deal.list',
            [], $widget_crm->token);
        info('ID SDELKA iS NULL');
        info($lead);
        if (isset($lead['error'])) {
            $widget_crm = $this->reload_refresh($widget_crm);

            $lead = $this->executeREST2('https://' . $widget_crm->server1 . '/rest/crm.deal.list.json?filter[LEAD_ID]=' . $LEAD_ID . '&select[]=ID', 'crm.deal.list',
                [], $widget_crm->token);
        }
        /*Инфо о сделке в битриксе*/
        Log::info("INFO LEAD");
        Log::info($lead);
        if (!isset($lead['result'][0]['ID'])) {
            return null;
        }

        if ($lead['result'][0]['ID']) {

            return $lead['result'][0]['ID'];
        } else {
            return null;
        }
    }

    public function reload_refresh($widget_crm)
    {
        $res = file_get_contents('https://oauth.bitrix.info/oauth/token/?grant_type=refresh_token&client_id=' . $widget_crm->APP_ID . '&client_secret=' . $widget_crm->APP_SECRET_CODE . '&refresh_token=' . $widget_crm->refresh_token . '');
        $datainput = json_decode($res);

        DB::table('widgets_bitrix24')->where('id', $widget_crm->id)->update([
            'token' => $datainput->access_token,
            'refresh_token' => $datainput->refresh_token,


        ]);;
        return DB::table('widgets_bitrix24')->where('server1', $widget_crm->server1)->first();
    }

    public function create_lead2($SDELKA_ID, $widget_crm)
    {

        $data['id'] = $SDELKA_ID;
        $data['fields']['STAGE_ID'] = $widget_crm->status_id;

        $lead = $this->executeREST('https://' . $widget_crm->server1 . '/rest/', 'crm.deal.update', $data,
            $widget_crm->token);


        //   Log::info('Лид обновлен' . $widget_crm->status_id);

    }

    public function create_lead($lead, $widget, $widget_crm, $projectId)
    {


        Log::useFiles(base_path() . '/storage/logs/b24_craeatelead.log', 'info');
info('Мы создаем сделку BT24');
        $b24 = $widget_crm;
        if ($b24) {

            define('CRM_HOST', $b24->server1); // Ваш домен CRM системы
            define('CRM_PORT', '443'); // Порт сервера CRM. Установлен по умолчанию
            define('CRM_PATH', '/crm/configs/import/lead.php'); // Путь к компоненту lead.rest
            define('CRM_LOGIN', $b24->login); // Логин пользователя Вашей CRM по управлению лидами
            define('CRM_PASSWORD', $b24->password); // Пароль пользователя Вашей CRM по управлению лидами
            $postData = array(
                'TITLE' => '' // Установить значение
            );
            if (defined('CRM_AUTH')) {
                $postData['AUTH'] = CRM_AUTH;
            } else {
                $postData = array(
                    'TITLE' => "Заявка с сайта: #" . $lead->client_project_id,//$widget->my_company_id.$data['project_id'], //TITLE IS A REQUIRED FIELD FROM BITRIX24 API.

                );

                if ($lead->phone != "") {
                    $postData['PHONE_MOBILE'] = $lead->phone;
                }
                if ($lead->fio != "") {
                    $postData['NAME'] = $lead->fio;
                }
                if ($lead->email != "") {
                    $postData['EMAIL_HOME'] = $lead->email;
                }
                if ($lead->comment != "") {
                    $postData['COMMENTS'] = $lead->comment;
                }

                if (strlen($widget_crm->status_id) > 1) {

                    $postData['TYPE_ID'] = 'SALE';
                    $postData['STAGE_ID'] = $widget_crm->status_id;


                }
                $postData['LOGIN'] = CRM_LOGIN;
                $postData['PASSWORD'] = CRM_PASSWORD;
            }
            $fp = fsockopen("ssl://" . CRM_HOST, CRM_PORT, $errno, $errstr, 30);
            if ($fp) {
                $strPostData = '';


                foreach ($postData as $key => $value)
                    $strPostData .= ($strPostData == '' ? '' : '&') . $key . '=' . urlencode($value);
                $str = "POST " . CRM_PATH . " HTTP/1.0\r\n";
                $str .= "Host: " . CRM_HOST . "\r\n";
                $str .= "Content-Type: application/x-www-form-urlencoded\r\n";
                $str .= "Content-Length: " . strlen($strPostData) . "\r\n";
                $str .= "Connection: close\r\n\r\n";
                $str .= $strPostData;
                fwrite($fp, $str);
                $result = '';
                while (!feof($fp)) {
                    $result .= fgets($fp, 128);
                }
                fclose($fp);
                $response = explode("\r\n\r\n", $result);


                if (isset($response[1])) {
                    $response1 = json_decode(str_replace("'", '"', $response[1]));

                    if ($response1->error_message == 'Лид добавлен') {
info('NТо что пришло когда добавили лид');
info(json_encode($response1));
info('ИД ЛИДА'.$response1->ID);

                        $SDELKA_ID = $this->get_sdelka_id($response1->ID, $widget_crm);
                        info('ИД Сделки '.$SDELKA_ID);

                        Project::where('id', $lead->id)->update([
                            'bt24_id' => $response1->ID
                        ]);
                        /*if (is_null($SDELKA_ID)) {
                            Project::where('id', $lead->id)->update([
                                'bt24_id' => $response1->ID
                            ]);

                            if (strlen($widget_crm->status_id) > 1) {
                                $this->create_lead2($SDELKA_ID, $widget_crm);


                            }

                        }*/

                    }


                }
                //  Log::info($postData);
                //   Log::info($response);
            } else {
                //  Log::info('Connection Failed! ' . $errstr . ' (' . $errno . ')');
            }
        }


    }


    public function bitrix24(Request $request)
    {


        Log::useFiles(base_path() . '/storage/logs/b24_craeatelead1.log', 'info');
        $dta = $request->all();
        info("WEBHOOK");
        info($dta);


        if (in_array($dta['event'], ['ONCRMLEADUPDATE'])) {//Лиды
            Log::info("Входящие данные битрикс 24");
            Log::info($dta);
            Log::info("-----------------------");
            $id = $dta['data']['FIELDS']['ID'];
            $domain = $dta['auth']['domain'];
            $widget_crm = DB::table('widgets_bitrix24')->where('server1', $domain)->first();

            if (!$widget_crm) {
                Log::info('Нет црм битрикса');
                return '';
            }
            $widget = Widgets::where('id', $widget_crm->widget_id)->where('status', 1)->first();
            if (!$widget) {
                //         Log::info('Нет црм битрикса');
                return '';
            }
            Log::info("ЛИДЫ Входящие данные битрикс 24-----".$id);
            $dataform_bitrix = $this->getLead($id, $domain);


            if (isset($dataform_bitrix['error'])) {
                $widget_crm = $this->reload_refresh($widget_crm);

                $dataform_bitrix = $this->getLead($id, $domain);
            }



            $stage = $this->get_status($dataform_bitrix['stage'], $widget_crm);
            $prov_project = Project::where('bt24_id', $dataform_bitrix['bt24_id'])->where('my_company_id', $widget->my_company_id)->first();
            if ($prov_project) {
info('стутус битрикса'.$stage);

if(is_numeric($stage)){
    Project::where('id', $prov_project->id)->update(['stage_id' => $stage, 'summ' => $dataform_bitrix['summ'],

        'bt24_id_client'=>$dataform_bitrix['bt24_id_client']

    ]);


    info('стутус битрикса установили '.$stage);
    info('стутус битрикса установили '.$prov_project->phone);
}else{
    Project::where('id', $prov_project->id)->update([  'stage_id' => 0,'summ' => $dataform_bitrix['summ'],

        'bt24_id_client'=>$dataform_bitrix['bt24_id_client']

    ]);
}
                $this->projectUpdated($prov_project);

            }


        }
        if (in_array($dta['event'], [  'ONCRMDEALADD', 'ONCRMDEALUPDATE'])) {/*Сделки*/
            Log::info("Сделки Входящие данные битрикс 24");
            Log::info($dta);
            Log::info("-----------------------");
            $id = $dta['data']['FIELDS']['ID'];
            $domain = $dta['auth']['domain'];
            $widget_crm = DB::table('widgets_bitrix24')->where('server1', $domain)->first();

            if (!$widget_crm) {
                Log::info('Нет црм битрикса');
                return '';
            }
            $widget = Widgets::where('id', $widget_crm->widget_id)->where('status', 1)->first();
            if (!$widget) {
                //         Log::info('Нет црм битрикса');
                return '';
            }
            Log::info("Входящие данные битрикс 24 Создание сделки-----".$id);





           if($dta['event']=='ONCRMDEALADD'){

               $lead = $this->executeREST('https://' . $widget_crm->server1 . '/rest/', 'crm.deal.get', array('id' => $id),
                   $widget_crm->token);
               if (isset($lead['error'])) {
                   $widget_crm = $this->reload_refresh($widget_crm);
                   $lead = $this->executeREST('https://' . $widget_crm->server1 . '/rest/', 'crm.deal.get', array('id' => $id),
                       $widget_crm->token);
               }
               info('wistis');
               if (isset($lead['error'])) {  return '' ;}

               $get_progect=Project::where('bt24_id',$lead['result']['LEAD_ID'])->first();
          if($get_progect){
              $stage = $this->get_status($lead['result']['STAGE_ID'], $widget_crm);
              info($stage);
              info($lead['result']['STAGE_ID']);
              if(is_numeric($stage)){

                  Project::where('id', $get_progect->id)->update(['stage_id' => $stage, 'summ' => $lead['result']['OPPORTUNITY'],

                      'bt24_id_client'=>$lead['result']['CONTACT_ID'],
                      'bt24_deal_id'=>$lead['result']['ID']

                  ]);
              }else{
                  Project::where('id', $get_progect->id)->update([  'summ' => $lead['result']['OPPORTUNITY'],

                      'bt24_id_client'=>$lead['result']['CONTACT_ID'],
                      'bt24_deal_id'=>$lead['result']['ID']

                  ]);
              }
              $this->projectUpdated($prov_project);
          }elseif(is_numeric($lead['result']['CONTACT_ID'])){
info($lead);
              $get_progect=Project::where('bt24_id_client',$lead['result']['CONTACT_ID'])->where('my_company_id',$widget->my_company_id)->first();
              if($get_progect){
                  $project=$get_progect->replicate();

                  $project->save();
                  $pr=Project::where('site_id',$project->site_id)->max('client_project_id');
                  $new_max=$pr+1;
                  $project->client_project_id=$new_max;
                  $project->name=$lead['result']['TITLE'];
                  $project->widget_id=$widget->id;
                  $project->reports_date=date('Y-m-d');
                  $project->comment="Создано Битрикс";
                  $stage = $this->get_status($lead['result']['STAGE_ID'], $widget_crm);
                  $project->stage_id=$stage;
                  $project->bt24_deal_id=$lead['result']['ID'];
                  $project->save();
                  $this->projectUpdated($prov_project);

              }



          }





 ;
           }

            if($dta['event']=='ONCRMDEALUPDATE'){
                /*Обновлеие сделки*/


                $lead = $this->executeREST('https://' . $widget_crm->server1 . '/rest/', 'crm.deal.get', array('id' => $id),
                    $widget_crm->token);
                if (isset($lead['error'])) {
                    $widget_crm = $this->reload_refresh($widget_crm);
                    $lead = $this->executeREST('https://' . $widget_crm->server1 . '/rest/', 'crm.deal.get', array('id' => $id),
                        $widget_crm->token);
                 }
info('Поиск сделки  с ID'.$id);
                $get_progect=Project::where('bt24_deal_id',$lead['result']['ID'])->first();
                if($get_progect){
                    $stage = $this->get_status($lead['result']['STAGE_ID'], $widget_crm);
                    info($stage);
                    info($lead['result']['STAGE_ID']);
                    Project::where('id', $get_progect->id)->update(['stage_id' => $stage, 'summ' => $lead['result']['OPPORTUNITY'],

                        'bt24_id_client'=>$lead['result']['CONTACT_ID'],
                        'bt24_deal_id'=>$lead['result']['ID']

                    ]);
                    $this->projectUpdated($prov_project);
                }






            }




        }

    }
    public function projectUpdated($project)

    {    Log::useFiles(base_path() . '/storage/logs/toproject_updated.log', 'info');
        info('обновим сумму от битрикса');

        $pr=Project::find($project->id);
        try {
            if($pr){
                if($pr->summ>0) {

                    $find = new MetricaCurrent();
                    $find=$find->setTable('metrica_' . $pr->my_company_id)->where('typ','!=','payment')
                        ->where('project_id', $project->id)->first();
                    if($find){info('метрика найдена');
                        $find ->setTable('metrica_' . $pr->my_company_id);
                        $find->summ=$pr->summ;
                        $find->lead=1;
                        $find->my_company_id =$pr->my_company_id;
                        $find->site_id = $pr->site_id;
                        $find->save();
info(json_encode($find));
                    }else{info('метрика не найдена');
                        LeadPayController::createPayment($pr);


                    }
                    /*  $MetricaCurrent = new MetricaCurrent();


                      $MetricaCurrent->setTable('metrica_' . $project->my_company_id)->where('project_id', $project->id)
                          ->update(['summ'=>$project->summ,'lead'=>1

                          ]);*/

                }
            }
        }catch (\Exception $e){
            info($e);

        }


    }
    public function data_to_project($lead_info, $widget_crm, $id)
    {

        $widget = Widgets::find($widget_crm->widget_id);


        $data['user_id'] = $widget->user_id;
        $data['bt24_id'] = $id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['widget_id'] = $widget->id;
        $data['my_company_id'] = $widget->my_company_id;
        $data['vst'] = 0;

        if (isset($lead_info['fio'])) {
            $data['fio'] = $lead_info['fio'];
        }

        if (isset($lead_info['email'])) {
            $data['fio'] = $lead_info['email'];
        }

        if (isset($lead_info['phone'])) {
            $data['fio'] = $lead_info['phone'];
        }


        $data['stage_id'] = $lead_info['stage_id'];
        $data['pgs'] = 0;
        $data['url'] = '';
        $data['site_id'] = $widget->sites_id;
        $data['week'] = date("W", time());
        $data['hour'] = date("H", time());
        return $data;
    }

    public function get_status($amo_status, $widget_crm)
    {
        $stage = 0;

        $stage_db = DB::table('widgets_bitrix24_status')->where('my_company_id', $widget_crm->my_company_id)->where('widget_crm_id', $widget_crm->id)->where('status_id', $amo_status)->first();
        if ($stage_db) {
            $stage = $stage_db->stages_id;
        }

        return $stage;

    }

    public function bt24callback(Request $request)
    {

        $dta = $request->all();
        Log::info($dta);
    }

    function redirect1($url)
    {
        return Redirect($url);

    }

public function prov_lead_from_lead_id($lead, $server){



    if(isset($lead['result']['LEAD_ID'])){
        if(is_numeric($lead['result']['LEAD_ID'])){
            $get_progect=Project::where('bt24_id',$lead['result']['LEAD_ID'])->first();

            if($get_progect){
                if(($get_progect->bt24_deal_id==0)||(is_null($get_progect->bt24_deal_id))){
                    $get_progect->bt24_deal_id=$lead['result']['LEAD_ID'];
                    $get_progect->stage_id=  $this->get_status($lead['result']['STAGE_ID'], $server);
                    $get_progect->summ=$lead['result']['OPPORTUNITY'];
                    $get_progect->bt24_id_client=$lead['result']['CONTACT_ID'];
                    $get_progect->save();



                }



            }

        }
        }




}

public function get_data_from_lead_to($lead_id,$server){

    $lead_data = $this->executeREST('https://' . $server->server1 . '/rest/', 'crm.deal.get', array('id' => $lead_id),
        $server->token);
      info('Данные из сделки');
      info($lead_data);

}


    public function getLeadCRM($id_lead, $server)
    {




        if (isset($lead['error'])) {

            $res = file_get_contents('https://oauth.bitrix.info/oauth/token/?grant_type=refresh_token&client_id=' . $server->APP_ID . '&client_secret=' . $b24->APP_SECRET_CODE . '&refresh_token=' . $b24->refresh_token . '');
            $datainput = json_decode($res);

            DB::table('widgets_bitrix24')->where('id', $b24->id)->update([
                'token' => $datainput->access_token,
                'refresh_token' => $datainput->refresh_token,


            ]);;
            $b24 = DB::table('widgets_bitrix24')->where('server1', $server)->first();
            $lead = $this->executeREST('https://' . $b24->server1 . '/rest/', 'crm.deal.get', array('id' => $id_lead),
                $b24->token);

        }


        $stage = $lead['result']['STATUS_ID'];
        /* $stage_type = $lead['result']['TYPE_ID'];*/
        $summ = $lead['result']['OPPORTUNITY'];
        $contact_id = $lead['result']['CONTACT_ID'];
        $contact = $this->executeREST('https://' . $b24->server1 . '/rest/', 'crm.contact.get', array('id' => $contact_id),
            $b24->token);
        /* $stage_api = $this->executeREST('https://' . $b24->server1 . '/rest/', 'crm.dealcategory.stage.list', array('id' => $stage_type),
             $b24->token);*/

        if (!isset($contact['result'])) {
            $fio = '';
            $phone = '';
            $email = '';
        } else {
            $fio = $contact['result']['NAME'];
            $phone = $contact['result']['PHONE'][0]['VALUE'];
            $email = $contact['result']['EMAIL'][0]['VALUE'];
        }


        $data['fio'] = $fio;
        $data['phone'] = $phone;
        $data['email'] = $email;
        $data['stage'] = $stage;
        $data['summ'] = $summ;
        $data['bt24_id'] =  $lead['result']['ID'];;

        return $data;
    }

    public function getLead($id_lead, $server)
    {  $fio = '';
        $phone = '';
        $email = '';
        Log::useFiles(base_path() . '/storage/logs/b24_craeatelead.log', 'info');


        $b24 = DB::table('widgets_bitrix24')->where('server1', $server)->first();

        $lead = $this->executeREST('https://' . $b24->server1 . '/rest/', 'crm.lead.get', array('id' => $id_lead),
            $b24->token);

       /* dd($lead,$lead1);*/
        Log::info('get_lead_new');
        Log::info($lead);


        if (isset($lead['error'])) {

            $res = file_get_contents('https://oauth.bitrix.info/oauth/token/?grant_type=refresh_token&client_id=' . $b24->APP_ID . '&client_secret=' . $b24->APP_SECRET_CODE . '&refresh_token=' . $b24->refresh_token . '');
            $datainput = json_decode($res);

            DB::table('widgets_bitrix24')->where('id', $b24->id)->update([
                'token' => $datainput->access_token,
                'refresh_token' => $datainput->refresh_token,


            ]);;
            $b24 = DB::table('widgets_bitrix24')->where('server1', $server)->first();
            $lead = $this->executeREST('https://' . $b24->server1 . '/rest/', 'crm.deal.get', array('id' => $id_lead),
                $b24->token);

        }


        $stage = $lead['result']['STATUS_ID'];
       /* $stage_type = $lead['result']['TYPE_ID'];*/
        $summ = $lead['result']['OPPORTUNITY'];
        $contact_id = $lead['result']['CONTACT_ID'];
       $contact = $this->executeREST('https://' . $b24->server1 . '/rest/', 'crm.contact.get', array('id' => $contact_id),
            $b24->token);
       /* $stage_api = $this->executeREST('https://' . $b24->server1 . '/rest/', 'crm.dealcategory.stage.list', array('id' => $stage_type),
            $b24->token);*/
        if (!isset($contact['error'])) {
            $b24 = $this->reload_refresh($b24);

            $contact = $this->executeREST('https://' . $b24->server1 . '/rest/', 'crm.contact.get', array('id' => $contact_id),
                $b24->token);
        }

        if (!isset($contact['result'])) {
            $fio = '';
            $phone = '';
            $email = '';
        } else {
            $fio = $contact['result']['NAME'];
          if(isset( $contact['result']['PHONE'][0]['VALUE'])){  $phone = $contact['result']['PHONE'][0]['VALUE'];}
          if(isset($contact['result']['EMAIL'][0]['VALUE'])){
              $email = $contact['result']['EMAIL'][0]['VALUE'];
          }

        }


        $data['fio'] = $fio;
        $data['phone'] = $phone;
        $data['email'] = $email;
        $data['stage'] = $stage;
        $data['summ'] = $summ;
        $data['bt24_id_client'] = $lead['result']['CONTACT_ID'];
        $data['bt24_id'] =  $lead['result']['ID'];;
info('data_to_update');
info($data);
        return $data;
    }

    function executeHTTPRequest($queryUrl, array $params = array())
    {
        $result = array();
        $queryData = http_build_query($params);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        ));

        $curlResult = curl_exec($curl);
        curl_close($curl);

        if ($curlResult != '') $result = json_decode($curlResult, true);

        return $result;
    }

    function requestCode($domain)
    {
        $url = 'https://' . $domain . '/oauth/authorize/' .
            '?client_id=' . urlencode(APP_ID);
        return $this->redirect1($url);
    }

    function requestAccessToken(Request $request)
    {
        $user = Auth::user();


        $widget = DB::table('widgets')->where('tip', 16)->where('my_company_id', $user->my_company_id)->first();
        $b24 = DB::table('widgets_bitrix24')->where('widget_id', $widget->id)->first();

        $res = $this->executeHTTPRequest('https://oauth.bitrix.info/oauth/token/?grant_type=authorization_code&client_id=' . $b24->APP_ID . '&client_secret=' . $b24->APP_SECRET_CODE . '&scope=crm,user&code=' . $request->code, []);
        if (isset($res['error'])) {

            return redirect('https://cloud.neiros.ru/widget/tip/10?tip=b24&status=0&mess=' . $res['error']);

        } else {
            DB::table('widgets_bitrix24')->where('id', $b24->id)->update([
                'token' => $res['access_token'],
                'refresh_token' => $res['refresh_token'],


            ]);


            $b24 = DB::table('widgets_bitrix24')->where('widget_id', $widget->id)->first();
            $stage_api = $this->executeREST('https://' . $b24->server1 . '/rest/', 'crm.dealcategory.stage.list', array('id' => 'SALE'),
                $b24->token);

            if (!isset($stage_api['result'])) {
                return redirect('https://cloud.neiros.ru/widget/tip/10?tip=b24&status=0&mess=Ошибка получения статусов . Обратитесь в тех поддержку');

            }
            for ($i = 0; $i < count($stage_api['result']); $i++) {
                $prow_status = DB::table('widgets_bitrix24_status')->where('type','crm')->where('my_company_id', Auth::user()->my_company_id)->where('widget_crm_id', $b24->id)->where('status_id', $stage_api['result'][$i]['STATUS_ID'])->first();
                if (!$prow_status) {

                    DB::table('widgets_bitrix24_status')->insert([
                        'my_company_id' => Auth::user()->my_company_id,
                        'widget_crm_id' => $b24->id,
                        'status_id' => $stage_api['result'][$i]['STATUS_ID'],
                        'status_name' => $stage_api['result'][$i]['NAME'],
                        'type' => 'crm',
                    ]);

                }else{
                    DB::table('widgets_bitrix24_status')->where('id',$prow_status->id)->update([

                        'status_name' => $stage_api['result'][$i]['NAME'],

                    ]);
                }

            }
            $lead1 = $this->executeREST('https://' . $b24->server1 . '/rest/', 'crm.status.list', array('ENTITY_ID'=>'STATUS'),
                $b24->token);
            if (!isset($lead1['result'])) {
                return redirect('https://cloud.neiros.ru/widget/tip/10?tip=b24&status=0&mess=Ошибка получения лидов . Обратитесь в тех поддержку');

            }info($lead1['result']);
            for ($i = 0; $i < count($lead1['result']); $i++) {
                if ($lead1['result'][$i]['ENTITY_ID'] == 'STATUS') {
                    $prow_status = DB::table('widgets_bitrix24_status')->where('my_company_id', Auth::user()->my_company_id)->where('widget_crm_id', $b24->id)->where('type', 'lead')->where('status_id', $lead1['result'][$i]['STATUS_ID'])->first();
                    if (!$prow_status) {

                        DB::table('widgets_bitrix24_status')->insert([
                            'my_company_id' => Auth::user()->my_company_id,
                            'widget_crm_id' => $b24->id,
                            'status_id' => $lead1['result'][$i]['STATUS_ID'],
                            'status_name' => $lead1['result'][$i]['NAME'],
                            'type' => 'lead',
                        ]);
                    }else{
                        DB::table('widgets_bitrix24_status')->where('id',$prow_status->id)->update([

                            'status_name' => $lead1['result'][$i]['NAME'],

                        ]);
                    }

                }
            }


            return redirect('https://cloud.neiros.ru/widget/tip/10?tip=b24&status=1&mess=Интеграця прошла успешно');
        }


    }

    function executeREST2($rest_url, $method, $params, $access_token)
    {

        return $this->executeHTTPRequest($rest_url, array_merge($params, array("auth" => $access_token)));
    }

    function executeREST($rest_url, $method, $params, $access_token)
    {
        $url = $rest_url . $method . '.json';;
        return $this->executeHTTPRequest($url, array_merge($params, array("auth" => $access_token)));
    }

}
