<?php

namespace App\Http\Controllers;

use App\Widgets_phone;
use App\Widgets_phone_routing;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;
use App\Widgets;

class AsteriskController extends Controller
{

    public $numbers_to_rout = [];
    public $inputdata;
    public $widget;
    public $errors = [];

    public function asterisk_ajax($tip, Request $request)
    {
        $this->inputdata = $request;
        switch ($tip) {
            case 0:
                return $this->get_1($request);
                break;

            case 1:
                return $this->get_1($request);
                break;
        }


    }


    /*удаляем номера где нет роута*/
    public function delete_zero_rout()
    {


        $phones = DB::table('widgets_phone')->where('routing', 0)->get();
        foreach ($phones as $item) {

            DB::connection('asterisk')->table('routing')->where('did', $item->input)->delete();


        }

    }

    public function delete_numbers_withhout_rout($phone)
    {

        DB::connection('asterisk')->table('routing')->where('did', $phone->input)->delete();
        DB::table('widgets_phone')->where('id', $phone->id)->update([
            'routing' => 0,
        ]);
    }

    public function resafe_routing()
    {

        $this->delete_zero_rout();

        $phones = DB::table('widgets_phone')->get();
        $number_to = '';
        $Api = new ApiController();

        foreach ($phones as $phone) {

            $routing = DB::table('widgets_phone_routing')->where('id', $phone->routing)->first();
            if ($routing) {

                print 1;
                if ($routing->tip_redirect == 0) {
                    $number_to = 'SIP/runexis/' . $Api->format_phone($routing->number_to);
                }
                if ($routing->tip_redirect == 1) {
                    $number_to = 'SIP/' . $routing->number_to;
                }


                $prot = DB::connection('asterisk')->table('routing')->where('did', $phone->input)->first();
                if (!$prot) {
                    DB::connection('asterisk')->table('routing')->insert([
                        'did' => $phone->input,
                        'dialstring' => $number_to,
                        'block' => 'no',
                        'priority' => '1',
                        'my_router' => $routing->id

                    ]);


                } else {

                    DB::connection('asterisk')->table('routing')->where('did', $phone->input)->update([

                        'dialstring' => $number_to,


                    ]);
                }


            } else {

                print 0;
                $this->delete_numbers_withhout_rout($phone);

            }


        }

    }

    public function by_numbers()
    {


        $data = $this->addphone_in($this->inputdata);
        if ($data['status'] > 0) {


            return $data['phones'];
        } else {
            return [];
        }
    }


    /*Массив номеров*/
    public function create_array_numbers_to_routing()
    {

        $this->errors['error'] = 1;
        $this->errors['message'] = 'Не выбран тип подключения номеров!!';


        if ($this->inputdata->{'setings-add-nomer'} == 'tab-add-nomers') {
            if ($this->inputdata->region > 0) {
                $this->errors['error'] = 0;
                $this->numbers_to_rout = $this->by_numbers();
            } else {
                $this->errors['error'] = 1;
                $this->errors['message'] = 'Выберите регион';
                return '';
            }
        }

        if ($this->inputdata->{'setings-add-nomer'} == 'tab-add-nomer') {
            if (is_array($this->inputdata->ar_number)) {
                $this->errors['error'] = 0;
                for ($i = 0; $i < count($this->inputdata->ar_number); $i++) {
                    $this->numbers_to_rout[] = $this->inputdata->ar_number[$i];
                    $this->errors['error'] = 0;
                }


            } else {
                $this->errors['error'] = 1;
                $this->errors['message'] = 'Не выбраны номера';
                return '';
            }
        }

        if ($this->inputdata->{'setings-add-nomer'} == 'tab-my-nomer') {
            if ($this->inputdata->my_number != '') {

                $this->numbers_to_rout[] = $this->inputdata->my_number;
            }
        }

    }


    public function get_1($request)
    {


        $this->create_array_numbers_to_routing();


        if ($this->errors['error'] == 1) {
            return $this->errors;
        }
        $user = Auth::user();
        $widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 2)->first();


        $user = Auth::user();

        if ($request->is_default == 1) {
            DB::table('widgets_phone_routing')->where('widget_id', $widget->id)->where('my_company_id', $user->my_company_id)->update(['is_default' => 0

            ]);

        }

