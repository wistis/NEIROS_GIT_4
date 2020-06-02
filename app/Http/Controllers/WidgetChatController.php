<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use Log;
use ElephantIO\Client as Clcl;
use ElephantIO\Engine\SocketIO\Version2X;
use App\Http\Controllers\Api\WidgetApiController;
use  Activity;

class WidgetChatController extends Controller
{
    public function catch_lead($input_data)
    {
        $site = DB::table('sites')->where('hash', $input_data['widget'])->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 19)->first();
        if (!$widget) {
            return 'error02';

        };
        $widget_chat = DB::table('widget_catch_lead')->where('widget_id', $widget->id)->first();

        $data['widget_chat'] = $widget_chat;
        $data['neiros_visit'] = $input_data['hash'];
        $data['site'] = $input_data['widget'];

        $data['params']['devise'] = 'desctop';
        $data['mobile_animation'] = '';
        $data['desc_animation'] = 'neiros__slideLeft';
        $data['mobile'] = '';
        $data['neiros_url_vst'] =$input_data['request']['neiros_url_vst'];


        /*  if($_GET['type']){
              if($_GET['type'] == 'social' || $_GET['type'] == 'lidi' || $_GET['type'] == 'phone'){
                  $data['mobile'] = 'mobile';
                  $data['mobile_animation'] = 'neiros__slideUp';
                  $data['desc_animation']  = ' ';
              }

          }*/


        $data['neiros_visit'] = $input_data['hash'];
        $data['site'] = $input_data['widget'];

        $time_work = DB::table('widget_callback_worktime')->where('sites_id', $site->id)
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

        $datavivod1['day'] = '';


        $timestart1 = 0;
        try {
            $datavivod1 = $this->get_first_day($datarr, $weekday);
            if ($datavivod1['day'] !== date('N')) {
                $data['off'] = 1;
            } else {
                $data['off'] = 0;
                if((int)date('H')>(int)$datavivod1['hour_end']){$data['off']=1;}
                ;if((int)date('H')<(int)$datavivod1['hour']){$data['off']=1;}
            }

            $datavivod2 = $this->get_tvo_day($datarr, $weekday, $datavivod1);
            $datavivod3 = $this->get_3_day($datarr, $weekday, $datavivod1, $datavivod2);
            $datavivod1['range'] = range($datavivod1['hour'], $datavivod1['hour_end']);
            $datavivod1['html'] = '<option></option>';
            for ($i = 0; $i < count($datavivod1['range']); $i++) {
                $datavivod1['html'] .= "<option value=\"" . $datavivod1['range'][$i] . "\">" . $datavivod1['range'][$i] . ":00</option>";
            }


            $datavivod2['range'] = range($datavivod2['hour'], $datavivod2['hour_end']);
            $datavivod2['html'] = '<option></option>';
            for ($i = 0; $i < count($datavivod2['range']); $i++) {
                $datavivod2['html'] .= '<option value="' . $datavivod2['range'][$i] . '">' . $datavivod2['range'][$i] . ':00</option>';
            }
            $datavivod3['range'] = range($datavivod3['hour'], $datavivod3['hour_end']);
            $datavivod3['html'] = '<option></option>';
            for ($i = 0; $i < count($datavivod3['range']); $i++) {
                $datavivod3['html'] .= '<option value="' . $datavivod3['range'][$i] . '">' . $datavivod3['range'][$i] . ':00</option>';
            }

            $data['dayt'][] = $datavivod1;
            $data['dayt'][] = $datavivod2;
            $data['dayt'][] = $datavivod3;
        } catch (\Exception $e) {
            $data['dayt'] = [];
            $data['off'] = 0;
        }
        $data['ab']['id'] = 0;
        $data['ab']['position_1_text'] = 'Вы нашли, что искали?';
        $data['ab']['position_1_yes_text'] = 'Да';
        $data['ab']['position_1_not_text'] = 'Нет';
        $data['ab']['position_1_yes_bcolor'] = '#00B9EE';
        $data['ab']['position_1_yes_tcolor'] = '#fff';
        $data['ab']['position_1_not_bcolor'] = '#00B9EE';
        $data['ab']['position_1_not_rcolor'] = '#fff';
        $data['ab']['first_step_status'] = 1;
        $data['ab_view'] = 0;
        $prov_ab = DB::table('widget_catch_lead_ab_view')->where('site_id', $site->id)->where('neiros_visit', $input_data['hash'])->first();
        if ($prov_ab) {

            $ab = DB::table('widget_catch_lead_ab')->where('id', $prov_ab->ab_id)->where('status', 1)->first();

            if (!$ab) {

                $ab = DB::table('widget_catch_lead_ab')->where('widget_catch_lead_id', $widget_chat->id)->where('status', 1)->where('is_null', 0)->orderby('shows', 'ASC')->first();
                if (!$ab) {
                    $ab = DB::table('widget_catch_lead_ab')->where('widget_catch_lead_id', $widget_chat->id) ->where('is_null', 1)->orderby('shows', 'ASC')->first();
                }

            }
        } else {


            $ab = DB::table('widget_catch_lead_ab')->where('widget_catch_lead_id', $widget_chat->id)->where('status', 1)->orderby('shows', 'ASC')->first();
            if ($ab) {
                $data['ab_view'] = DB::table('widget_catch_lead_ab_view')->insertGetId([
                    'site_id' => $site->id,
                    'my_company_id' => $site->my_company_id,
                    'ab_id' => $ab->id,
                    'neiros_visit' => $input_data['hash'],
                    'created_at' => date('Y-m-d'),
                    'created_at' => date('Y-m-d'),

                ]);
            } else {
                $ab = DB::table('widget_catch_lead_ab')->where('widget_catch_lead_id', $widget_chat->id) ->where('is_null', 1)->orderby('shows', 'ASC')->first();

               if($ab){
                $data['ab_view'] = DB::table('widget_catch_lead_ab_view')->insertGetId([
                    'site_id' => $site->id,
                    'my_company_id' => $site->my_company_id,
                    'ab_id' => $ab->id,
                    'neiros_visit' => $input_data['hash'],
                    'created_at' => date('Y-m-d'),
                    'created_at' => date('Y-m-d'),

                ]);

               }
            }
        }

