<?php

namespace App\Http\Controllers;

use App\Models\NeirosMetricaSid;
use App\Project;
use App\Widgets;
use Illuminate\Http\Request;
use Auth;
use Log;
use DB;
use Yandex\OAuth\OAuthClient;
use Yandex\OAuth\Exception\AuthRequestException;
use Yandex\Metrica\Management\ManagementClient;

class MetrikaController extends Controller
{


    public function send_to_metrika($project = null)
    {

        Log::useFiles(base_path() . '/storage/logs/tometr.log', 'info');
        $widgetinput = Widgets::with('w10')
            ->where('my_company_id', $project->my_company_id)->where('id', $project->widget_id)
            ->where('status', 1)
            ->first();
        if (!$widgetinput) {
            info('Не найден виджет #' . $project->id);
            return '';
        }
        $tip = $widgetinput->tip;

        $widget = Widgets::with('w10')
            ->where('my_company_id', $project->my_company_id)->where('sites_id', $project->site_id)->where('tip', 10)->where('status', 1)->first();
        if (!$widget) {
            info('Не найден виджет метрики #' . $project->id);
            return '';
        }
        if (is_null($widget->w10)) {
            info('Не найден виджет метрики дополнительный #' . $project->id);
            return '';
        }

        if($widget->w10->token==''){
            info('Токен метрики пустой #' . $project->id);
            return '';
        }

        if($widget->w10->counter==''){
            info('Счетчик пустой #' . $project->id);
            return '';
        }
/*на калбек - callback_neiros
на калтрекинг - calltracking_neiros

*/
        info('SEND METRIKA #' . $project->id);
   if($project->my_company_id==40){

       $cel = 'callback_neiros';
       if ($tip == 1) {
           $cel = 'callback_neiros';
       } elseif ($tip == 2) {
           $cel = 'calltracking_neiros';

       } elseif ($tip == 12) {
           $cel = 'chat_neiros';

       }

   }else{

       $cel = 'callback_neiros';
       if ($tip == 1) {
           $cel = 'neiros_callback';
       } elseif ($tip == 2) {
           $cel = 'neiros_calltracking';

       } elseif ($tip == 12) {
           $cel = 'neiros_chat';

       }


   }
$neiros_uid=NeirosMetricaSid::where('neiros_visit',$project->neiros_visit)->first();
if(!$neiros_uid){
    info('Не найден metrica uid #' . $project->id);
    return '';
}
        info('SEND METRIKA #' . $project->id.$cel);


    try{

        info(' try SEND METRIKA #' . $project->id);
        $oauthToken =$widget->w10->token; // OAuth-токен
        $counterId =$widget->w10->counter; // идентификатор счетчика
        $client_id_type = 'CLIENT_ID'; // или USER_ID

        $metrikaOffline = new \Meiji\YandexMetrikaOffline\Conversion($oauthToken);
        $metrikaConversionUpload = $metrikaOffline->upload($counterId, $client_id_type);
        info('Counter =' . $counterId);
        info('Client type =' . $client_id_type);
        info('UID ' . $neiros_uid->_ym_uid);

        $time = time() - 100;  info('Time ' . $time);
        $metrikaConversionUpload->addConversion($neiros_uid->_ym_uid, $cel, $time); // Добавяем конверсию

        info(' try SEND METRIKA11 #' . $project->id);
        $uploadResult = $metrikaConversionUpload->send();
        info('Отправлено #' . $project->id);
        info(json_encode($uploadResult));
    }catch (\Exception $e){
        info('Ошибка отправки #' . $project->id);
        info($e);

    }
        return '';
    }


    public function set_token($id)
    {

        $user = Auth::user();;
        $states = $id;
        $client = new OAuthClient('8549813dbac24d5d9d038d054362c7e9');


//Передать в запросе какое-то значение в параметре state, чтобы Yandex в ответе его вернул

        $client->authRedirect(true, OAuthClient::CODE_AUTH_TYPE, $states);

    }