        if ($request->ar_id > 0) {

            $rout = Widgets_phone_routing::where('my_company_id', $user->my_company_id)->where('id', $request->ar_id)->first();
            $id_old = 1;
            if (!$rout) {

                $this->errors['error'] = 1;
                $this->errors['message'] = 'Ошибка.404';
                return $this->errors;
            }
        } else {
            $id_old = 0;
            $rout = new Widgets_phone_routing();
        }


        $rout->widget_id = $widget->id;
        $rout->{'setings-add-nomer'} = $this->inputdata->{'setings-add-nomer'};
        if( $this->inputdata->{'setings-add-nomer'} =='tab-add-nomers'){
            $rout->{'setings-add-nomer'}='tab-add-nomer';
        }
        $rout->my_company_id = $user->my_company_id;

        if ($request->name == '') {

            $this->errors['error'] = 1;
            $this->errors['message'] = 'Имя сценария не может быть пустым';
            return $this->errors;
        }

        $rout->name = $request->name;
        $rout->tip_redirect = $request->ar_reditrect;

        $rout->number_to = $request->ar_phone_redirect;
        if ($request->ar_phone_redirect == '') {

            $this->errors['error'] = 1;
            $this->errors['message'] = 'Номер для редиректа не может быть пустым';
            return $this->errors;
        }
        if ($request->ar_reditrect == '') {

            $this->errors['error'] = 1;
            $this->errors['message'] = 'Выберите тип переадресации';
            return $this->errors;
        }

        $rout->tip_calltrack = $request->ar_tip_calltrack;
        $rout->created_at = date('Y-m-d');
        $rout->status = 1;
        $rout->is_default = $request->is_default;




$all_class_replace=[];
        if(is_array($request->ar_class_replace_type)){

for($k=0;$k<count($request->ar_class_replace_type);$k++){

    $all_class_replace[$k]['ar_class_replace_type']=$request->ar_class_replace_type[$k];
    if(isset($request->ar_class_replace[$k])){
        $all_class_replace[$k]['ar_class_replace']=$request->ar_class_replace[$k];
    }else{
        $all_class_replace[$k]['ar_class_replace']='';
    }

}
        }


        $rout->all_class_replace = json_encode($all_class_replace);


        $rout->canals = $request->ar_canals_dinamic;


        $rout->save();

        $routing = $rout->id;


        $numbers_to_delete = $this->numbers_to_delete_from_routing($widget, $routing);
        $number_to = $this->numbers_in_routing($widget, $routing);
        info($number_to);
        $this->add_number_in_rout($widget, $routing, $number_to);
        /**/



        /*обработка номеров в роутингге*/
        $this->for_dinamic($widget, $routing);