        if ($ab) {
            DB::table('widget_catch_lead_ab')->where('id', $ab->id)->update([
                'shows' => ($ab->shows + 1)
            ]);
            $data['ab']['id'] = $ab->id;;
            $data['ab']['id_view'] = $ab->id;;
            $data['ab']['position_1_text'] = $ab->position_1_text;
            $data['ab']['position_1_yes_text'] = $ab->position_1_yes_text;
            $data['ab']['position_1_not_text'] = $ab->position_1_not_text;
            $data['ab']['position_1_yes_bcolor'] = $ab->position_1_yes_bcolor;
            $data['ab']['position_1_yes_tcolor'] = $ab->position_1_yes_tcolor;
            $data['ab']['position_1_not_bcolor'] = $ab->position_1_not_bcolor;
            $data['ab']['position_1_not_rcolor'] = $ab->position_1_not_rcolor;
            $data['ab']['first_step_status'] = $ab->first_step_status;;


        }

        /*INSERT INTO `widget_catch_lead_ab_view`(`id`, `site_id`, `my_company_id`, `ab_id`, `hash`, `created_at`, `updated_at`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])*/


        /*(`id`, `widget_id`, `widget_catch_lead_id`, `my_company_id`, `position_1_text`, `position_1_yes_text`, `position_1_not_text`, `position_1_yes_bcolor`, `position_1_not_bcolor`, `position_1_yes_tcolor`, `position_1_not_rcolor`, `shows`, `leads`, `status`, `updated_at`, `created_at`, `first_step_status`) */


