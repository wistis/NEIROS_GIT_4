<?php

namespace App\Http\Controllers;

use App\Models\Settings\CompanyDefaultSetting;
use App\Sites;
use App\User;
use App\Widgets;
use Auth;
use DB;
use Illuminate\Http\Request;
use function React\Promise\reject;


class SitesController extends Controller
{


    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {

        return $this->grid();

    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {


        return $this->form($id);

    }

    /**
     * Create interface.
     *
     * @return Content
     */

    public function sms_code(){




        $user=User::find(auth()->user()->id);
        $code=request()->get('sms_code');
        if($user->sms_code==$code){
            $user->sms_code=0;


            $user->save();
        }else{
            session()->flash('message');
        }
        return redirect('/setting/sites/create');
    }

    public function create()
    {
        return $this->form();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()

    {
        $user = Auth::user();
        ProjectController::get_role('read', 3);
        $datas['stages'] = Sites::where('my_company_id', $user->my_company_id)->where('is_deleted',0)->get();

        return view('sites.list', $datas);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null)
    {
        $user = Auth::user();
        if (is_null($id)) {


            return view('sites.add');

        } else {
            ProjectController::get_role('edit', 3);
            $data = Company::where('my_company_id', $user->my_company_id)->findOrFail($id);
            $partners = collect();
            $partners->client_id = $id;
            $data['clients'] = Client::where('company_id', $id)->where('my_company_id', $user->my_company_id)->get();
            $data['client_field'] = ProjectController::get_edit_field($partners, 2);
            return view('company.edit', $data);
        }


    }
public function createsite(Request $request){

    $user = Auth::user();

    if ($request->site_id == 0) {


        $idsite = Sites::insertGetId(
            ['name' => trim($request->url),
                'project_name' => trim($request->name),
                'protokol' => $request->protokol,
                'my_company_id' => $user->my_company_id,
                'user_id' => $user->id,
                'hash' => md5(time() . $user->id . rand(1, 544)) . '_' . $user->id,
            ]);




        for ($i = 0; $i <= 14; $i++) {

            if ($i == 0) {
                $name = 'Промокод ' . $request->name;
            }
            if ($i == 1) {
                $name = 'Колбэк ' . $request->name;
            }
            if ($i == 2) {
                $name = 'Колтрекинг ' . $request->name;
            }
            if ($i == 3) {
                $name = 'JS Цели ' . $request->name;
            }
            if ($i == 4) {
                $name = 'Виджет ВК' . $request->name;
            }
            if ($i == 5) {
                $name = 'Виджет Viber ' . $request->name;
            }
            if ($i == 6) {
                $name = 'Виджет OK ' . $request->name;
            }
            if ($i == 7) {
                $name = 'Виджет FaseBook ' . $request->name;
            }
            if ($i == 8) {
                $name = 'Виджет Telegram ' . $request->name;
            }
            if ($i == 9) {
                $name = 'Виджет E-mail трекинг ' . $request->name;
            }
            if ($i == 10) {
                $name = 'API Метрики ' . $request->name;
            }
            if ($i == 11) {
                $name = 'API Yandex.Direct ' . $request->name;
            }
            if ($i == 12) {
                $name = 'Виджет чата ' . $request->name;
            }
            if ($i == 13) {
                $name = 'Виджет Popup ' . $request->name;
            }
            if ($i == 14) {
                $name = 'Виджет Ловец ботов ' . $request->name;
            }
            $new_widget_id = Widgets::insertGetId(
                ['name' => $name,
                    'email' => '',
                    'phone' => '',
                    'protokol' => $request->protokol,
                    'site' => $request->name,
                    'tip' => $i,
                    'user_id' => $user->id,
                    'stage_id' => 0,
                    'hash' => md5(time() . $user->id . rand(1, 544)) . '_' . $user->id,
                    'my_company_id' => $user->my_company_id,
                    'outputcall' => 0,
                    'city' => 0,
                    'amount_phone' => 0,
                    'element' => '',
                    'sites_id' => $idsite,
                    'status' => 0,

                ]);
            if ($i == 0) {
                /*`id`, `widget_id`, `my_company_id`, `user_id`, `color`, `background`, `position_x`, `position_y`, `updated_at`, `created_at`*/
                DB::table('widgets_promokod')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,

                ]);
            }
            if ($i == 1) {
                DB::table('widget_callback')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,

                ]);

            }
            if ($i == 2) {

                DB::table('widget_call_track')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,
                    'outputcall' => 0,
                    'element'=>''




                ]);

            }
            if ($i == 4) {
                $name = 'Виджет ВК' . $request->name;
                /*`confirmation`, `groupid`, `apikey`*/
                DB::table('widget_vk')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,
                    'confirmation' => '',
                    'groupid' => '',
                    'apikey' => '',

                ]);

            }
            if ($i == 5) {

                /*`confirmation`, `groupid`, `apikey`*/
                DB::table('widget_viber')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,
                    'start_message' => '',

                    'apikey' => '',

                ]);

            }
            if ($i == 6) {

                /*`confirmation`, `groupid`, `apikey`*/
                DB::table('widget_ok')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,
                    'start_message' => '',

                    'apikey' => '',

                ]);

            }
            if ($i == 7) {

                /*`confirmation`, `groupid`, `apikey`*/
                DB::table('widget_fb')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,
                    'start_message' => '',

                    'apikey' => '',

                ]);

            }
            if ($i == 8) {

                /*`confirmation`, `groupid`, `apikey`*/
                DB::table('widget_telegram')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,
                    'start_message' => '',

                    'apikey' => '',

                ]);

            }
            if ($i == 9) {

                /*`confirmation`, `groupid`, `apikey`*/
                DB::table('widgets_email')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,
                    'email' => '',
                    'email' => '',
                    'server' => '',
                    'login' => '',
                    'password' => '',



                ]);

            }
            if ($i == 10) {

                /*`confirmation`, `groupid`, `apikey`*/
                DB::table('widget_metrika')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,



                ]);

            }
            if ($i == 11) {

                /*`confirmation`, `groupid`, `apikey`*/
                DB::table('widget_direct')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,



                ]);

            }
            if ($i == 12) {


                DB::table('widgets_chat')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,



                ]);

            }
            if ($i == 13) {


                DB::table('widgets_popup')->insert([
                    'widget_id' => $new_widget_id,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,



                ]);

            }

        }
        $data['id']=$idsite;
        $sit=DB::table('sites')->where('id',$idsite)->first();
    } else {
        $sit=DB::table('sites')->where('id',$request->site_id)->first();
        $data['id']=$request->site_id;








    }
    $this->reloadwidget();
    $data['hash']='
     <!--Neiros-->
     <script>
    var scr = {"scripts":[{"src" : "'.$_ENV['APP_URL'].'/api/widget_site/get/'.$sit->hash.'",
    "async" : false}
	]};
	!function(t,n,r){
	"use strict";
	var c=function(t){
	if("[object Array]"!==Object.prototype.toString.call(t))return!1;
	for(var r=0;r<t.length;r++){
	var c=n.createElement("script"),e=t[r];
	c.src=e.src,c.async=e.async,n.body.appendChild(c)}return!0};
	t.addEventListener?t.addEventListener("load",function(){
	c(r.scripts);},!1):t.attachEvent?t.attachEvent("onload",function(){
	c(r.scripts)}):t.onload=function(){
	c(r.scripts)}}(window,document,scr);</script>
	<!--Neiros -->
   ';
    return json_encode($data);
}
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($request->site_id == 0) {


            $idsite = Sites::insertGetId(
                ['name' => trim($request->url),
                 'project_name' => trim($request->name),
                    'protokol' => $request->protokol,
                    'my_company_id' => $user->my_company_id,
                    'user_id' => $user->id,
                    'hash' => md5(time() . $user->id . rand(1, 544)) . '_' . $user->id,
                ]);




            for ($i = 0; $i <= 18; $i++) {

                if ($i == 0) {
                    $name = 'Промокод ' . $request->name;
                }
                if ($i == 1) {
                    $name = 'Колбэк ' . $request->name;
                }
                if ($i == 2) {
                    $name = 'Колтрекинг ' . $request->name;
                }
                if ($i == 3) {
                    $name = 'JS Цели ' . $request->name;
                }
                if ($i == 4) {
                    $name = 'Виджет ВК' . $request->name;
                }
                if ($i == 5) {
                    $name = 'Виджет Viber ' . $request->name;
                }
                if ($i == 6) {
                    $name = 'Виджет OK ' . $request->name;
                }
                if ($i == 7) {
                    $name = 'Виджет FaseBook ' . $request->name;
                }
                if ($i == 8) {
                    $name = 'Виджет Telegram ' . $request->name;
                }
                if ($i == 9) {
                    $name = 'Виджет E-mail трекинг ' . $request->name;
                }
                if ($i == 10) {
                    $name = 'API Метрики ' . $request->name;
                }
                if ($i == 11) {
                    $name = 'API Yandex.Direct ' . $request->name;
                }
                if ($i == 12) {
                    $name = 'Виджет чата ' . $request->name;
                }
                if ($i == 13) {
                    $name = 'Виджет Popup ' . $request->name;
                }
                if ($i == 14) {
                    $name = 'Виджет Ловец ботов ' . $request->name;
                }
                if ($i == 15) {
                    $name = 'Offline Промокод ' . $request->name;
                }
                if ($i == 16) {
                    $name = 'Bitrix24 Api ' . $request->name;
                }
                if ($i == 17) {
                    $name = 'AmoCrm Api ' . $request->name;
                }
                if ($i == 18) {
                    $name = 'AmoCrm Api ' . $request->name;
                }
                if ($i == 18) {
                    $name = 'AmoCrm Api ' . $request->name;
                }
                $new_widget_id = Widgets::insertGetId(
                    ['name' => $name,
                        'email' => '',
                        'phone' => '',
                        'protokol' => $request->protokol,
                        'site' => $request->name,
                        'tip' => $i,
                        'user_id' => $user->id,
                        'stage_id' => 0,
                        'hash' => md5(time() . $user->id . rand(1, 544)) . '_' . $user->id,
                        'my_company_id' => $user->my_company_id,
                        'outputcall' => 0,
                        'city' => 0,
                        'amount_phone' => 0,
                        'element' => '',
                        'sites_id' => $idsite,
                        'status' => 0,

                    ]);
                if ($i == 18) {
                    /*`id`, `widget_id`, `my_company_id`, `user_id`, `color`, `background`, `position_x`, `position_y`, `updated_at`, `created_at`*/
                    DB::table('widgets_roistar')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,


                    ]);
                }

                if ($i == 17) {
                    /*`id`, `widget_id`, `my_company_id`, `user_id`, `color`, `background`, `position_x`, `position_y`, `updated_at`, `created_at`*/
                    DB::table('widgets_amocrm')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,


                    ]);
                }
                if ($i == 16) {
                    /*`id`, `widget_id`, `my_company_id`, `user_id`, `color`, `background`, `position_x`, `position_y`, `updated_at`, `created_at`*/
                    DB::table('widgets_bitrix24')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,


                    ]);
                }
                if ($i == 0) {
                    /*`id`, `widget_id`, `my_company_id`, `user_id`, `color`, `background`, `position_x`, `position_y`, `updated_at`, `created_at`*/
                    DB::table('widgets_promokod')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,

                    ]);
                }
                if ($i == 1) {
                    DB::table('widget_callback')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,

                    ]);
                    for($i==1;$i<8;$i++){
                        DB::table('widget_callback_worktime')->insert([
                            'day'=>$i,
                            'hour'=>9,
                            'hour_end'=>18,
                            'is_work'=>1,
                            'my_company_id'=>$user->my_company_id,
                            'widget_id'=>$new_widget_id,
'sites_id'=>$idsite

                        ]);



                    }

                }
                if ($i == 2) {

                    DB::table('widget_call_track')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,
                        'outputcall' => 0,
                        'element'=>''




                    ]);

                }
                if ($i == 4) {
                    $name = 'Виджет ВК' . $request->name;
                    /*`confirmation`, `groupid`, `apikey`*/
                    DB::table('widget_vk')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,
                        'confirmation' => '',
                        'groupid' => '',
                        'apikey' => '',

                    ]);

                }
                if ($i == 5) {

                    /*`confirmation`, `groupid`, `apikey`*/
                    DB::table('widget_viber')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,
                        'start_message' => '',

                        'apikey' => '',

                    ]);

                }
                    if ($i == 6) {

                        /*`confirmation`, `groupid`, `apikey`*/
                        DB::table('widget_ok')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,
                            'start_message' => '',

                            'apikey' => '',

                        ]);

                    }
                if ($i == 7) {

                    /*`confirmation`, `groupid`, `apikey`*/
                    DB::table('widget_fb')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,
                        'start_message' => '',

                        'apikey' => '',

                    ]);

                }
                if ($i == 8) {

                    /*`confirmation`, `groupid`, `apikey`*/
                    DB::table('widget_telegram')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,
                        'start_message' => '',

                        'apikey' => '',

                    ]);

                }
                if ($i == 9) {

                    /*`confirmation`, `groupid`, `apikey`*/
                    DB::table('widgets_email')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,
                        'email' => '',
                        'email' => '',
                        'server' => '',
                        'login' => '',
                        'password' => '',



                    ]);

                }
                if ($i == 10) {

                    /*`confirmation`, `groupid`, `apikey`*/
                    DB::table('widget_metrika')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,



                    ]);

                }
                if ($i == 11) {

                    /*`confirmation`, `groupid`, `apikey`*/
                    DB::table('widget_direct')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,



                    ]);

                }
                if ($i == 12) {


                    DB::table('widgets_chat')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,



                    ]);

                }
                if ($i == 13) {


                    DB::table('widgets_popup')->insert([
                        'widget_id' => $new_widget_id,
                        'my_company_id' => $user->my_company_id,
                        'user_id' => $user->id,



                    ]);

                }

            }