    public function widget_metrika_token(Request $request)
    {
        $user = Auth::user();;
        $client = new OAuthClient('8549813dbac24d5d9d038d054362c7e9', '21a9ae11fea4479d982fb2c510acc515');

        try {
            // осуществляем обмен
            $client->requestAccessToken($_REQUEST['code']);
        } catch (AuthRequestException $ex) {
            echo $ex->getMessage();
        }

// забираем полученный токен
        $token = $client->getAccessToken();
        DB::table('widget_metrika')->where('id', $_REQUEST['state'])->where('my_company_id', $user->my_company_id)->update(['token' => $token]);



        $wm = DB::table('widget_metrika')->where('id', $_REQUEST['state'])->first();


        $managementClient = new ManagementClient($token);
        $params = new \Yandex\Metrica\Management\Models\CountersParams();
        $params
            ->setType(\Yandex\Metrica\Management\AvailableValues::TYPE_SIMPLE)
            ->setField('goals,mirrors,grants,filters,operations');
        $counters = $managementClient
            ->counters()
            ->getCounters($params)
            ->getCounters();
        /*INSERT INTO `metrika_counter`(`id`, `my_company_id`, `site_id`, `widget_id`, `widget_metrika_id`, `counter`, `site`, `status`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])

        */
        DB::table('metrika_counter')->where('my_company_id', $user->my_company_id)->where('widget_metrika_id', $wm->id)->delete();
        $widget = DB::table('widgets')->where('id', $wm->widget_id)->first();
        foreach ($counters as $counter) {


            DB::table('metrika_counter')->insert([
                'my_company_id' => $user->my_company_id,
                'site_id' => $widget->sites_id,
                'widget_id' => $wm->widget_id,
                'widget_metrika_id' => $wm->id,
                'counter' => $counter->getId(),
                'site' => $counter->getSite(),
                'status' => 0,


            ]);


        }
        return redirect('/widget/tip/10');
    }