        return view('chat.catch_lead', $data);
    }

    public function xcallback($devise, $hash, $widgetrr, Request $request)
    {
        $site = DB::table('sites')->where('hash', $request->widget)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 1)->first();
        if (!$widget) {
            return 'error02';

        };
        $widget_chat = DB::table('widget_callback')->where('widget_id', $widget->id)->first();

        /*+"id": "7"
  +"widget_id": "56"
  +"my_company_id": "1"
  +"user_id": "1"
  +"updated_at": null
  +"created_at": null
  +"callback_tip": "0"
  +"callback_phone0": "79530986997"
  +"callback_phone1": "qe"
  +"callback_phone2": "51756"
  +"callback_phonepassword": null
  +"callback_timer": "12"
  +"active_form": "0"
  +"dop_form": "0"
  +"dop_form_email": "ceo@wistis.ru"
  +"active_osn": "1"
  +"form_callback": "0"*/
        $data['widget_chat'] = $widget_chat;
        $data['user_hash'] = $request->hash;
        $data['site'] = $request->widget;

        $data['params']['devise'] = 'desctop';
        $data['mobile_animation'] = '';
        $data['desc_animation'] = 'neiros__slideLeft';
        $data['mobile'] = '';


        if ($_GET['type']) {
            if ($_GET['type'] == 'social' || $_GET['type'] == 'lidi' || $_GET['type'] == 'phone') {
                $data['mobile'] = 'mobile';
                $data['mobile_animation'] = 'neiros__slideUp';
                $data['desc_animation'] = ' ';
            }

        }


        $data['user_hash'] = $hash;
        $data['site'] = $widgetrr;

        $time_work = DB::table('widget_callback_worktime')->where('sites_id', $site->id)
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

        $datavivod1['day'] = '';