        $this->errors['error'] = 0;
        $this->errors['message'] = 'Успешно';
        return $this->errors;
    }


    function numbers_to_delete_from_routing($widget, $routing)
    {
        $prov_rezerv = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('routing', $routing)->get();
        $numbers_to_del = [];
        foreach ($prov_rezerv as $item) {
            if (!in_array($item->input, $this->numbers_to_rout)) {

                $numbers_to_del[] = $item->input;
                DB::table('widgets_phone')->where('id', $item->id)->update([
                    'rezerv' => 0, 'routing' => 0

                ]);
                $this->deletete_number($item->input);
            }

        }


    }

    function for_dinamic($widget, $routing)
    {
        if ($this->inputdata->ar_tip_calltrack == 1) {

            $prov_rezerv = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('tip', 1)->where('rezerv', 1)->where('routing', $routing)->get();
            if (count($prov_rezerv) == 0) {
                $prov_rezerv_1 = Widgets_phone::where('widget_id', $widget->id)->where('tip', 1)->where('routing', $routing)->first();
                if ($prov_rezerv_1) {

                    $prov_rezerv_1->rezerv = 1;
                    $prov_rezerv_1->save();

                }

                return '0';
            }
            if (count($prov_rezerv) == 1) {

                return '0';

            }
            if (count($prov_rezerv) > 1) {
                DB::table('widgets_phone')->where('widget_id', $widget->id)->where('tip', 1)->where('routing', $routing)->where('rezerv', 1)->update([
                    'rezerv' => 0
                ]);
                $prov_rezerv_1 = Widgets_phone::where('widget_id', $widget->id)->where('tip', 1)->where('routing', $routing)->first();
                if ($prov_rezerv_1) {


                    $prov_rezerv_1->rezerv = 1;
                    $prov_rezerv_1->save();

                }


            }

        }
    }

    function add_number_in_rout($widget, $routing, $number_to)
    {

        for ($i = 0; $i < count($this->numbers_to_rout); $i++) {
            $newphone = $this->numbers_to_rout[$i];
            DB::table('widgets_phone')->where('widget_id', $widget->id)->where('input', $this->numbers_to_rout[$i])->update([
                'tip' => $this->inputdata->ar_tip_calltrack,
                'routing' => $routing,
                /*78612123318*/
                'phone' => '+' . $newphone[0] . ' (' . $newphone[1] . $newphone[2] . $newphone[3] . ') ' . '' . $newphone[4] . $newphone[5] . $newphone[6] . '-' . $newphone[7] . $newphone[8] . '-' . $newphone[9] . $newphone[10],
            ]);


            DB::connection('asterisk')->table('routing')->where('did', $this->numbers_to_rout[$i])->delete();

            DB::connection('asterisk')->table('routing')->insert([
                'did' => $this->numbers_to_rout[$i],
                'dialstring' => $number_to,
                'block' => 'no',
                'priority' => '1',
                'my_router' => $routing
                ,'comment'=>'3_'.$number_to

            ]);


        };


    }

    function numbers_in_routing($widget, $routing)
    {
        info(json_encode($widget));
        info(json_encode($routing));
        info(json_encode($this->inputdata->ar_reditrect));
        info(json_encode($this->inputdata->ar_phone_redirect));
        info(json_encode($this->inputdata->all()));
        $number_to = '';
        $_get_old_numbers = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('routing', $routing)->get();

        $Api = new ApiController();
        $number_to = '';
        if ($this->inputdata->ar_reditrect == 0) {
            $number_to = 'SIP/runexis/' . $Api->format_phone($this->inputdata->ar_phone_redirect);;
        }

        $Api = new ApiController();
        if ($this->inputdata->ar_reditrect == 1) {
            $number_to = 'SIP/' . $this->inputdata->ar_phone_redirect;
        }


        foreach ($_get_old_numbers as $get_old_number) {
            if ($this->inputdata->ar_reditrec == 2) {

                $sipnumber = '5' . auth()->user()->my_company_id . '' . $widget->id;
                $number_to1 = $this->create_sip($sipnumber, $get_old_number->input);

                $number_to = 'SIP/' . $number_to1;
            }

            DB::table('widgets_phone')->where('id', $get_old_number->id)->update(['tip' => $this->inputdata->ar_tip_calltrack,
            ]);




            $prot = DB::connection('asterisk')->table('routing')->where('did', $get_old_number->input)->first();
            if (!$prot) {
                DB::connection('asterisk')->table('routing')->insert([
                    'did' => $get_old_number->input,
                    'dialstring' => $number_to,
                    'block' => 'no',
                    'priority' => '1',
                    'my_router' => $routing
                    ,'comment'=>'1_'.$number_to

                ]);


            } else {

                DB::connection('asterisk')->table('routing')->where('did', $get_old_number->input)->update([

                    'dialstring' => $number_to,'comment'=>'2_'.$number_to


                ]);
            }

        }
        return $number_to;
    }

    public function get_0($request)
    {


        $widget = '';
        $user = '';
        if ($request->ar_id > 0) {


            $rout = DB::table('widgets_phone_routing')->where('id', $request->ar_id)->where('my_company_id', $user->my_company_id)->first();
            if ($rout) {


                DB::table('widgets_phone_routing')->where('id', $rout->id)->update([

                    'name' => $request->name,
                    'tip_redirect' => $request->reditrect,
                    'number_to' => $request->phone_redirect,
                    'tip_calltrack' => $request->tip_calltrack,
                    'updated_at' => date('Y-m-d')
                    ,
                    'utm_campaign' => $request->utm_campaign,
                    'utm_term' => $request->utm_term,
                    'utm_content' => $request->utm_content,
                    'utm_medium' => $request->utm_medium,
                    'utm_source' => $request->utm_source,
                    'static_url' => $request->static_url,
                    'is_default' => $request->is_default,


                ]);
                $rout = Widgets_phone_routing::find($rout->id);
                if ($request->tip_calltrack == 2) {
                    $rout->canals = [$request->ar_canals];
                } else {

                    $rout->canals = $request->ar_canals_dinamic;
                }
                $rout->class_replace = $request->class_replace;
                $rout->phone_replace = $request->phone_replace;
                $rout->save();
                $routing = $rout->id;
            } else {
                return false;
            }


        } else {

            $rout = new Widgets_phone_routing();

            $rout->widget_id = $widget->id;
            $rout->my_company_id = $user->my_company_id;
            $rout->name = $request->name;
            $rout->tip_redirect = $request->reditrect;
            $rout->number_to = $request->phone_redirect;
            $rout->tip_calltrack = $request->tip_calltrack;
            $rout->created_at = date('Y-m-d');
            $rout->status = 1;
            $rout->is_default = $request->is_default;


            $rout->utm_campaign = $request->utm_campaign;
            $rout->utm_term = $request->utm_term;
            $rout->utm_content = $request->utm_content;
            $rout->utm_medium = $request->utm_medium;
            $rout->utm_source = $request->utm_source;
            $rout->static_url = $request->static_url;
            $rout->class_replace = $request->class_replace;
            $rout->phone_replace = $request->phone_replace;
            if ($request->tip_calltrack == 2) {
                $rout->canals = [$request->ar_canals];
            } else {

                $rout->canals = $request->ar_canals_dinamic;
            }


            $rout->save();

            $routing = $rout->id;
        }


        /*Изменяем старые номерв*/
        /*Новые номера*/

        $_get_old_numbers = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('routing', $routing)->get();
        foreach ($_get_old_numbers as $get_old_number) {

            DB::table('widgets_phone')->where('id', $get_old_number->id)->update(['tip' => $request->tip_calltrack,
                'utm_campaign' => $request->utm_campaign,
                'utm_term' => $request->utm_term,
                'utm_content' => $request->utm_content,
                'utm_medium' => $request->utm_medium,
                'utm_source' => $request->utm_source, 'static_url' => $request->static_url,]);


            $Api = new ApiController();
            $number_to = '';
            if ($request->reditrect == 0) {
                $number_to = 'SIP/runexis/' . $Api->format_phone($request->phone_redirect);;
            }

            $Api = new ApiController();
            if ($request->reditrect == 1) {
                $number_to = 'SIP/' . $request->phone_redirect;
            }
            if ($request->reditrect == 2) {

                $sipnumber = '5' . $user->my_company_id . '' . $widget->id;
                $number_to1 = $this->create_sip($sipnumber, $get_old_number->input);

                $number_to = 'SIP/' . $number_to1;
            }
            if ($request->reditrect == 3) {
                $number_to = 'SIP/' . $get_old_number->input . '@pbx.roistat.com';
            }

            $prot = DB::connection('asterisk')->table('routing')->where('did', $get_old_number->input)->first();
            if (!$prot) {
                DB::connection('asterisk')->table('routing')->insert([
                    'did' => $get_old_number->input,
                    'dialstring' => $number_to,
                    'block' => 'no',
                    'priority' => '1',
                    'my_router' => $routing

                ]);


            } else {

                DB::connection('asterisk')->table('routing')->where('did', $get_old_number->input)->update([

                    'dialstring' => $number_to,


                ]);
            }

        }


        if (isset($request->number)) {
            for ($i = 0; $i < count($request->number); $i++) {
                $newphone = $request->number[$i];
                DB::table('widgets_phone')->where('widget_id', $widget->id)->where('input', $request->number[$i])->update([
                    'tip' => $request->tip_calltrack,
                    'routing' => $routing,
                    /*78612123318*/
                    'phone' => '+' . $newphone[0] . ' (' . $newphone[1] . $newphone[2] . $newphone[3] . ') ' . '' . $newphone[4] . $newphone[5] . $newphone[6] . '-' . $newphone[7] . $newphone[8] . '-' . $newphone[9] . $newphone[10],

                    'utm_campaign' => $request->utm_campaign,
                    'utm_term' => $request->utm_term,
                    'utm_content' => $request->utm_content,
                    'utm_medium' => $request->utm_medium,
                    'utm_source' => $request->utm_source,
                ]);


                DB::connection('asterisk')->table('routing')->where('did', $request->number[$i])->delete();

                DB::connection('asterisk')->table('routing')->insert([
                    'did' => $request->number[$i],
                    'dialstring' => $number_to,
                    'block' => 'no',
                    'priority' => '1',
                    'my_router' => $routing

                ]);


            };
        }
        /*конец новых номеров*/
        if ($request->tip_calltrack == 1) {

            $prov_rezerv = DB::table('widgets_phone')->where('widget_id', $widget->id)->where('tip', 1)->where('rezerv', 1)->where('routing', $routing)->get();
            if (count($prov_rezerv) == 0) {
                $prov_rezerv_1 = Widgets_phone::where('widget_id', $widget->id)->where('tip', 1)->where('routing', $routing)->first();
                if ($prov_rezerv_1) {

                    $prov_rezerv_1->rezerv = 1;
                    $prov_rezerv_1->save();

                }

                return '0';
            }
            if (count($prov_rezerv) == 1) {

                return '0';

            }
            if (count($prov_rezerv) > 1) {
                DB::table('widgets_phone')->where('widget_id', $widget->id)->where('tip', 1)->where('routing', $routing)->where('rezerv', 1)->update([
                    'rezerv' => 0
                ]);
                $prov_rezerv_1 = Widgets_phone::where('widget_id', $widget->id)->where('tip', 1)->where('routing', $routing)->first();
                if ($prov_rezerv_1) {


                    $prov_rezerv_1->rezerv = 1;
                    $prov_rezerv_1->save();

                }
                return '0';

            }

        }


        return '0';
    }

    public function create_sip($number, $password)
    {
        Log::info($number);
        Log::info($password);
        $prov_number = DB::connection('asterisk')->table('sippeers')->where('name', $number)->first();
        if ($prov_number) {

            DB::connection('asterisk')->table('sippeers')->where('id', $prov_number->id)->update([
                'secret' => $password
            ]);
            return $number;
        } else {


            DB::connection('asterisk')->table('sippeers')->insert([
                'name' => $number,
                'defaultuser' => $number,
                'secret' => $password,
                'context' => 'from-local',
                'host' => 'dynamic',
                'nat' => 'force_rport,comedia',
                'type' => 'friend',
                'qualify' => 'yes',
                'call-limit' => '1',
                'dtmfmode' => 'rfc2833',
                'transport' => 'udp',


            ]);


            return $number;
        }


    }

    public function deletete_number($number)
    {
        $user = Auth::user();
        DB::connection('asterisk')->table('routing')->where('did', $number)->delete();


    }

    public function deletete_number_from_rout($number)
    {
        $user = Auth::user();
        DB::connection('asterisk')->table('routing')->where('my_router', $number)->delete();


    }

    public function addphone_in(Request $request)
    {
        $user = Auth::user();
        if ($user->tarif == 2) {
            $data['status'] = 0;
            $data['message'] = 'В демо кабинете невозможно покупать номера';
            return $data;

        }
        if ($user->is_active == 0) {
            $data['status'] = 0;
            $data['message'] = 'Во время тестового периода покупать номера';
            return $data;
        }

        $RunexisController = new RunexisController();


        $widget_promokod = DB::table('widget_call_track')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_call_track)->first();
        if (!$widget_promokod) {
            $data['status'] = 0;
            $data['message'] = 'Ошибка виджета';
            return $data;
        }
        $widget = Widgets::where('id', $widget_promokod->widget_id)->first();


        $result = $RunexisController->bayphone($request->amount, $request->region, $widget->id, $user->my_company_id);
        return $result;

    }

    public function set_work_or_not_work($widget){


$time=$this->prow_work_time($widget);

$routings=\DB::table('widgets_phone_routing')->where('widget_id',$widget->id)->pluck('id');

if($widget->status==0){
    DB::connection('asterisk')->table('routing')->wherein('my_router', $routings)->update([
        'play_and_hangup' => 'b9'

    ]);

}else {

    DB::connection('asterisk')->table('routing')->wherein('my_router', $routings)->update([
        'play_and_hangup' => $time

    ]);

}
    }

    public function prow_work_time($mega){

        $off = '';
        $weekday[1] = 'Понедельник';
        $weekday[2] = 'Вторник';
        $weekday[3] = 'Среда';
        $weekday[4] = 'Четверг';
        $weekday[5] = 'Пятница';
        $weekday[6] = 'Суббота';
        $weekday[7] = 'Воскресенье';

        $time_work = DB::table('widget_callback_worktime')->where('sites_id', $mega->sites_id)->where('is_work', 1)->get();
        $datarr = [];
        foreach ($time_work as $time_w) {

            $datarr[$time_w->day] = $time_w;


        }
        $wChat=new WidgetChatController();


        $datavivod1 = $wChat->get_first_day($datarr, $weekday);
        if ($datavivod1['day'] !== date('N')) {


            $off = '/opt/background/sounds/b11';
        } else {
            $off = '';
            if((int)date('H')>(int)$datavivod1['hour_end']){$data['off']=1;}
            if((int)date('H')<(int)$datavivod1['hour']){$data['off']=1;}
        }









return $off;


    }


}