    public function widget_metrika_get_keywords($widget, $widget_email, $last_upload)
    {
        /*https://api-metrika.yandex.ru/stat/v1/data?preset=sources_search_phrases&dimensions=ym:s:lastSearchPhrase,ym:s:clientID,ym:s:dateTime,ym:s:lastSearchEngine,ym:s:lastSearchEngineRoot&id=24199885&oauth_token=AQAEA7qh4kdaAAUc-jOREKB5YUNah-D2H9Y6PT0&limit=100*/


        $zapros = 'https://api-metrika.yandex.ru/stat/v1/data?preset=sources_search_phrases&dimensions=ym:s:date,ym:s:deviceCategory,ym:s:firstVisitStartOfHour,ym:s:ipAddress,ym:s:flashEnabled,ym:s:lastSearchPhrase,ym:s:lastSearchEngine,ym:s:lastSearchEngineRoot&id=' . $widget_email->counter . '&oauth_token=' . $widget_email->token . '&limit=300&date1=' . $last_upload;


        $otvet = file_get_contents($zapros);
        $otvet_encode = json_decode($otvet);
        $datas = $otvet_encode->data;
        $insert = array();
        for ($i = 0; $i < count($datas); $i++) {

            //    $datas[$i]->dimensions[0]->name;//data
            //    $datas[$i]->dimensions[2]->name;//first_date_time
            //    $datas[$i]->dimensions[3]->name;//ip

            $insert[$i]['datavisit'] = $datas[$i]->dimensions[0]->name;//data
            $insert[$i]['datetimevisit'] = $datas[$i]->dimensions[2]->name;//data
            $insert[$i]['ip'] = $datas[$i]->dimensions[3]->name;//data


            $insert[$i]['keyword'] = $datas[$i]->dimensions[5]->name;//data
            // $insert[$i]['ids']=$datas[$i]->dimensions[1]->name;
            //  $insert[$i]['created_at']=d;
            $insert[$i]['my_company_id'] = $widget->my_company_id;
            $insert[$i]['widget_metrika_id'] = $widget_email->id;
            $insert[$i]['counter'] = $widget_email->counter;
            $insert[$i]['widget_id'] = $widget->id;
            $insert[$i]['SearchEngine'] = $datas[$i]->dimensions[6]->name;;
            $insert[$i]['SearchEngine_id'] = $datas[$i]->dimensions[6]->id;
            $insert[$i]['SearchEngineRoot'] = $datas[$i]->dimensions[7]->name;


        }
        DB::table('metrika_keywords_import')->insert($insert);
        $total_rows = $otvet_encode->total_rows;
        $amount = floor($total_rows / 300);

        for ($is = 1; $is <= $amount; $is++) {
            $ofset = $is * 300 + 1;
            $zapros = 'https://api-metrika.yandex.ru/stat/v1/data?preset=sources_search_phrases&dimensions=ym:s:date,ym:s:deviceCategory,ym:s:firstVisitStartOfHour,ym:s:ipAddress,ym:s:flashEnabled,ym:s:lastSearchPhrase,ym:s:lastSearchEngine,ym:s:lastSearchEngineRoot&id=' . $widget_email->counter . '&oauth_token=' . $widget_email->token . '&offset=' . $ofset . '&limit=300&date1=' . $last_upload;

            $otvet = file_get_contents($zapros);
            $otvet_encode = json_decode($otvet);
            $datas = $otvet_encode->data;
            $insert = array();
            for ($i = 0; $i < count($datas); $i++) {


                $insert[$i]['datavisit'] = $datas[$i]->dimensions[0]->name;//data
                $insert[$i]['datetimevisit'] = $datas[$i]->dimensions[2]->name;//data
                $insert[$i]['ip'] = $datas[$i]->dimensions[3]->name;//data


                $insert[$i]['keyword'] = $datas[$i]->dimensions[5]->name;//data
                // $insert[$i]['ids']=$datas[$i]->dimensions[1]->name;
                //  $insert[$i]['created_at']=d;
                $insert[$i]['my_company_id'] = $widget->my_company_id;
                $insert[$i]['widget_metrika_id'] = $widget_email->id;
                $insert[$i]['counter'] = $widget_email->counter;
                $insert[$i]['widget_id'] = $widget->id;
                $insert[$i]['SearchEngine'] = $datas[$i]->dimensions[6]->name;;
                $insert[$i]['SearchEngine_id'] = $datas[$i]->dimensions[6]->id;
                $insert[$i]['SearchEngineRoot'] = $datas[$i]->dimensions[7]->name;


            }

            DB::table('metrika_keywords_import')->insert($insert);

        }


    }