$tmetesst=time();
        $timestart1 = 0;  $datavivod1 = $this->get_first_day($datarr, $weekday);
        try {
          ;
            if ($datavivod1['day'] !== date('N',$tmetesst)) {
                $data['off'] = 1;
            } else {

                $data['off'] = 0;
                ;if((int)date('H',$tmetesst)>(int)$datavivod1['hour_end']){$data['off']=1;}
                ;if((int)date('H',$tmetesst)<(int)$datavivod1['hour']){$data['off']=1;}



            }

            $datavivod2 = $this->get_tvo_day($datarr, $weekday, $datavivod1);
            $datavivod3 = $this->get_3_day($datarr, $weekday, $datavivod1, $datavivod2);
            $datavivod1['range'] = range($datavivod1['hour'], $datavivod1['hour_end']);
            $datavivod1['html'] = '<option></option>';
            for ($i = 0; $i < count($datavivod1['range']); $i++) {
                $datavivod1['html'] .= "<option value=\"" . $datavivod1['range'][$i] . "\">" . $datavivod1['range'][$i] . ":00</option>";
            }


            $datavivod2['range'] = range($datavivod2['hour'], $datavivod2['hour_end']);
            $datavivod2['html'] = '<option></option>';
            for ($i = 0; $i < count($datavivod2['range']); $i++) {
                $datavivod2['html'] .= '<option value="' . $datavivod2['range'][$i] . '">' . $datavivod2['range'][$i] . ':00</option>';
            }
            $datavivod3['range'] = range($datavivod3['hour'], $datavivod3['hour_end']);
            $datavivod3['html'] = '<option></option>';
            for ($i = 0; $i < count($datavivod3['range']); $i++) {
                $datavivod3['html'] .= '<option value="' . $datavivod3['range'][$i] . '">' . $datavivod3['range'][$i] . ':00</option>';
            }

            $data['dayt'][] = $datavivod1;
            $data['dayt'][] = $datavivod2;
            $data['dayt'][] = $datavivod3;
        } catch (\Exception $e) {
            $data['dayt'] = [];
            $data['off'] = 0;

        }

        return view('chat.callback', $data);
    }

    public function get_3_day($datarr, $weekday, $datavivod1, $datavivod2)
    {
        $tek_w = date('N', time() + 86400 + 86400);

        if (isset($datarr[$tek_w])) {
            if (($datavivod1['day'] != $tek_w) && ($datavivod2['day'] != $tek_w)) {

                $datavivod3['day'] = $tek_w;
                $datavivod3['name'] = $weekday[$tek_w];

                $timestart1 = $datarr[$tek_w]->hour;

                $datavivod3['hour'] = $timestart1;
                $datavivod3['hour_end'] = $datarr[$tek_w]->hour_end;

            } else {
                $datavivod3 = $this->next_day_3($datarr, $weekday, $datavivod1, $datavivod2);
            }


        } else {

            $datavivod3 = $this->next_day_3($datarr, $weekday, $datavivod1, $datavivod2);


        }
        return $datavivod3;

    }

    public function get_tvo_day($datarr, $weekday, $datavivod1)
    {
        $tek_w = date('N', time() + 86400);

        if (isset($datarr[$tek_w])) {

            if ($datavivod1['day'] != $tek_w) {
                $datavivod2['day'] = $tek_w;
                $datavivod2['name'] = 'Завтра';

                $timestart1 = $datarr[$tek_w]->hour;

                $datavivod2['hour'] = $timestart1;
                $datavivod2['hour_end'] = $datarr[$tek_w]->hour_end;


            } else {
                $datavivod2 = $this->next_day_2($datarr, $weekday, $datavivod1);
            }


        } else {

            $datavivod2 = $this->next_day_2($datarr, $weekday, $datavivod1);


        }
        return $datavivod2;

    }

    public function get_first_day($datarr, $weekday)
    {
        $tek_w = date('N');
        $tek_h = date('H');
        if (isset($datarr[$tek_w])) {
            if ($datarr[$tek_w]->hour_end > $tek_h) {

                $datavivod1['day'] = $tek_w;
                $datavivod1['name'] = 'Сегодня';
                if ($tek_h <= $datarr[$tek_w]->hour) {
                    $timestart1 = $datarr[$tek_w]->hour;
                } else {
                    $timestart1 = $tek_h;
                }
                $datavivod1['hour'] = $timestart1;
                $datavivod1['hour_end'] = $datarr[$tek_w]->hour_end;

            } else {
                $datavivod1 = $this->next_day($datarr, $tek_h, $weekday);
            }


        } else {

            $datavivod1 = $this->next_day($datarr, $tek_h, $weekday);


        }
        return $datavivod1;

    }

    public function next_day_3($datarr, $weekday, $datavivod1, $datavivod2)
    {
        for ($i = 1; $i < 7; $i++) {
            $tek_w = date('N', (time() + (86400 * $i) + 86400));

            if (isset($datarr[$tek_w])) {


                if (($datavivod1['day'] != $tek_w) && ($datavivod2['day'] != $tek_w)) {
                    $datavivod2['day'] = $tek_w;


                    $datavivod2['name'] = $weekday[$tek_w];


                    $timestart1 = $datarr[$tek_w]->hour;
                    $datavivod2['hour'] = $timestart1;
                    $datavivod2['hour_end'] = $datarr[$tek_w]->hour_end;
                    break;
                }
            }


        }

        return $datavivod2;

    }

    public function next_day_2($datarr, $weekday, $datavivod1)
    {
        for ($i = 1; $i < 7; $i++) {
            $tek_w = date('N', (time() + (86400 * $i) + 86400));

            if (isset($datarr[$tek_w])) {


                if ($datavivod1['day'] != $tek_w) {
                    $datavivod2['day'] = $tek_w;


                    if ($tek_w == date('N', (time() + 86400))) {
                        $datavivod2['name'] = 'Завтра1';


                    } else {

                        $datavivod2['name'] = $weekday[$tek_w];


                    }
                    $timestart1 = $datarr[$tek_w]->hour;
                    $datavivod2['hour'] = $timestart1;
                    $datavivod2['hour_end'] = $datarr[$tek_w]->hour_end;
                    break;
                }
            }


        }

        return $datavivod2;

    }

    public function next_day($datarr, $tek_h, $weekday)
    {
        for ($i = 1; $i < 7; $i++) {
            $tek_w = date('N', (time() + (86400 * $i)));;
            if (isset($datarr[$tek_w])) {

                if ($datarr[$tek_w]->day == date('N')) {

                    if ($datarr[$tek_w]->hour_end > $tek_h) {

                        $datavivod1['day'] = $tek_w;
                        if ($i == 1) {
                            $datavivod1['name'] = 'Завтра';


                        } else {

                            $datavivod1['name'] = $weekday[$tek_w];


                        }
                        $timestart1 = $datarr[$tek_w]->hour;
                        $datavivod1['hour'] = $timestart1;
                        $datavivod1['hour_end'] = $datarr[$tek_w]->hour_end;
                        return $datavivod1;
                        break;
                    }
                } else {
                    $datavivod1['day'] = $tek_w;
                    if ($i == 1) {
                        $datavivod1['name'] = 'Завтра';


                    } else {

                        $datavivod1['name'] = $weekday[$tek_w];


                    }
                    $timestart1 = $datarr[$tek_w]->hour;
                    $datavivod1['hour'] = $datarr[$tek_w]->hour;
                    $datavivod1['hour_end'] = $datarr[$tek_w]->hour_end;
                    return $datavivod1;
                    break;
                }
            }


        }

        return $datavivod1;

    }


    public function index($devise, $hash, $widgetrr, Request $request)
    {
        /*Нужны ид менеджеров чтобы проверить их активность
        https://github.com/thomastkim/laravel-online-users
        */
        // $activities = Activity::users()->wherein('id',[])->get();


// Find latest users

        $site = DB::table('sites')->where('hash', $request->widget)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 12)->first();
        if (!$widget) {
            return 'error02';

        }

        $widget_chat = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();

        if (!$widget_chat) {
            return 'error03';
        }
        $data['widget_chat'] = $widget_chat;
        $data['neiros_visit'] = $request->neiros_visit;
        $data['site'] = $request->widget;
        $data['neirosphone'] = $request->neirosphone;


        $chat_user = DB::table('widget_chat_users')->where('vk_user_id', $request->neiros_visit)->where('my_company_id', $site->my_company_id)->first();


        if ($chat_user) {
            $data['is_old_client'] = 1;
            $data['messages'] = DB::table('chat_with_client')->where('input_user_id', $request->neiros_visit)->where('my_company_id', $site->my_company_id)->get();
            $startdate = DB::table('chat_with_client')->where('input_user_id', $request->neiros_visit)->orderby('created_at', 'asc')->where('my_company_id', $site->my_company_id)->first();
            if ($startdate) {
                $data['messages_first'] = date('d.m.Y', strtotime($startdate->created_at));
            } else {
                $data['messages_first'] = date('d.m.Y');
            }
            $data['messages_arr_d'] = [];
        } else {
            $data['is_old_client'] = 0;
            $data['messages'] = array();
            $data['messages_first'] = date('Y-m-d');
            $data['messages_arr_d'] = [];
        }


        $data['set_oper'] = 0;

        if ($request->server('HTTP_REFERER')) {


            $set_oper = DB::table('widgets_chat_url_operator')->where('widget_id', $widget_chat->id)->where('url', $request->server('HTTP_REFERER'))->first();

            if ($set_oper) {
                $data['tip_timer_12'] = $set_oper->timer;
                $data['tip_mess_12'] = $set_oper->first_message;
                $data['tip_name_12'] = $set_oper->operator_name;
                $data['tip_who_12'] = $set_oper->job;;
                $data['tip_logo_12'] = $set_oper->logo;;
                $data['set_oper'] = 1;
            } else {

                $set_opers = DB::table('widgets_chat_url_operator')->where('widget_id', $widget_chat->id)->where('url', "LIKE", "%*%")->get();

                foreach ($set_opers as $set_oper) {
                    $mystring = 'abc';
                    $findme = 'a';
                    $pos = strpos($request->server('HTTP_REFERER'), trim($set_oper->url, "*"));

// Заметьте, что используется ===.  Использование == не даст верного
// результата, так как 'a' находится в нулевой позиции.
                    if ($pos === false) {

                    } else {
                        $data['tip_timer_12'] = $set_oper->timer;
                        $data['tip_mess_12'] = $set_oper->first_message;
                        $data['tip_name_12'] = $set_oper->operator_name;
                        $data['tip_who_12'] = $set_oper->job;;
                        $data['set_oper'] = 1;
                        $data['tip_logo_12'] = $set_oper->logo;;
                    }


                }


            }


        }


        $data['params']['devise'] = 'desctop';
        $data['mobile_animation'] = '';
        $data['mobile'] = '';


        if ($_GET['type']) {
            if ($_GET['type'] == 'social' || $_GET['type'] == 'lidi' || $_GET['type'] == 'phone') {
                $data['mobile'] = 'mobile';
                $data['mobile_animation'] = 'neiros__slideUp';
            }

        }


        $data['neiros_visit'] = $hash;
        $data['site'] = $widgetrr;


        if ($data['widget_chat']->callback_timer == '') {
            $data['widget_chat']->callback_timer = 30;
        }
 if($request->has('test')){

     $data['new_setting']=file_get_contents('https://cloud.neiros.ru/get_setting?subtip=26&json=1');
  

     return view('widgets.chat_new', $data);
 }
        return view('widgets.chat', $data);
    }

    public function send_chat(Request $request)
    {
        $is_first=0;
$user_id=0;
        $input_data = json_decode($request->my_data);

        info($input_data->message);
        info('chaaaaaaaaaaaa+++');
        if(($input_data->message=='wistis_write_of')||($input_data->message=='wistis_write')) {
            $res['mess_id']=0;
            $res['tema_id']=0;
            info('chaaaaaaaaaaaa+++1');
            return json_encode($res);
        }



        $site = DB::table('sites')->where('hash', $input_data->site)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }

        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 12)->first();
        if (!$widget) {
            return 'error02';

        }

        $widget_chat = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();

        if (!$widget_chat) {
            return 'error03';
        }

        $widget_chat_input = DB::table('widget_chat_input')->insertGetId([
            'user_id' => $site->user_id,
            'my_company_id' => $site->my_company_id,
            'widget_id' => $widget->id,
            'widget_chat_id' => $widget_chat->id,
            'date' => time(),
            'vk_user_id' => $input_data->hash,
            'body' => $input_data->hash,

            'body' => $input_data->message,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $prov_widget_chat_users = DB::table('widget_chat_users')->where('vk_user_id', $input_data->hash)->where('my_company_id', $site->my_company_id)->first();
        if (!$prov_widget_chat_users) {
$is_first=1;

            DB::table('widget_chat_users')->insert([
                'user_id' => $site->user_id,
                'my_company_id' => $site->my_company_id,
                'widget_id' => $widget->id,
                'vk_user_id' => $input_data->hash,
                'first_name' => $widget->name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'tema_id' => 0

            ]);
            $idtmus = DB::table('chat_tema')->where('my_company_id', $site->my_company_id)->count();
            $hid_id = $idtmus + 1;
            $tema_id = DB::table('chat_tema')->insertgetid([
                'name' => 'Клиент',
                'image' => '',
                'tip' => 12,
                'my_company_id' => $site->my_company_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 1,
                'sites_id' => $site->id,
                'hash' => $input_data->hash,
                'neiros_visit' => $input_data->hash,
                'hid_id' => $hid_id,
            ]);




            DB::table('widget_chat_users')->where('my_company_id', $site->my_company_id)->where('vk_user_id', $input_data->hash)->update(['tema_id' => $tema_id]);

info('wistis3105');
info($widget_chat->create_project);
            if ($widget_chat->create_project == 1) {
                $WidgetApiController = new WidgetApiController();

                $pnone_email = [];

                $project_id = $WidgetApiController->create_project('neiros_visit', $input_data->hash, $widget, $pnone_email);
                DB::table('widget_chat_users')->where('vk_user_id', $input_data->hash)->update([
                    'project_ids' => $project_id
                ]);
            }


        } else {


            $tema_id = $prov_widget_chat_users->tema_id;

            $tema_idw = DB::table('chat_tema')->where('id', $tema_id)->where('my_company_id', $site->my_company_id)->first();
            if (!$tema_idw) {


                $idtmus = DB::table('chat_tema')->where('my_company_id', $site->my_company_id)->count();
                $hid_id = $idtmus + 1;
                $tema_id = DB::table('chat_tema')->insertgetid([


                    'name' => 'Клиент',
                    'image' => '',
                    'tip' => 12,
                    'my_company_id' => $site->my_company_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1,
                    'sites_id' => $site->id,
                    'hash' => $input_data->hash,
                    'hid_id' => $hid_id
                ]);

            } else {

                $tema_id = $tema_idw->id;
            }


            DB::table('chat_tema')->where('id', $tema_id)->update([
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        }

if($is_first==1) {
/**/
    if($widget_chat->first_message==''){

        $priv_text='Здравствуйте! Чем могу Вам помочь?';
    }else{
        $priv_text=$widget_chat->first_message;
    }
    $outuseradmin=User::where('my_company_id',$site->my_company_id)->first();
    $idnewmes = DB::table('chat_with_client')->insertgetid([
        'widget_id' => $widget->id,
        'my_company_id' => $site->my_company_id,
        'tip' => 12,
        'input_user_id' => $input_data->hash,
        'mess' => $priv_text,
        'from' => 1,
        'created_at' => date('Y-m-d H:i:s', (time() - 10)),
        'updated_at' => date('Y-m-d H:i:s', (time() - 10)),
        'out_user_id' => $outuseradmin->id,
        'read_input_user_status' => 0,
        'read_out_user_status' => 0,
        'input_mess_id' => 0,
        'tema_id' => $tema_id,

    ]);

}
        /*tema	598
        message	qqqq*/


        $mess_id = DB::table('chat_with_client')->insertGetId([
            'widget_id' => $widget->id,
            'my_company_id' => $site->my_company_id,
            'tip' => 4,
            'input_user_id' => $input_data->hash,
            'mess' => $input_data->message,
            'from' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'out_user_id' => 0,
            'read_input_user_status' => 0,
            'read_out_user_status' => 0,
            'input_mess_id' => $widget_chat_input,
            'tema_id' => $tema_id,

        ]);


        $users = DB::table('users')->where('my_company_id', $site->my_company_id)->where('users_push',1)->pluck('id');

        DB::table('chat_tema')->where('id', $tema_id)->update([

            'updated_at' => date('Y-m-d H:i:s', time())

        ]);


        $tokens = DB::table('users_push')->wherein('user_id', $users)->distinct('token')->pluck('token')->toArray();
        Log::info($tokens);

     if(count($tokens)>0) {
         $this->send_push($tokens, $input_data->message, $widget->name . ' #' . $tema_id);
     }
        $res['mess_id']=$mess_id;
        $res['tema_id']=$tema_id;

        return json_encode($res);
    }

    public function send_push($token, $mess, $client)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

Log::info($token);
        $headers = array(
            "Authorization: key=AAAAMZuFUxk:APA91bHYJz68lRfdGs5NIF8y1ssj03iQL95UFQP4iFyTsuJi9KMvlLjk_RtFaS-_tqA2y3sYQixWXELLQfwaUPUSZYM7ZsXDrxGrgIQqs9v-zVfjvIs-kd_iEcTKLZakJO0M-GvJITj0",
            "Content-Type: application/json"
        );

        $send_Data = array(
            "registration_ids" => $token,
            "notification" => array(
                "body" => date('H:i:s') . ': ' . $mess,
                "title" => "$client",
                "icon" => "https://cloud.neiros.ru/Neiros.png",
                "click_action" => 'https://chat.neiros.ru/'
            )

        );


        $ch = curl_init(); //curl 사용전 초기화 필수
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);                  //0이 default 값이며 POST 통신을 위해 1로 설정
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //header 지정하기
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        //이 옵션이 0으로 지정되면 curl_exec의 결과값을 브라우저에 바로 보여준다.
        //이 값을 1로 하면 결과값을 return하게 되어 변수에 저장 가능
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);          //호스트에 대한 인증서 이름 확인
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);      //인증서 확인
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($send_Data));   //POST로 보낼 데이터 지정하기
        //curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0);         //이 값을 0으로 해야 알아서 &post_data 크기를 측정하는듯

        $res = curl_exec($ch);
        Log::info($res);
        Log::info($res);
        //에러 발생시 실행
        if ($res === FALSE) {
            Log::info($ch);
        }

        curl_close($ch);


    }

    public function sentSocketio()
    {


        $fp = stream_socket_client("tcp://cloud.neiros.ru:8890", $errno, $errstr, 30);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            fwrite($fp, "GET / HTTP/1.0\r\nHost: www.example.com\r\nAccept: */*\r\n\r\n");
            while (!feof($fp)) {
                echo fgets($fp, 1024);
            }
            fclose($fp);
        }


    }
}