$data['id']=$idsite;
            $sit=Sites::find($request->site_id);
        } else {
       $sit=Sites::find($request->site_id);
       $data['id']=$request->site_id;






        }
        $data['hash']='<script type="text/javascript" src="'.$_ENV['APP_URL'].'/api/widget_site/get/'.$sit->hash.'"></script>';
return json_encode($data);
    }

    public function reloadwidget()
    {

        $users = DB::table('users')->get();
foreach ($users as $user){

$mcomset= CompanyDefaultSetting::where('my_company_id',$user->my_company_id)->first();
if(!$mcomset){

    $mcomset=new CompanyDefaultSetting();
    $mcomset->skey='callbach_who_call_first';
    $mcomset->value=0;
    $mcomset->my_company_id=$user->my_company_id;
    $mcomset->comment='Выбор кому первому звонит колбек 0-Оператор, 1 - Клиент';
    $mcomset->save();

    $mcomset=new CompanyDefaultSetting();
    $mcomset->skey='callbach_who_man_wooman';
    $mcomset->value=0;
    $mcomset->my_company_id=$user->my_company_id;
    $mcomset->comment='Мужской или женский голос';
    $mcomset->save();

    $mcomset=new CompanyDefaultSetting();
    $mcomset->skey='catch_who_call_first';
    $mcomset->value=0;
    $mcomset->my_company_id=$user->my_company_id;
    $mcomset->comment='Выбор кому первому звонит колбек 0-Оператор, 1 - Клиент';
    $mcomset->save();

    $mcomset=new CompanyDefaultSetting();
    $mcomset->skey='catch_who_man_wooman';
    $mcomset->value=0;
    $mcomset->my_company_id=$user->my_company_id;
    $mcomset->comment='Мужской или женский голос';
    $mcomset->save();

}


        $get_sites = Sites::where('my_company_id', $user->my_company_id)->get();;
        if (!$get_sites) {
            return abort(404);
        }
        foreach ($get_sites as $get_site) {
            for ($i = 0; $i <= 27; $i++) {
                $getwidget = Widgets::where('tip', $i)->where('my_company_id', $user->my_company_id)->where('sites_id', $get_site->id)->first();

                if (!$getwidget) {
                    if ($i == 0) {
                        $name = 'Промокод ' . $get_site->name;
                    }
                    if ($i == 1) {
                        $name = 'Колбэк ' . $get_site->name;
                    }
                    if ($i == 2) {
                        $name = 'Колтрекинг ' . $get_site->name;
                    }
                    if ($i == 3) {
                        $name = 'JS Цели ' . $get_site->name;
                    }
                    if ($i == 4) {
                        $name = 'Виджет ВК' . $get_site->name;
                    }
                    if ($i == 5) {
                        $name = 'Виджет Viber ' . $get_site->name;
                    }
                    if ($i == 6) {
                        $name = 'Виджет OK ' . $get_site->name;
                    }
                    if ($i == 7) {
                        $name = 'Виджет Facebook ' . $get_site->name;
                    }
                    if ($i == 8) {
                        $name = 'Виджет Telegram ' . $get_site->name;
                    }
                    if ($i == 9) {
                        $name = 'Виджет E-mail трекинг' . $get_site->name;
                    }
                    if ($i == 10) {
                        $name = 'API Метрика' . $get_site->name;
                    }
                    if ($i == 11) {
                        $name = 'API Yandex.Direct ' . $get_site->name;
                    }
                    if ($i == 12) {
                        $name = 'Виджет чата ' . $get_site->name;
                    }
                    if ($i == 13) {
                        $name = 'Виджет Popup ' . $get_site->name;
                    }
                    if ($i == 13) {
                        $name = 'Виджет Ловец ботов ' . $get_site->name;
                    }
                    if ($i == 14) {
                        $name = '?? ' . $get_site->name;
                    }
                    if ($i == 15) {
                        $name = 'Offline Промокод ' . $get_site->name;
                    }
                    if ($i == 16) {
                        $name = 'Bitrix24 Api' . $get_site->name;
                    }
                    if ($i == 17) {
                        $name = 'AmoCrm Api' . $get_site->name;
                    }
                    if ($i == 18) {
                        $name = 'Roistat ' . $get_site->name;
                    }

                    if ($i == 19) {
                        $name = 'Ловец лидов ' . $get_site->name;
                    }
                    if ($i == 20) {
                        $name = 'Adwords ' . $get_site->name;
                    }
                    if ($i == 21) {
                        $name = 'JivoSite ' . $get_site->name;
                    }
                    if ($i == 22) {
                        $name = 'Звонок в GA ' . $get_site->name;
                    }
                    if ($i == 23) {
                        $name = 'Соц кнопки ' . $get_site->name;
                    }
                    if ($i == 24) {
                        $name = 'Карта яндекс виджет ' . $get_site->name;
                    }
                    if ($i == 25) {
                        $name = 'Виджет обратная форма ' . $get_site->name;
                    }
                    if ($i == 26) {
                        $name = 'Виджет ProWidget ' . $get_site->name;
                    }
                    if ($i == 27) {
                        $name = 'Виджет Tilda ' . $get_site->name;
                    }
                    $new_widget_id = Widgets::insertGetId(
                        ['name' => $name,
                            'email' => '',
                            'phone' => '',
                            'protokol' => $get_site->protokol,
                            'site' => $get_site->name,
                            'tip' => $i,
                            'user_id' => $user->id,
                            'stage_id' => 0,
                            'hash' => md5(time() . $user->id . rand(1, 544)) . '_' . $user->id,
                            'my_company_id' => $user->my_company_id,
                            'outputcall' => 0,
                            'city' => 0,
                            'amount_phone' => 0,
                            'element' => '',
                            'sites_id' => $get_site->id,
                            'status' => 0,

                        ]);

                    if ($i == 18) {
                        /*`id`, `widget_id`, `my_company_id`, `user_id`, `color`, `background`, `position_x`, `position_y`, `updated_at`, `created_at`*/
                        DB::table('widgets_roistar')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,


                        ]);
                    }

                    if ($i == 17) {
                        /*`id`, `widget_id`, `my_company_id`, `user_id`, `color`, `background`, `position_x`, `position_y`, `updated_at`, `created_at`*/
                        DB::table('widgets_amocrm')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,


                        ]);
                    }

                    if ($i == 16) {
                        /*`id`, `widget_id`, `my_company_id`, `user_id`, `color`, `background`, `position_x`, `position_y`, `updated_at`, `created_at`*/
                        DB::table('widgets_bitrix24')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,


                        ]);
                    }

                    /*INSERT INTO `widgets_bitrix24`(`id`, `widget_id`, `site_id`, `my_company_id`, `server`, `login`, `password`, `created_at`, `updated_at`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])*/
                    if ($i == 0) {
                        /*`id`, `widget_id`, `my_company_id`, `user_id`, `color`, `background`, `position_x`, `position_y`, `updated_at`, `created_at`*/
                        DB::table('widgets_promokod')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,

                        ]);
                    }
                    if ($i == 5) {

                        /*`confirmation`, `groupid`, `apikey`*/
                        DB::table('widget_viber')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,
                            'start_message' => '',

                            'apikey' => '',

                        ]);

                    }
                    if ($i == 6) {

                        /*`confirmation`, `groupid`, `apikey`*/
                        DB::table('widget_ok')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,
                            'start_message' => '',

                            'apikey' => '',

                        ]);

                    }
                    if ($i == 7) {

                        /*`confirmation`, `groupid`, `apikey`*/
                        DB::table('widget_fb')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,
                            'start_message' => '',

                            'apikey' => '',

                        ]);

                    }
                    if ($i == 8) {

                        /*`confirmation`, `groupid`, `apikey`*/
                        DB::table('widget_telegram')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,
                            'start_message' => '',

                            'apikey' => '',

                        ]);

                    }
                    if ($i == 9) {

                        /*`confirmation`, `groupid`, `apikey`*/
                        DB::table('widgets_email')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,
                            'email' => '',
                            'email' => '',
                            'server' => '',
                            'login' => '',
                            'password' => '',


                        ]);

                    }
                    if ($i == 10) {

                        /*`confirmation`, `groupid`, `apikey`*/
                        DB::table('widget_metrika')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,


                        ]);

                    }
                    if ($i == 11) {

                        /*`confirmation`, `groupid`, `apikey`*/
                        DB::table('widget_direct')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,


                        ]);

                    }
                    if ($i == 12) {


                        DB::table('widgets_chat')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,


                        ]);

                    }
                    if ($i == 13) {


                        DB::table('widgets_popup')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,


                        ]);

                    }

                    if ($i == 1) {
                        DB::table('widget_callback')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,

                        ]);