    public function widget_metrika_get_keywords2($widget, $widget_email, $last_upload)
    {
        /*https://api-metrika.yandex.ru/stat/v1/data?preset=sources_search_phrases&dimensions=ym:s:lastSearchPhrase,ym:s:clientID,ym:s:dateTime,ym:s:lastSearchEngine,ym:s:lastSearchEngineRoot&id=24199885&oauth_token=AQAEA7qh4kdaAAUc-jOREKB5YUNah-D2H9Y6PT0&limit=100*/
        $gets = DB::table('metrika_keywords_import')->get();
        foreach ($gets as $get) {

            $prov = DB::table('metrika_current_region')->where('ip', 'LIKE', trim($get->ip, '.xxx') . '%')->first();
            if ($prov) {
                DB::table('metrika_keywords_import')->where('id', $get->id)->update([
                    'hash' => $prov->hash
                ]);

            }

        }
        dd(1);
        $zapros = 'https://api-metrika.yandex.ru/stat/v1/data?preset=sources_search_phrases&dimensions=ym:s:date,ym:s:deviceCategory,ym:s:firstVisitStartOfHour,ym:s:flashEnabled,ym:s:clientID,ym:s:lastSearchEngine,ym:s:lastSearchEngineRoot&id=' . $widget_email->counter . '&oauth_token=' . $widget_email->token . '&limit=300&date1=' . $last_upload;


        $otvet = file_get_contents($zapros);
        $otvet_encode = json_decode($otvet);
        $datas = $otvet_encode->data;
        $insert = array();
        for ($i = 0; $i < count($datas); $i++) {

            //    $datas[$i]->dimensions[0]->name;//data
            //    $datas[$i]->dimensions[2]->name;//first_date_time
            //    $datas[$i]->dimensions[3]->name;//ip

            DB::table('metrika_keywords_import')->where('datetimevisit', $datas[$i]->dimensions[2]->name)->where('SearchEngine_id', $datas[$i]->dimensions[5]->id)->where('datavisit', $datas[$i]->dimensions[0]->name)->update(['ids' => $datas[$i]->dimensions[4]->name

            ]);


        }

        $total_rows = $otvet_encode->total_rows;
        $amount = floor($total_rows / 300);

        for ($is = 1; $is <= $amount; $is++) {
            $ofset = $is * 300 + 1;
            $zapros = 'https://api-metrika.yandex.ru/stat/v1/data?preset=sources_search_phrases&dimensions=ym:s:date,ym:s:deviceCategory,ym:s:firstVisitStartOfHour,ym:s:flashEnabled,ym:s:clientID,ym:s:lastSearchEngine,ym:s:lastSearchEngineRoot&id=' . $widget_email->counter . '&oauth_token=' . $widget_email->token . '&offset=' . $ofset . '&limit=300&date1=' . $last_upload;

            $otvet = file_get_contents($zapros);
            $otvet_encode = json_decode($otvet);
            $datas = $otvet_encode->data;
            $insert = array();
            for ($i = 0; $i < count($datas); $i++) {

                if (isset($datas[$i]->dimensions[5]->id)) {
                    DB::table('metrika_keywords_import')->where('datetimevisit', $datas[$i]->dimensions[2]->name)->where('SearchEngine_id', $datas[$i]->dimensions[5]->id)->where('datavisit', $datas[$i]->dimensions[0]->name)->update(['ids' => $datas[$i]->dimensions[4]->name

                    ]);
                } else {
                    dd($datas[$i]->dimensions[5]);
                    Log::info($i);
                    Log::info($datas[$i]->dimensions);
                }

            }

        }


    }

    public function widget_metrika_get_forbot($widget)
    {
        $search = ['yandex', 'google'];

        $end_date = date('Y-m-d', time());
        $start_date = date('Y-m-d', (time() - 15552000));

        for ($r = 0; $r < count($search); $r++) {
            $zapros = 'https://api-metrika.yandex.ru/stat/v1/data?dimensions=ym:s:startURL&metrics=ym:s:visits&filters=ym:s:SearchEngineRoot==\'' . $search[$r] . '\'&id=43609859&oauth_token=' . $widget->metrika_token . '&date1=' . $start_date . '&date2=' . $end_date . '&limit=300';


            $otvet = file_get_contents($zapros);
            $otvet_encode = json_decode($otvet);
            $datas = $otvet_encode->data;
            $insert = array();


            for ($i = 0; $i < count($datas); $i++) {


                $insert[$i]['url'] = explode('?', $datas[$i]->dimensions[0]->name)[0];
                $insert[$i]['poisk'] = $search[$r];
                $insert[$i]['widget_id'] = $widget->id;


            }
            DB::table('widgets_catcher_bots_comsearch')->insert($insert);
            $total_rows = $otvet_encode->total_rows;
            $amount = floor($total_rows / 300);

            for ($is = 1; $is <= $amount; $is++) {
                $ofset = $is * 300 + 1;
                $zapros = 'https://api-metrika.yandex.ru/stat/v1/data?dimensions=ym:s:startURL&metrics=ym:s:visits&filters=ym:s:SearchEngineRoot==\'' . $search[$r] . '\'&id=43609859&oauth_token=' . $widget->metrika_token . '&date1=' . $start_date . '&date2=' . $end_date . '&limit=300&offset=' . $ofset;


                $otvet = file_get_contents($zapros);
                $otvet_encode = json_decode($otvet);
                $datas = $otvet_encode->data;
                $insert = array();
                for ($i = 0; $i < count($datas); $i++) {


                    $insert[$i]['url'] = explode('?', $datas[$i]->dimensions[0]->name)[0];
                    $insert[$i]['poisk'] = $search[$r];
                    $insert[$i]['widget_id'] = $widget->id;


                }


                DB::table('widgets_catcher_bots_comsearch')->insert($insert);

            }


        }


    }
}