/*INSERT INTO `widget_callback_worktime` (`id`, `day`, `hour`, `hour_end`, `is_work`, `created_at`, `updated_at`, `my_company_id`, `widget_id`) VALUES (NULL, '1', '9', '18', '1', NULL, NULL, '1', '1');*/
                        for($i=1;$i<8;$i++){
                            DB::table('widget_callback_worktime')->insert([
                                'day'=>$i,
                                'hour'=>9,
                                'hour_end'=>18,
                                'is_work'=>1,
                                'my_company_id'=>$user->my_company_id,
                                'widget_id'=>$new_widget_id,
'sites_id'=>$get_site->id

                            ]);



                        }


                    }

                    if ($i == 2) {
                        /*INSERT INTO `widget_call_track`(`id`, `name`, `city`, `outputcall`, `number`, `element`, `my_company_id`, `created_at`, `updated_at`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])*/
                        DB::table('widget_call_track')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,
                            'outputcall' => 0,
                            'element' => ''


                        ]);

                    }
                    if ($i == 4) {
                        $name = 'Виджет ВК' . $get_site->name;
                        /*`confirmation`, `groupid`, `apikey`*/
                        DB::table('widget_vk')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,
                            'confirmation' => '',
                            'groupid' => '',
                            'apikey' => '',

                        ]);

                    }

                    if ($i == 19) {
                        DB::table('widget_catch_lead')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,

                        ]);

                        /*INSERT INTO `widget_callback_worktime` (`id`, `day`, `hour`, `hour_end`, `is_work`, `created_at`, `updated_at`, `my_company_id`, `widget_id`) VALUES (NULL, '1', '9', '18', '1', NULL, NULL, '1', '1');*/
                        for($iss=1;$iss<8;$iss++){
                           /* DB::table('widget_catch_lead_worktime')->insert([
                                'day'=>$iss,
                                'hour'=>9,
                                'hour_end'=>18,
                                'is_work'=>1,
                                'my_company_id'=>$user->my_company_id,
                                'widget_id'=>$new_widget_id,


                            ]);*/

 

                        }


                    }

                    if ($i == 20) {

                        /*`confirmation`, `groupid`, `apikey`*/
                        DB::table('widget_adwords')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,
                            'user_id' => $user->id,
                            'site_id' => $get_site->id,


                        ]);

                    }
                    if ($i == 21) {
                        /*`id`, `widget_id`, `my_company_id`, `user_id`, `color`, `background`, `position_x`, `position_y`, `updated_at`, `created_at`*/
                        DB::table('widgets_jivosite')->insert([
                            'widget_id' => $new_widget_id,
                            'my_company_id' => $user->my_company_id,


                        ]);
                    }
                }else{
                    if($getwidget->tip==1){


$getwork=DB::table('widget_callback_worktime')->where('my_company_id',$getwidget->my_company_id)->where('sites_id',$get_site->id)->first();

                   if(!$getwork){     for($i==1;$i<8;$i++) {
                       DB::table('widget_callback_worktime')->insert([
                           'day' => $i,
                           'hour' => 9,
                           'hour_end' => 18,
                           'is_work' => 1,
                           'my_company_id' => $getwidget->my_company_id,
                           'widget_id' => $getwidget->id,
'sites_id'=>$get_site->id,

                       ]);
                   }


                        }




                    }




                }
            }


        }
    }
    }


    public function get_default_company_setting($skey,$comment){

        $mcomset=new CompanyDefaultSetting();
        $mcomset->skey=$skey;//$skey'catch_who_man_wooman';
        $mcomset->value=0;
        $mcomset->my_company_id=auth()->user()->my_company_id;
        $mcomset->comment=$comment;//'Мужской или женский голос';
        $mcomset->save();


    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($request->stageId == 0) {
            $flight = Company::insertGetId(['name' => trim($request->name), 'my_company_id' => $user->my_company_id]);
            $datafield = $request->datafield;
            $clientAndCompany['client_id'] = $flight;
            $projectId = 0;

            ProjectController:: add_datafield($datafield, $clientAndCompany, $projectId);

            /*datacontact*/
            $datatask = $request->datacontact;
            for ($i = 0; $i < count($datatask); $i++) {


                if ($datatask[$i]['active'] == 1) {


                    if ($datatask[$i]['id'] == 0) {
                        $project_tag = Client::firstOrNew([
                            'fio' => $datatask[$i]['fio'],
                            'email' => $datatask[$i]['phone'],
                            'phone' => $datatask[$i]['email'],
                            'company_id' => $flight,
                            'my_company_id' => $user->my_company_id]);
                        $project_tag->save();
                    }


                }


            }

            /*datacontact*/


        } else {

            Company::where('id', $request->stageId)->update(['name' => $request->name]);
            $datafield = $request->datafield;
            $clientAndCompany['client_id'] = $request->stageId;
            $projectId = 0;
            ProjectController:: add_datafield($datafield, $clientAndCompany, $projectId);

        }
        /*      Company::where('id',$request->stageId)->update(['name'=>$request->name]);
              $datafield=$request->datafield;
              $clientAndCompany['client_id']=$request->stageId;
              $projectId=0;

              ProjectController:: add_datafield($datafield,$clientAndCompany,$projectId);*/
    }


    public function delete_site($id){
Sites::where('my_company_id',Auth::user()->my_company_id)->where('id',$id)->update(['is_deleted'=>1]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        ProjectController::get_role('delete', 3);
        Company::where('id', $id)->where('my_company_id', $user->my_company_id)->delete();
    }
}
