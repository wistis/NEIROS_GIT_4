<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiTelegram\TelegramController;
use App\Http\Controllers\OkApi\OkApiController;
use App\Http\Controllers\Setting\WchatController;
use App\Http\Controllers\AdwordsController;
use App\Http\Controllers\ViberAPI\ViberApiController;
use App\Models\Chat\WidgetsChatMessRule;
use App\Models\Chat\WidgetsChatMessRuleTable;
use App\Models\Chat\WidgetsChatUrlOperatorNew;
use App\Models\Settings\CompanyDefaultSetting;
use App\Models\Widgets\WidgetCallbackRouting;
use App\Sites;
use App\Stage;
use App\Widgets;
use App\Widgets_chat;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;
use LaravelGoogleAds\Services\AuthorizationService;
use LaravelGoogleAds\Services\AdWordsService;

class WidgetController extends Controller
{
    private $user;
    private $stat_start_date;
    private $stat_end_date;

    protected $authorizationService;
    protected $adWordsService;

    public function __construct(AdWordsService $adWordsService, AuthorizationService $authorizationService)
    {
        $this->adWordsService = $adWordsService;
        $this->authorizationService = $authorizationService;
    }

    public function widget_tip($tip)
    {

        $user = Auth::user();


        return $this->form($tip, $user);


    }

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
        $datas['title'] = 'Титле';
        ProjectController::get_role('read', 3);
        if ($user->site == 0) {
            $datas['stages'] = Widgets::where('my_company_id', $user->my_company_id)->get();
        } else {
            $datas['stages'] = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->get();
        }
        return view('widgets.list', $datas);
    }


    public function get_render_tab($data, $widget_name)
    {
        return view('widgets.render.' . $widget_name, $data)->render();


    }

    public function get_setting()
    {

        $data['user'] = auth()->user();;
        $data['tabs'] = '';;
        $data['modals'] = [];;
        $data['status_checkbox'] = '';;
        $data['title'] = '';;


        /**/

        if (request()->get('subtip') == 100001) {
            $AllWidgetController = new AllWidgetController(0, auth()->user());
            $data = $AllWidgetController->widget_router(0, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(15, 5, $data, 0, 0, 1);
            return $data;
        }
        if (request()->get('subtip') == 'advertisingchannelcost') {
            $AllWidgetController = new AllWidgetController(3, auth()->user());
            $data = $AllWidgetController->widget_router(3, 1, $data, 0, 0, 0);
            return $data;
        }
        if (request()->get('subtip') == 'allreports_setting') {
            $repcont = new ReportsController();
            return $repcont->setting();



        }
        if (request()->get('subtip') == 'calltrack_setting_ajax') {

            return $this->calltrack_setting_ajax();



        }


        if (request()->get('subtip') == 'advertisingchannel') {
            $repcont = new Advertising_channelController();
            return $repcont->index();

        }


        if (request()->get('subtip') == 12) {
            /*Статистика*/
            $AllWidgetController = new AllWidgetController(12, auth()->user());
            /*   $data = $AllWidgetController->widget_router(12, 0, $data, 1, 0, 1);*/
            $data = $AllWidgetController->widget_router(12, 1, $data, 0, 0, 1, 1);
            /* $data = $AllWidgetController->widget_router(12, 2, $data, 0, 0, 1);
             $data = $AllWidgetController->widget_router(12, 3, $data, 0, 0, 1);*/
            /* $data = $AllWidgetController->widget_router(12, 4, $data, 0, 0, 1);*/
            //$data = $AllWidgetController->widget_router(12, 5, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(12, 7, $data, 0, 0, 1, 1);

            return $data;

        }
        if (request()->get('subtip') == 1) {
            /*Статистика*/
            $tip = request()->get('subtip');
            $AllWidgetController = new AllWidgetController(1, auth()->user());
            $data = $AllWidgetController->widget_router(1, 0, $data, 1, 1, 0);
            /*  $data = $AllWidgetController->widget_router(1, 1, $data, 0, 0, 0);*/

            /* $data = $AllWidgetController->widget_router(1, 3, $data, 0, 0, 0);*/
            /* $data = $AllWidgetController->widget_router(1, 4, $data, 0, 0, 0);
             $data = $AllWidgetController->widget_router(1, 2, $data, 0, 0, 0);*/
            return $data;

        }

        if (request()->get('subtip') == 19) {
            $AllWidgetController = new AllWidgetController(19, auth()->user());
            $tip = request()->get('subtip');
            $data = $AllWidgetController->widget_router($tip, 0, $data, 1, 1, 0);
            /* $data = $AllWidgetController->widget_router($tip, 1, $data, 0, 0, 0);*/
            /*   $data = $AllWidgetController->widget_router($tip, 2, $data, 0, 0, 0);
               $data = $AllWidgetController->widget_router($tip, 3, $data, 0, 0, 0);*/


            return $data;


        }

        if (request()->get('subtip') == 23) {
            $AllWidgetController = new AllWidgetController(23, auth()->user());
            $tip = request()->get('subtip');
            $data = $AllWidgetController->widget_router(12, 5, $data, 0, 0, 1);


            $w_23 = Widgets::where('tip', 23)->where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->first();
            $data['widget'] = $w_23->id;


            return $data;


        }
        if (request()->get('subtip') == 24) {
            $AllWidgetController = new AllWidgetController(24, auth()->user());
            $tip = request()->get('subtip');
            $data = $AllWidgetController->widget_router(12, 4, $data, 0, 0, 1);

            $w_23 = Widgets::where('tip', 24)->where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->first();
            $data['widget'] = $w_23->id;


            return $data;


        }
        if (request()->get('subtip') == 25) {
            $AllWidgetController = new AllWidgetController(25, auth()->user());
            $tip = request()->get('subtip');
            $data = $AllWidgetController->widget_router(12, 3, $data, 0, 0, 1);

            $w_23 = Widgets::where('tip', 25)->where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->first();
            $data['widget'] = $w_23->id;


            return $data;


        }
        if (request()->get('subtip') == 26) {
            /*Статистика*/
            $AllWidgetController = new AllWidgetController(12, auth()->user());
             /*   $data = $AllWidgetController->widget_router(12, 0, $data, 1, 0, 1);*/
            $data = $AllWidgetController->widget_router(12, 1, $data, 0, 0, 1, 1);
            /* $data = $AllWidgetController->widget_router(12, 2, $data, 0, 0, 1);
             $data = $AllWidgetController->widget_router(12, 3, $data, 0, 0, 1);*/
            /* $data = $AllWidgetController->widget_router(12, 4, $data, 0, 0, 1);*/
            //$data = $AllWidgetController->widget_router(12, 5, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(12, 7, $data, 0, 0, 1, 1);
            $data = $AllWidgetController->widget_router(12, 100, $data, 0, 0, 1, 1);
            $w_23 = Widgets::where('tip', 26)->where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->first();
            $data['widget'] = $w_23->id;


            return $data;


        }
    }
    public function get_setting_get()
    {

        $data['user'] = auth()->user();;
        $data['tabs'] = '';;
        $data['modals'] = [];;
        $data['status_checkbox'] = '';;
        $data['title'] = '';;


        /**/

        if (request()->get('subtip') == 100001) {
            $AllWidgetController = new AllWidgetController(0, auth()->user());
            $data = $AllWidgetController->widget_router(0, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(15, 5, $data, 0, 0, 1);
            return $data;
        }
        if (request()->get('subtip') == 'advertisingchannelcost') {
            $AllWidgetController = new AllWidgetController(3, auth()->user());
            $data = $AllWidgetController->widget_router(3, 1, $data, 0, 0, 0);
            return $data;
        }
        if (request()->get('subtip') == 'allreports_setting') {
            $repcont = new ReportsController();
            return $repcont->setting();



        }
        if (request()->get('subtip') == 'calltrack_setting_ajax') {

            return $this->calltrack_setting_ajax();



        }


        if (request()->get('subtip') == 'advertisingchannel') {
            $repcont = new Advertising_channelController();
            return $repcont->index();

        }


        if (request()->get('subtip') == 12) {
            /*Статистика*/
            $AllWidgetController = new AllWidgetController(12, auth()->user());
            /*   $data = $AllWidgetController->widget_router(12, 0, $data, 1, 0, 1);*/
            $data = $AllWidgetController->widget_router(12, 1, $data, 0, 0, 1, 1);
            /* $data = $AllWidgetController->widget_router(12, 2, $data, 0, 0, 1);
             $data = $AllWidgetController->widget_router(12, 3, $data, 0, 0, 1);*/
            /* $data = $AllWidgetController->widget_router(12, 4, $data, 0, 0, 1);*/
            //$data = $AllWidgetController->widget_router(12, 5, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(12, 7, $data, 0, 0, 1, 1);

            return $data;

        }
        if (request()->get('subtip') == 1) {
            /*Статистика*/
            $tip = request()->get('subtip');
            $AllWidgetController = new AllWidgetController(1, auth()->user());
            $data = $AllWidgetController->widget_router(1, 0, $data, 1, 1, 0);
            /*  $data = $AllWidgetController->widget_router(1, 1, $data, 0, 0, 0);*/

            /* $data = $AllWidgetController->widget_router(1, 3, $data, 0, 0, 0);*/
            /* $data = $AllWidgetController->widget_router(1, 4, $data, 0, 0, 0);
             $data = $AllWidgetController->widget_router(1, 2, $data, 0, 0, 0);*/
            return $data;

        }

        if (request()->get('subtip') == 19) {
            $AllWidgetController = new AllWidgetController(19, auth()->user());
            $tip = request()->get('subtip');
            $data = $AllWidgetController->widget_router($tip, 0, $data, 1, 1, 0);
            /* $data = $AllWidgetController->widget_router($tip, 1, $data, 0, 0, 0);*/
            /*   $data = $AllWidgetController->widget_router($tip, 2, $data, 0, 0, 0);
               $data = $AllWidgetController->widget_router($tip, 3, $data, 0, 0, 0);*/


            return $data;


        }

        if (request()->get('subtip') == 23) {
            $AllWidgetController = new AllWidgetController(23, auth()->user());
            $tip = request()->get('subtip');
            $data = $AllWidgetController->widget_router(12, 5, $data, 0, 0, 1);


            $w_23 = Widgets::where('tip', 23)->where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->first();
            $data['widget'] = $w_23->id;


            return $data;


        }
        if (request()->get('subtip') == 24) {
            $AllWidgetController = new AllWidgetController(24, auth()->user());
            $tip = request()->get('subtip');
            $data = $AllWidgetController->widget_router(12, 4, $data, 0, 0, 1);

            $w_23 = Widgets::where('tip', 24)->where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->first();
            $data['widget'] = $w_23->id;


            return $data;


        }
        if (request()->get('subtip') == 25) {
            $AllWidgetController = new AllWidgetController(25, auth()->user());
            $tip = request()->get('subtip');
            $data = $AllWidgetController->widget_router(12, 3, $data, 0, 0, 1);

            $w_23 = Widgets::where('tip', 25)->where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->first();
            $data['widget'] = $w_23->id;


            return $data;


        }
        if (request()->get('subtip') == 26) {
            /*Статистика*/
            $AllWidgetController = new AllWidgetController(12, auth()->user());
            /*   $data = $AllWidgetController->widget_router(12, 0, $data, 1, 0, 1);*/
            $data = $AllWidgetController->widget_router(12, 1, $data, 0, 0, 1, 1);
            /* $data = $AllWidgetController->widget_router(12, 2, $data, 0, 0, 1);
             $data = $AllWidgetController->widget_router(12, 3, $data, 0, 0, 1);*/
            /* $data = $AllWidgetController->widget_router(12, 4, $data, 0, 0, 1);*/
            //$data = $AllWidgetController->widget_router(12, 5, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(12, 7, $data, 0, 0, 1, 1);
            $data = $AllWidgetController->widget_router(12, 100, $data, 0, 0, 1, 1);
            $w_23 = Widgets::where('tip', 26)->where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->first();
            $data['widget'] = $w_23->id;


            return $data;


        }
    }
    public function calltrack_setting_ajax(){
        $my_site=Sites::where('id',auth()->user()->site)->first();
        $min=$my_site->phone_rezerv_time/60;
$widget=Widgets::where('tip',2)->where('sites_id',auth()->user()->site)->first();

$w_status='';
if($widget->status==1){
    $w_status='checked';
}
$status_checkbox=' <div class="checkbox checkbox-switchery col-md-1">
                                        <label><input type="checkbox" class="switchery widget_status_checkbox"  
                   name="status" ' . $w_status . '  data-id="' . $widget->id . '" ></label>
                                    </div>';

        $data['renders']= view('reports.setting_calltreack',compact( 'min','status_checkbox'))->render();
        return $data;
    }

    protected function form($tip, $user)
    {
        $AllWidgetController = new AllWidgetController($tip, $user);

        $data['user'] = $user;;
        $data['tabs'] = '';;
        $data['modals'] = [];;
        $data['status_checkbox'] = '';;
        $data['title'] = '';;
        $data['my_widget'][12] = Widgets::where('tip', 12)->with('w12')->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->first();
        $data['my_widget'][1] = Widgets::where('tip', 1)->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->first();
        $data['my_widget'][19] = Widgets::where('tip', 19)->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->first();
        $data['my_widget'][23] = Widgets::where('tip', 23)->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->first();

        $data['my_widget'][24] = Widgets::where('tip', 24)->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->first();
        $data['my_widget'][25] = Widgets::where('tip', 25)->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->first();
        $data['my_widget'][26] = Widgets::where('tip', 26)->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->first();
        /*Ловец лидовв*/
        /*     if ($tip == 19) {


                 $data = $AllWidgetController->widget_router($tip, 0, $data, 1, 1, 0);
                 $data = $AllWidgetController->widget_router($tip, 1, $data, 0, 0, 0);
                 $data = $AllWidgetController->widget_router($tip, 2, $data, 0, 0, 0);
                 $data = $AllWidgetController->widget_router($tip, 3, $data, 0, 0, 0);



                 return view('widgets.1widget', $data);


             }*/

        /*Колбэк*/
        /*    if ($tip == 1) {


                $data = $AllWidgetController->widget_router($tip, 0, $data, 1, 1, 0);
                $data = $AllWidgetController->widget_router($tip, 1, $data, 0, 0, 0);
                $data = $AllWidgetController->widget_router($tip, 2, $data, 0, 0, 0);
                $data = $AllWidgetController->widget_router($tip, 3, $data, 0, 0, 0);
                $data = $AllWidgetController->widget_router($tip, 4, $data, 0, 0, 0);

                return view('widgets.1widget', $data);


            }*/
        /*Коллтрекинг*/
        if ($tip == 2) {
            /*Статистика*/
            $data = $AllWidgetController->widget_router($tip, 0, $data, 0, 0, 1);
            /*Основные настройки колтрекингга*/
            $data = $AllWidgetController->widget_router($tip, 1, $data, 1, 1, 1);
            /*Номера*/
            $data = $AllWidgetController->widget_router($tip, 2, $data, 0, 0, 1);
            /*Сценарии*/
            $data = $AllWidgetController->widget_router($tip, 3, $data, 0, 0, 1);
            /*Входящие звонки*/
            $data = $AllWidgetController->widget_router($tip, 4, $data, 0, 0, 1);
            /*Промокоды*/
            //  $data = $AllWidgetController->widget_router(0, 0, $data, 0, 0, 1);

            return view('widgets.1widget', $data);


        }
        /*Коллтрекинг*/
        if ($tip == 0) {
            /*Статистика*/
            $data = $AllWidgetController->widget_router(0, 0, $data, 0, 0, 1);

            return view('widgets.1widget', $data);


        }


        /*Аналитика*/
        if ($tip == 3) {
            /*Аналиктика*/
            $data = $AllWidgetController->widget_router($tip, 0, $data, 1, 0, 1);
            $data = $AllWidgetController->widget_router(3, 1, $data, 0, 0, 1);

            return view('widgets.1widget', $data);
        }
        if ($tip == 9) {

            $data = $AllWidgetController->widget_router($tip, 0, $data, 1, 1, 1);
            $data = $AllWidgetController->widget_router($tip, 1, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router($tip, 2, $data, 0, 0, 1);

            return view('widgets.1widget', $data);


        }
        if ($tip == 10) {
            /*Интеграции*/
            $data = $AllWidgetController->widget_router(10, 0, $data, 1, 0, 1);
            $data = $AllWidgetController->widget_router(11, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(16, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(17, 0, $data, 0, 0, 1);
            // $data=$AllWidgetController->widget_router($tip,1,$data,0,0,1);
            $data = $AllWidgetController->widget_router(4, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(5, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(6, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(7, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(8, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(18, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(20, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(22, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(27, 0, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(21, 0, $data, 0, 0, 1);
            return view('widgets.1widget', $data);


        }
        if ($tip == 12) {
            /*Статистика*/

            $data = $AllWidgetController->widget_router(12, 0, $data, 1, 0, 1);
            $data = $AllWidgetController->widget_router(12, 1, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(12, 2, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(12, 3, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(12, 4, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(12, 5, $data, 0, 0, 1);
            $data = $AllWidgetController->widget_router(12, 7, $data, 0, 0, 1);


            /*Основные настройки колтрекингга*/


            return view('widgets.1widget', $data);
            /* */

        }
        if ($tip == 99) {
            /*Статистика*/
            $data = $AllWidgetController->widget_router(12, 6, $data, 0, 0, 0);


            return view('widgets.1widget', $data);
            /* */

        }
        if (!isset($data['widget'])) {
            return abort(404);
        }

        if ($data['widget']->tip == 13) {


            $data['sites'] = DB::table('sites')->where('id', $data['widget']->sites_id)->first();
            $data['widget_osn'] = DB::table('widgets_popup')->where('widget_id', $id)->where('my_company_id', $user->my_company_id)->first();
            $data['widgets_popup_templates'] = DB::table('widgets_popup_form')->where('widget_id', $id)->where('my_company_id', $user->my_company_id)->where('parent_id', 0)->get();


            return view('widgets.widget_popup', $data);
        }


    }


    public function store(Request $request)
    {
        $user = Auth::user();

        if ($request->stageId == 0) {

            return abort('404');

        } else {

            Company::where('id', $request->stageId)->where('my_company_id', $user->my_company_id)->update(['name' => $request->name]);
            $datafield = $request->datafield;
            Log::info($datafield);
            $clientAndCompany['client_id'] = $request->stageId;
            $projectId = 0;
            ProjectController:: add_datafield($datafield, $clientAndCompany, $projectId);

        }


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

    public function set_status(Request $request)
    {
        $user = Auth::user();
        $datas = Widgets::where('my_company_id', $user->my_company_id)->where('id', $request->element)->where('sites_id', $user->site)->first();
        if ($datas) {
            if (in_array($datas->tip, [23, 24, 25, 26, 12])) {

                $w_12 = Widgets::where('tip', 12)->with('w12')->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->first();

                $summ = 0;
                /* if ($datas->tip == 12) {

                     $w_12_chat = Widgets_chat::where('widget_id', $w_12->id)->first();
                     $w_12_chat->active_social = 1;
                     $w_12_chat->save();


                     if ($w_12_chat->active_chat == 1) {
                         $w_12_chat->active_chat = 0;

                     } else {
                         $w_12_chat->active_chat = 1;$summ++;
                     }
                     $w_12_chat->save();
                 }*/


                if ($datas->tip == 23) {

                    $w_12_chat = Widgets_chat::where('widget_id', $w_12->id)->first();

                    if ($w_12_chat->active_social == 1) {
                        $w_12_chat->active_social = 0;
                        $datas->status = 0;
                        $w_12_chat->save();
                        $datas->save();
                    } else {
                        $w_12_chat->active_social = 1;
                        $datas->status = 1;
                        $summ++;
                        $w_12_chat->save();
                        $datas->save();
                    }

                }
                if ($datas->tip == 24) {

                    $w_12_chat = Widgets_chat::where('widget_id', $w_12->id)->first();


                    if ($w_12_chat->active_map == 1) {
                        $w_12_chat->active_map = 0;
                        $datas->status = 0;
                        $w_12_chat->save();
                        $datas->save();
                    } else {
                        $w_12_chat->active_map = 1;
                        $datas->status = 1;
                        $summ++;
                        $w_12_chat->save();
                        $datas->save();

                    }

                    $w_12_chat->save();

                }
                if ($datas->tip == 25) {


                    $w_12_chat = Widgets_chat::where('widget_id', $w_12->id)->first();

                    if ($w_12_chat->active_formback == 1) {
                        $w_12_chat->active_formback = 0;
                        $datas->status = 0;
                        $w_12_chat->save();
                        $datas->save();
                    } else {
                        $w_12_chat->active_formback = 1;
                        $datas->status = 1;
                        $summ++;
                        $w_12_chat->save();
                        $datas->save();
                    }


                }
                if ($datas->tip == 26) {
                    $w_12_chat = Widgets_chat::where('widget_id', $w_12->id)->first();

                    if ($w_12_chat->active_chat) {
                        $w_12_chat->active_chat = false;
                        $datas->status = 0;
                        $w_12_chat->save();
                        $datas->save();
                    } else {
                        $w_12_chat->active_chat = true;
                        $datas->status = 1;
                        $summ++;
                        $w_12_chat->save();
                        $datas->save();
                    }


                }
                /* if ($datas->tip == 26) {

                     $w_12 = Widgets::where('tip', 12)->with('w12')->where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->first();
                     $w_12->status = 1;
                     $w_12->save();

                     $w_12_chat = Widgets_chat::where('widget_id', $w_12->id)->first();
                     $w_12_chat->active_formback = 1;
                     $w_12_chat->active_chat = 1;
                     $w_12_chat->active_callback = 1;
                     $w_12_chat->active_map = 1;
                     $w_12_chat->active_social = 1;
                     $w_12_chat->save();


                 }*/
                if ($summ > 0) {
                    $status = 1;
                } else {
                    $status = 0;
                }

                $w_12->status = $status;
                $w_12->save();

            } else {
 
if($datas->status==1){
    $datas->status=0;
}else{
    $datas->status=1;
} $datas->save();
            }

        }
        return $user->my_company_id;
    }

    public function formawork_2($request, $user)
    {
        $mega=Widgets::find($request->widget);
        DB::table('widget_callback_worktime')
            ->where('my_company_id', $user->my_company_id)
            ->where('sites_id', $mega->sites_id)->delete();


        $datao = [];


        $day_array = [];
        if (count($request->day) == 0) {
            return 0;

        }
        for ($i = 0; $i < count($request->day); $i++) {
            $day = [$request->day[$i]];
            if ($request->day[$i] == 'all') {
                $day = [1, 2, 3, 4, 5, 6, 7];
            }
            if ($request->day[$i] == 'all_5') {
                $day = [1, 2, 3, 4, 5];
            }
            if ($request->day[$i] == 'all_2') {
                $day = [6, 7];
            }
            for ($k = 0; $k < count($day); $k++) {

                $day_array[] = $day[$k];
                DB::table('widget_callback_worktime')->insert([
                    'day' => $day[$k],
                    'hour' => $request->hour[$i],
                    'hour_end' => $request->hour_end[$i],
                    'is_work' => 1,
                    'my_company_id' => $user->my_company_id,
                    'widget_id' => $request->widget,
                    'sites_id' => $mega->sites_id,


                ]);


            }
        }

        for ($s = 1; $s <= 7; $s++) {

            if (!in_array($s, $day_array)) {
                DB::table('widget_callback_worktime')->insert([
                    'day' => $s,
                    'hour' => 0,
                    'hour_end' => 23,
                    'is_work' => 0,
                    'my_company_id' => $user->my_company_id,
                    'widget_id' => $request->widget,
                    'sites_id' =>$mega->sites_id,


                ]);
            }


        }
        return 1;
    }

    public function clead_delete_ab($request, $user)
    {

        DB::table('widget_catch_lead_ab')->where('id', $request->id)->where('my_company_id', $user->my_company_id)->delete();

    }

    public function clead_edit_ab($request, $user)
    {


        $datas = DB::table('widget_catch_lead_ab')->where('id', $request->id)->where('my_company_id', $user->my_company_id)->first();


        return view('widgets.render.catch_lead.test_form_edit', ['info' => $datas])->render();
    }


    public function catch_lead_ad_ab($request, $user)
    {
        if ($request->id == 0) {
            $insert = DB::table('widget_catch_lead_ab')->insertGetId($request->except('catch_lead_ad_ab', 'id', 'form_action'));
        } else {

            DB::table('widget_catch_lead_ab')->where('id', $request->id)->update($request->except('catch_lead_ad_ab', 'id', 'form_action'));
            $insert = $request->id;

        }


        $data = DB::table('widget_catch_lead_ab')->where('id', $insert)->first();
        $res['status'] = 1;
        $res['data'] = view('widgets.render.catch_lead.data_tr', ['cost' => $data])->render();
        return $res;

    }

    public function formawork_1($request, $user)
    {
$mega=Widgets::find($request->widget);
        DB::table('widget_callback_worktime')
            ->where('my_company_id', $user->my_company_id)
            ->where('sites_id', $mega->sites_id)->delete();


        $datao = [];


        $day_array = [];
        if (count($request->day) == 0) {
            return 0;

        }
        for ($i = 0; $i < count($request->day); $i++) {
            $day = [$request->day[$i]];
            if ($request->day[$i] == 'all') {
                $day = [1, 2, 3, 4, 5, 6, 7];
            }
            if ($request->day[$i] == 'all_5') {
                $day = [1, 2, 3, 4, 5];
            }
            if ($request->day[$i] == 'all_2') {
                $day = [6, 7];
            }
            for ($k = 0; $k < count($day); $k++) {

                $day_array[] = $day[$k];
                DB::table('widget_callback_worktime')->insert([
                    'day' => $day[$k],
                    'hour' => $request->hour[$i],
                    'hour_end' => $request->hour_end[$i],
                    'is_work' => 1,
                    'my_company_id' => $user->my_company_id,
                    'widget_id' => $request->widget,
                    'sites_id'=>$mega->sites_id


                ]);


            }
        }

        for ($s = 1; $s <= 7; $s++) {

            if (!in_array($s, $day_array)) {
                DB::table('widget_callback_worktime')->insert([
                    'day' => $s,
                    'hour' => 0,
                    'hour_end' => 23,
                    'is_work' => 0,
                    'my_company_id' => $user->my_company_id,
                    'widget_id' => $request->widget,
                    'sites_id'=> $mega->sites_id

                ]);
            }


        }
        return 1;
    }

    public function caltrackingosnovnoe($request, $user)
    {
        /*widget_id*/
        DB::table('widget_call_track')->where('id', $request->id)->where('my_company_id', $user->my_company_id)->update([
            'element' => $request->element


        ]);
        $ids = DB::table('widget_call_track')->where('id', $request->id)->where('my_company_id', $user->my_company_id)->first();
        Widgets::where('id', $ids->widget_id)->update([
            'element' => $request->element,
            'phone_status_dinamic' => $request->phone_status_dinamic,


        ]);
        return 1;

    }

    public function caltrackingpromocod($request, $user)
    {

        $widget_promokod = DB::table('widgets_promokod')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return 0;
        }
        Widgets::where('id', $widget_promokod->widget_id)->update(['status' => $request->status]);
        DB::table('widgets_promokod')->where('id', $widget_promokod->id)->update([
            'color' => $request->color,
            'background' => $request->background,
            'position_y' => $request->position_y,
            'position_x' => $request->position_x,


        ]);
        return 1;
    }


    public function catchlidform($request, $user)
    {


        $widget_promokod = DB::table('widget_catch_lead')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return 0;
        }
        $mega=Widgets::find($widget_promokod->widget_id);
        auth()->user()->getglsetvithinstall('callbach_who_call_first_'.$mega->sites_id, $request->catch_who_call_first);
        auth()->user()->getglsetvithinstall('callbach_who_man_wooman_'.$mega->sites_id, $request->catch_who_man_wooman);
        auth()->user()->getglsetvithinstall('callback_aou_'.$mega->sites_id, $request->catch_aou);
        $Api = new ApiController();
        $Api->format_phone($request->callback_phone0);
        WidgetCallbackRouting::where('sites_id', $mega->sites_id)->delete();

        if (is_array($request->callback_tip)) {
            foreach ($request->callback_tip as $key => $val) {


                if( $request->callback_tip[$key]==0){
                    $mphone = $this->format_phone($request->phone_to_call[$key]);
                }else{
                    $mphone = $request->phone_to_call[$key];
                }


                $prov_routing=WidgetCallbackRouting::where('sites_id', $mega->sites_id)
                    ->where('callback_tip', $request->callback_tip[$key])
                    ->where('phone_to_call',$mphone)->first();
                if(!$prov_routing) {


                    $rout = new  WidgetCallbackRouting();
                    $rout->widget_id = $widget_promokod->widget_id;
                    $rout->sites_id = $mega->sites_id;
                    $rout->callback_tip = $request->callback_tip[$key];
                    $rout->phone_to_call = $mphone;
                    $rout->status = $request->status[$key];
                    $rout->type = 19;

                    $rout->save();
                }

            }


        }
        DB::table('widget_catch_lead')->where('id', $widget_promokod->id)->update([
            'callback_timer' => $request->callback_timer,
            'everyday' => $request->everyday,
        ]);


        $new_w=Widgets::where('tip',1) ->where('sites_id',$mega->sites_id)->first();
        $data['widget_vk_callback']= DB::table('widget_callback')->where('widget_id',$new_w->id)->update([
          'dop_form_email_status'=>$request->dop_form_email_status,
          'dop_form_email'=>$request->dop_form_email,
        ]);


        return 1;
    }
public function chat_mess_rules($request,$user){

    //WidgetsChatMessRule::where('widget_id', $request->widget)->delete();
    if(!$request->has('message')){

        return 0;
    }
    foreach ($request->message as $key => $val) {

       $prov_mess=WidgetsChatMessRule::find($key);
if(!$prov_mess){
    $prov_mess=new WidgetsChatMessRule();

}
        $prov_mess->widget_id=$request->widget;
        $prov_mess->status=$request->status[$key];
        $prov_mess->message=$request->message[$key];
$prov_mess->save();
WidgetsChatMessRuleTable::where('rules_id',$prov_mess->id)->delete();
/*`id`, `rules_id`, `condition`, `time`, `rules_condition_str`, `rules_condition`, `created_at`, `updated_at`*/
        if (is_array($request->condition)) {
            foreach ($request->condition as $key1 => $val1) {
                $rout = new  WidgetsChatMessRuleTable();
                $rout->rules_id = $prov_mess->id;

                $rout->time = $request->time[$key1];
                $rout->condition = $request->condition[$key1];
                $rout->rules_condition_str = $request->rules_condition_str[$key1];
           if(isset( $request->rules_condition[$key1])) {
               $rout->rules_condition = $request->rules_condition[$key1];
           }

                $rout->save();


            }


        }









    }

    if (is_array($request->condition)) {
        foreach ($request->condition as $key => $val) {
            $rout = new  WidgetsChatUrlOperatorNew();
            $rout->widget_id = $request->widget;

            $rout->operator_id = $request->operator[$key];
            $rout->condition = $request->condition[$key];
            $rout->str = $request->str[$key];


            $rout->save();


        }


    }
    return 1;



}
    public function  chat_form_operator_url($request, $user){

        WidgetsChatUrlOperatorNew::where('widget_id', $request->widget)->delete();
        if (is_array($request->condition)) {
            foreach ($request->condition as $key => $val) {
                $rout = new  WidgetsChatUrlOperatorNew();
                $rout->widget_id = $request->widget;

                $rout->operator_id = $request->operator[$key];
                $rout->condition = $request->condition[$key];
                $rout->str = $request->str[$key];


                $rout->save();


            }


        }
        return 1;



}

    public function callbackosnovnoe($request, $user)
    {
        $user = Auth::user();
        $widget_promokod = DB::table('widget_callback')->where('my_company_id', Auth::user()->my_company_id)->where('id', $request->id)->first();

$mega=Widgets::find($widget_promokod->widget_id);
        if (!$widget_promokod) {
            return 0;
        }

        auth()->user()->getglsetvithinstall('callback_aou_'.$mega->sites_id, $request->catch_aou);
        auth()->user()->getglsetvithinstall('callbach_who_call_first_'.$mega->sites_id, $request->catch_who_call_first);
        auth()->user()->getglsetvithinstall('callbach_who_man_wooman_'.$mega->sites_id, $request->catch_who_man_wooman);

      /*  CompanyDefaultSetting::where('my_company_id', $user->my_company_id)->where('skey', 'callbach_who_call_first')->update([
            'value' => $request->catch_who_call_first
        ]);
        CompanyDefaultSetting::where('my_company_id', $user->my_company_id)->where('skey', 'callbach_who_man_wooman')->update([
            'value' => $request->catch_who_man_wooman
        ]);*/


$callback_form_form=Widgets::where('tip',3) ->where('sites_id', $mega->sites_id)->first();


            $data['create_lead']=$callback_form_form->params['create_lead'];
            $data['callback']=$request->callback_form_form;

            $callback_form_form->params=$data;

            $callback_form_form->save();


        $Api = new ApiController();
        DB::table('widget_callback')->where('id', $widget_promokod->id)->update([
            /* 'callback_phone0' =>$Api->format_phone( $request->callback_phone0),
             'callback_phone1' => $request->callback_phone1,
             'callback_phone2' => $request->callback_phone2,
             'callback_phonepassword' => $request->callback_phonepassword,*/
            'callback_timer' => $request->callback_timer,
            /*   'callback_tip' => $request->callback_tip,*/
            /* 'active_form' => $request->active_form,*/
            'dop_form' => $request->dop_form,
            'dop_form_email' => $request->dop_form_email,
            'dop_form_email_status' => $request->dop_form_email_status,
            'active_osn' => 1,
            /* 'form_callback' => $request->form_callback,*/
            'timer' => $request->timer,
            'social_on' => $request->social_on,


        ]);
        $data['widget_chat_call']=Widgets::where('tip',12) ->where('sites_id', $mega->sites_id)->first();

if($data['widget_chat_call']){

    $rf=DB::table('widgets_chat')->where('widget_id',   $data['widget_chat_call']->id)->update([

        'callback_start_text'=>$request->callback_start_text
    ]);

/*    $rf->callback_start_text=$request->callback_start_text;
    $data['widget_chat_call'] ->save();*/

}


        WidgetCallbackRouting::where('sites_id', $mega->sites_id)->delete();
        if (is_array($request->callback_tip)) {
            foreach ($request->callback_tip as $key => $val) {

                if( $request->callback_tip[$key]==0){
                   $mphone = $this->format_phone($request->phone_to_call[$key]);
                }else{
                    $mphone = $request->phone_to_call[$key];
                }


                $prov_routing=WidgetCallbackRouting::where('sites_id', $mega->sites_id)
                    ->where('callback_tip', $request->callback_tip[$key])
                    ->where('phone_to_call',$mphone)->first();
                if(!$prov_routing) {


                    $rout = new  WidgetCallbackRouting();
                    $rout->widget_id = $widget_promokod->widget_id;
                    $rout->sites_id = $mega->sites_id;
                    $rout->callback_tip = $request->callback_tip[$key];
                    if ($request->callback_tip[$key] == 0) {
                        $rout->phone_to_call = $this->format_phone($request->phone_to_call[$key]);
                    } else {
                        $rout->phone_to_call = $request->phone_to_call[$key];
                    }

                    $rout->status = $request->status[$key];
                    $rout->type = 1;

                    $rout->save();

                }
            }


        }
        return 1;


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
    public function emailtrackingsetting($request, $user)
    {

        $widget_promokod = DB::table('widgets_email')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }


        DB::table('widgets_email')->where('id', $widget_promokod->id)->update(
            [
                'email' => $request->email,
                'server' => $request->get('server'),
                'login' => $request->login,
                'password' => $request->password,
                'element' => $request->element,
                'url' => $request->url,
                'updated_at' => date('Y-m-d')

            ]);
        return 1;
    }

    public function integrationgacall($request, $user)
    {
        $widget_promokod = Widgets::find($request->id);
        if (!$widget_promokod) {
            return '0111';
        }
        $widget_promokod->element = $request->element;
        $widget_promokod->save();


        return 1;
    }

    public function integrationmetrika($request, $user)
    {

        $widget_promokod = DB::table('widget_metrika')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }


        DB::table('widget_metrika')->where('id', $widget_promokod->id)->update(
            [
                'counter' => $request->radiocounter,


            ]);


        return 1;
    }

    public function integrationriostat($request, $user)
    {

        $widget_promokod = DB::table('widgets_roistar')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }


        DB::table('widgets_roistar')->where('id', $widget_promokod->id)->update(
            [
                'server1' => $request->server1,


            ]);


        return 1;
    }


    public function integrationadwords($request, $user)
    {

        $widget_promokod = DB::table('widget_adwords')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }


        $AdwordsController = new AdwordsController($this->adWordsService, $this->authorizationService);
        if ($request->token != $widget_promokod->token) {
            $AdwordsController->GetRefrech($request->token, $widget_promokod, $request->clientAdId);
        }
        $widget_promokod = DB::table('widget_adwords')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        return $get_ad_company = $AdwordsController->getCompanyWithoutReport($request->clientAdId, $widget_promokod, $request->radiocounter);


        DB::table('metrika_adwords_company')->where('widget_direct_id', $widget_promokod->id)->update(['status' => 0]);


        for ($i = 0; $i < count($request->radiocounter); $i++) {
            DB::table('metrika_direct_company')->where('widget_direct_id', $widget_promokod->id)->where('id', $request->radiocounter[$i])->update(['status' => 1]);

        }


        return 1;
    }

    public function integrationdirect($request, $user)
    {

        $widget_promokod = DB::table('widget_direct')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        DB::table('widget_direct')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->update(['email' => $request->email]);

        DB::table('metrika_direct_company')->where('widget_direct_id', $widget_promokod->id)->update(['status' => 0]);


        for ($i = 0; $i < count($request->radiocounter); $i++) {
            DB::table('metrika_direct_company')->where('widget_direct_id', $widget_promokod->id)->where('id', $request->radiocounter[$i])->update(['status' => 1]);

        }

        $companis = DB::table('metrika_direct_company')->where('widget_direct_id', $widget_promokod->id)->where('status', 1)->pluck('company')->toArray();
        $token = $widget_promokod->token;
        if($request->has('update_utm')) {

            $direct_utms = new DirectApiEditController();
            $direct_utms->index($companis, $token, $widget_promokod->email);
        }
        return 1;
    }


    public function formintegrationtelegram($request, $user)
    {
        $user = Auth::user();
        $widget_promokod = DB::table('widget_telegram')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '1';
        }
        $widget = Widgets::where('id', $widget_promokod->widget_id)->first();
        DB::table('widget_telegram')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);


        // https://api.ok.ru/graph/me/subscribe?access_token=tkn18YdUJZe:CQABPOJKAKEKEKEKE
        $OkApiController = new TelegramController();
        $otvet = $OkApiController->set_webhook($request->apikey, $widget->sites_id);
        $arrayotvet = json_decode($otvet);

        if (isset($otvet->ok)) {
            return 1;
        } else {
            if (isset($arrayotvet->ok)) {
                return 1;
            } else {
                return $otvet;
            }

            return $otvet;
        }

    }

    public function formintegrationfb($request, $user)
    {
        $widget_promokod = DB::table('widget_fb')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }

        DB::table('widget_fb')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);

        return '1';
    }

    public function formintegrationok($request, $user)
    {
        $widget_promokod = DB::table('widget_ok')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '1';
        }

        DB::table('widget_ok')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);

        $widget = Widgets::where('id', $widget_promokod->widget_id)->first();
        // https://api.ok.ru/graph/me/subscribe?access_token=tkn18YdUJZe:CQABPOJKAKEKEKEKE
        $OkApiController = new OkApiController();
        $otvet = $OkApiController->set_webhook($request->apikey, $widget->sites_id);
        $arrayotvet = json_decode($otvet);

        if ($otvet = '{"success":true}') {
            return 1;
        } else {
            return 0;
        }
    }

    public function formintegrationviber($request, $user)
    {

        $widget_promokod = DB::table('widget_viber')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '1';
        }
        $widget = Widgets::where('id', $widget_promokod->widget_id)->first();
        DB::table('widget_viber')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);

        $site = DB::table('sites')->where('id', $widget->sites_id)->first();
        $ViberApiController = new ViberApiController();
        return $ViberApiController->registerwebhook($site->hash, $request->apikey);

    }

    public function formintegrationvk($request, $user)
    {
        $widget_promokod = DB::table('widget_vk')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        $widget = Widgets::where('id', $widget_promokod->widget_id)->first();
        DB::table('widget_vk')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,
            'groupid' => $request->groupid,
            'confirmation' => $request->confirmation,


        ]);


        return  VkApiController::safe_groups($request->pages);


    }

    public function get_b24_data_safe_default(Request $request)
    {

        $user = Auth::user();

        DB::table('widgets_bitrix24')->where('my_company_id', Auth::user()->my_company_id)->update([

            'status_id' => $request->id_status
        ]);

        return 1;

    }

    public function get_amo_data_safe_default(Request $request)
    {

        $user = Auth::user();

        DB::table('widgets_amocrm')->where('my_company_id', Auth::user()->my_company_id)->update([

            'status_id' => $request->id_status
        ]);

        return 1;

    }

    public function get_amo_data_safe_default_user(Request $request)
    {

        $user = Auth::user();

        DB::table('widgets_amocrm')->where('my_company_id', Auth::user()->my_company_id)->update([

            'user_amo_id' => $request->id_status
        ]);

        return 1;

    }

    public function get_amo_data_safe(Request $request)
    {

        $user = Auth::user();

        DB::table('widgets_amocrm_status')->where('my_company_id', Auth::user()->my_company_id)->where('id', $request->id_status)->update([

            'stages_id' => $request->id_stage
        ]);

        return 1;

    }

    public function get_b24_data_safe(Request $request)
    {

        $user = Auth::user();

        DB::table('widgets_bitrix24_status')->where('my_company_id', Auth::user()->my_company_id)->where('id', $request->id_status)->update([

            'stages_id' => $request->id_stage
        ]);

        return 1;

    }

    public function get_ststus_lead_bt24($type, $type_ru)
    {
        $user = Auth::user();
        $widget_promokod = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 16)->first();

        if (!$widget_promokod) {
            return '';
        }
        $widget_promokod2 = DB::table('widgets_bitrix24')->where('my_company_id', $user->my_company_id)->where('widget_id', $widget_promokod->id)->first();
        $statusis = DB::table('widgets_bitrix24_status')->where('my_company_id', Auth::user()->my_company_id)->where('widget_crm_id', $widget_promokod2->id)->where('type', $type)->get();

        $stages_obg = Stage::where('my_company_id', $user->my_company_id)->get();

        $stage_arr = [];
        foreach ($stages_obg as $item) {
            $stage_arr[$item->id] = $item->name;


        }

        $atastat = '';
        $atastat .= '<option value="0">Поумолчанию</option>';
        foreach ($statusis as $sr) {

            if ($widget_promokod2->status_id == $sr->status_id) {
                $st = 'selected';
            } else {
                $st = '';
            }

            $atastat .= '<option value="' . $sr->status_id . '" ' . $st . '>  ' . $sr->status_name . '</option>';

        }


        $text = '


<table class="table table-bordered">
<tr>
<td>Статус поумолчанию ' . $type_ru . '</td>
<td>
<select   class="stsiddefault_b24 form-control">
' . $atastat . '
</select></td>
</tr>
<tr>
<td>Bitrix24</td>
<td>Neiros</td>


</tr>';

        foreach ($statusis as $statusi) {

            $status_text = '<select data-id="' . $statusi->id . '" name="xxx' . $statusi->id . '"class="stsid_b24 form-control">
     <option value="0">Неразобранное</option>';
            foreach ($stages_obg as $item) {

                $sel = '';
                if ($item->id == $statusi->stages_id) {
                    $sel = 'selected';
                }


                $stage_arr[$item->id] = $item->name;
                $status_text .= ' <option value="' . $item->id . '" ' . $sel . '> ' . $item->name . '  </option>';

            }
            $status_text .= '</select>';
            $text .= '<tr>
<td>' . $statusi->status_name . '</td>
<td>' . $status_text . '</td>
</tr>';
        }
        $text .= '</table>';


        return $text;
    }

    public function get_b24_data(Request $request)
    {

        $text = $this->get_ststus_lead_bt24('lead', 'Лид');
        $text .= $this->get_ststus_lead_bt24('crm', 'Сделка');
        return $text;
    }

    public function get_amo_data(Request $request)
    {

        $user = Auth::user();
        $widget_promokod = DB::table('widgets_amocrm')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '';
        }
        $statusis = DB::table('widgets_amocrm_status')->where('my_company_id', Auth::user()->my_company_id)->where('widget_crm_id', $widget_promokod->id)->get();

        $stages_obg = Stage::where('my_company_id', $user->my_company_id)->get();

        $stage_arr = [];
        foreach ($stages_obg as $item) {
            $stage_arr[$item->id] = $item->name;


        }

        $atastat = '';
        $atastat .= '<option value="0">Поумолчанию</option>';
        foreach ($statusis as $sr) {

            if ($widget_promokod->status_id == $sr->status_id) {
                $st = 'selected';
            } else {
                $st = '';
            }

            $atastat .= '<option value="' . $sr->status_id . '" ' . $st . '>' . $sr->status_name . '</option>';

        }

        $amo_users = DB::table('widgets_amocrm_users')->where('my_company_id', Auth::user()->my_company_id)->where('widget_crm_id', $widget_promokod->id)->get();
        $amus = '<select   class="stsid_amous form-control">
     <option value="0">Выбрать пользователя</option>';;
        foreach ($amo_users as $item) {

            if ($widget_promokod->user_amo_id == $item->user_id) {
                $st = 'selected';
            } else {
                $st = '';
            }
            $amus .= '<option value="' . $item->user_id . '" ' . $st . '>' . $item->name . '</option>';


        }
        $amus .= '</select>';


        $text = '


<table class="table table-bordered">
<tr>
<td>Пользователь для сделок поумолчанию</td>
<td>
' . $amus . '</td>
</tr>
<tr>
<td>Статус поумолчанию</td>
<td>
<select   class="stsiddefault form-control">
' . $atastat . '
</select></td>
</tr>
<tr>
<td>Amo</td>
<td>Neiros</td>


</tr>';

        foreach ($statusis as $statusi) {

            $status_text = '<select data-id="' . $statusi->id . '" class="stsid form-control">
     <option value="0">Неразобранное</option>';
            foreach ($stages_obg as $item) {

                $sel = '';
                if ($item->id == $statusi->stages_id) {
                    $sel = 'selected';
                }


                $stage_arr[$item->id] = $item->name;
                $status_text .= ' <option value="' . $item->id . '" ' . $sel . '>' . $item->name . '</option>';

            }
            $status_text .= '</select>';
            $text .= '<tr>
<td>' . $statusi->status_name . '</td>
<td>' . $status_text . '</td>
</tr>';
        }
        $text .= '</table>';
        return $text;

    }

    public function safe_widget(Request $request)
    {


        $user = Auth::user();
        switch ($request->form_action) {


            case 'catch_lead_ad_ab':

                return $this->catch_lead_ad_ab($request, $user);
                break;
            case 'clead_delete_ab':

                return $this->clead_delete_ab($request, $user);
                break;
            case 'clead_edit_ab':

                return $this->clead_edit_ab($request, $user);
                break;


            case 'formawork_1':

                return $this->formawork_1($request, $user);
                break;
            case 'formawork_2':

                return $this->formawork_2($request, $user);
                break;

            case 'caltrackingosnovnoe':

                return $this->caltrackingosnovnoe($request, $user);

                break;
            case 'allreports_setting':

                $rep = new ReportsController();
                return $rep->seve($request, $user);

                break;
            case 'calltrack_setting_ajax':


                $min=$request->phone_rezerv_time*60;
                $site=Sites::find(auth()->user()->site);
                $site->phone_rezerv_time=$min;
                $site->save();
return 1;
                break;

            case 'caltrackingpromocod':

                return $this->caltrackingpromocod($request, $user);

                break;

            case 'callbackosnovnoe':
                return $this->callbackosnovnoe($request, $user);

                break;
                case 'chat_form_operator_url':
                return $this->chat_form_operator_url($request, $user);

                break;
                case 'chat_mess_rules':
                return $this->chat_mess_rules($request, $user);

                break;
            case 'catchlidform':
                return $this->catchlidform($request, $user);

                break;
            case 'emailtrackingsetting':
                return $this->emailtrackingsetting($request, $user);

                break;
            case 'integrationmetrika':
                return $this->integrationmetrika($request, $user);

                break;
            case 'integrationgacall':
                return $this->integrationgacall($request, $user);

                break;
            case 'integrationdirect':
                return $this->integrationdirect($request, $user);

                break;
            case 'integrationadwords':
                return $this->integrationadwords($request, $user);

                break;
            case 'integrationriostat':
                return $this->integrationriostat($request, $user);

                break;


            case 'add_adversinchannael':
                $m = new Advertising_channelController();
                return $m->safes();


            case 'formintegrationtelegram':
                return $this->formintegrationtelegram($request, $user);

                break;
            case 'formintegrationfb':
                return $this->formintegrationfb($request, $user);

                break;
            case 'formintegrationok':
                return $this->formintegrationok($request, $user);

                break;
            case 'formintegrationviber':
                return $this->formintegrationviber($request, $user);

                break;

            case 'formintegrationvk':
                return $this->formintegrationvk($request, $user);

                break;
            case 'wchat_osn_1':

                return $this->wchat_osn_1($request, $user);

                break;
            case 'wchat_osn_2':

                return $this->wchat_osn_2($request, $user);

                break;
            case 'wchat_osn_3':

                return $this->wchat_osn_3($request, $user);

                break;
            case 'wchat_osn_4':

                return $this->wchat_osn_4($request, $user);

                break;
            case 'wchat_osn_5':

                return $this->wchat_osn_5($request, $user);

                break;
            case 'wchat_osn_6':

                return $this->wchat_osn_6($request, $user);

                break;
            case 'safebitrix24':

                return $this->safebitrix24($request, $user);

                break;
            case 'safeamocrm24':

                return $this->safeamocrm24($request, $user);

                break;


        }
        return '';


        $widget = Widgets::where('my_company_id', $user->my_company_id)->where('id', $request->widget_id)->first();
        if (!$widget) {
            return '0';
        }
        if ($widget->tip == 0) {
            return $this->update_tip_0($widget, $user, $request);
        }
        if ($widget->tip == 1) {

            return $this->update_tip_1($widget, $user, $request);
        }
        if ($widget->tip == 4) {

            return $this->update_tip_4($widget, $user, $request);
        }
        if ($widget->tip == 5) {

            return $this->update_tip_5($widget, $user, $request);
        }
        if ($widget->tip == 6) {

            return $this->update_tip_6($widget, $user, $request);
        }
        if ($widget->tip == 7) {

            return $this->update_tip_7($widget, $user, $request);
        }


        if ($widget->tip == 8) {

            return $this->update_tip_8($widget, $user, $request);
        }
        if ($widget->tip == 9) {

            return $this->update_tip_9($widget, $user, $request);
        }
        if ($widget->tip == 10) {

            return $this->update_tip_10($widget, $user, $request);
        }
        if ($widget->tip == 12) {

            return $this->update_tip_12($widget, $user, $request);
        }
        if ($widget->tip == 11) {

            return $this->update_tip_11($widget, $user, $request);
        }
        if ($widget->tip == 14) {

            return $this->update_tip_14($widget, $user, $request);
        }
    }

    /*callback_phone0	32423423423
callback_phone1
callback_phone2	5123114
callback_phonepassword
callback_timer	324
callback_tip	0*/

    public function safeamocrm24($request, $user)
    {
        $widget_promokod = DB::table('widgets_amocrm')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }


        $data['server'] = $request->server1;
        $data['login'] = $request->login;
        $data['password'] = $request->password;
        $data['id'] = $widget_promokod->id;

        $server = str_replace('http://', '', $request->server1);
        $server = str_replace('https://', '', $server);

        DB::table('widgets_amocrm')->where('id', $widget_promokod->id)->update(
            [
                'server1' => $server,
                'login' => $request->login,
                'password' => $request->password,


            ]);
        $Amo = new AmoCrmApiController();
        return $Amo->get_connect($data);


    }

    public function safebitrix24($request, $user)
    {
        $widget_promokod = DB::table('widgets_bitrix24')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        DB::table('widgets_bitrix24')->where('id', $widget_promokod->id)->update(
            [
                'server1' => $request->server1,
                'login' => $request->login,
                'password' => $request->password,
                'APP_ID' => $request->APP_ID,
                'APP_SECRET_CODE' => $request->APP_SECRET_CODE,


            ]);
        return 1;
    }

    public function wchat_osn_6($request, $user)
    {

        $widget_promokod = DB::table('widgets_chat')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }/*form_action	wchat_osn_6
id	3
social_fb	0
social_fb_url	345
social_ok	0
social_ok_url	345
social_tele	0
social_tele_url	345
social_viber	0
social_viber_url	345
social_vk	0
social_vk_url	345r*/

        DB::table('widgets_chat')->where('id', $widget_promokod->id)->update(
            [
                'social_vk_url' => $request->social_vk_url,
                'social_vk' => $request->social_vk,
                'social_viber' => $request->social_viber,
                'social_viber_url' => $request->social_viber_url,
                'social_tele' => $request->social_tele,
                'social_tele_url' => $request->social_tele_url,
                'social_ok_url' => $request->social_ok_url,
                'social_ok' => $request->social_ok,
                'social_fb' => $request->social_fb,
                'social_fb_url' => $request->social_fb_url,


            ]);


        return 1;


    }

    public function wchat_osn_5($request, $user)
    {

        $widget_promokod = DB::table('widgets_chat')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }/*form_action	wchat_osn_4
formback_email	wer
formback_tema	wer*/

        DB::table('widgets_chat')->where('id', $widget_promokod->id)->update(
            [
                'map_html' => $request->map_html,


            ]);


        return 1;


    }

    public function wchat_osn_4($request, $user)
    {

        $widget_promokod = DB::table('widgets_chat')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }/*form_action	wchat_osn_4
formback_email	wer
formback_tema	wer*/

        DB::table('widgets_chat')->where('id', $widget_promokod->id)->update(
            [
                'formback_email' => $request->formback_email,
                'formback_tema' => $request->formback_tema,

                'callback_end_text' => $request->callback_end_text,
                'formback_pole_name' => $request->formback_pole_name,
                'formback_pole_email' => $request->formback_pole_email,
                'formback_pole_tema' => $request->formback_pole_tema,
                'formback_name_rec' => $request->formback_name_rec,
                'formback_email_rec' => $request->formback_email_rec,
                'formback_tema_rec' => $request->formback_tema_rec,

            ]);


        return 1;


    }

    public function wchat_osn_3($request, $user)
    {

        $widget_promokod = DB::table('widgets_chat')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }

        DB::table('widgets_chat')->where('id', $widget_promokod->id)->update(
            [
                'callback_phone0' => $request->callback_phone0,
                'callback_phone1' => $request->callback_phone1,
                'callback_phone2' => $request->callback_phone2,
                'callback_phonepassword' => $request->callback_phonepassword,
                'callback_timer' => $request->callback_timer,
                'callback_tip' => $request->callback_tip,
                'callback_start_text' => $request->callback_start_text,


            ]);


        return 1;


    }

    public function wchat_osn_2($request, $user)
    {

        $widget_promokod = DB::table('widgets_chat')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }

        DB::table('widgets_chat')->where('id', $widget_promokod->id)->update(
            [
                'email' => $request->email,
                'first_message' => $request->first_message,
                'job' => $request->job,
                'logo' => $request->logo,
                'operator_name' => $request->operator_name,
                'timer' => $request->timer,
                'create_project' => $request->create_project,
                'phone' => $request->phone,


            ]);


        return 1;


    }

    public function wchat_osn_1($request, $user)
    {

        $widget_promokod = DB::table('widgets_chat')->where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget_promokod->widget_id)->update(['status' => $request->status]);

        DB::table('widgets_chat')->where('id', $widget_promokod->id)->update(
            [
                'active_chat' => $request->active_chat,
                'active_callback' => $request->active_callback,
                'active_formback' => $request->active_formback,
                'active_map' => $request->active_map,
                'active_social' => $request->active_social,
                'timer' => $request->timer,
                'phone' => $request->phone,
                'create_project' => $request->create_project,

            ]);


        return 1;


    }

    public function update_tip_14($widget, $user, $request)
    {
        $widget_promokod = DB::table('widgets_catcher_bots')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);

        DB::table('widgets_catcher_bots')->where('id', $widget_promokod->id)->update(
            [
                'metrika_counter' => $request->radiocounter,
                'metrika_token' => $request->metrika_token,
                'amount_url' => $request->amount_url,
                'class_ul' => $request->class_ul,
                'id_replace' => $request->id_replace,


            ]);


        return 1;

    }

    public function update_tip_12($widget, $user, $request)
    {


    }

    public function update_tip_11($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_direct')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('metrika_direct_company')->where('widget_direct_id', $widget_promokod->id)->update(['status' => 0]);


        for ($i = 0; $i < count($request->counter); $i++) {
            DB::table('metrika_direct_company')->where('widget_direct_id', $widget_promokod->id)->where('id', $request->counter[$i])->update(['status' => 1]);

        }


        return 1;

    }

    public function update_tip_10($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_metrika')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);

        DB::table('widget_metrika')->where('id', $widget_promokod->id)->update(
            [
                'counter' => $request->counter,


            ]);


        return 1;

    }

    public function update_tip_9($widget, $user, $request)
    {
        $widget_promokod = DB::table('widgets_email')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);

        DB::table('widgets_email')->where('id', $widget_promokod->id)->update(
            [
                'email' => $request->email,
                'server' => $request->server1,
                'login' => $request->login,
                'password' => $request->password,
                'element' => $request->element,
                'url' => $request->url

            ]);


        return 1;

    }

    public function update_tip_1($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_callback')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status, 'email' => $request->email]);


        $tags_array = explode(',', $request->tags);
        TagsController::addtag_widget($tags_array, $widget->id);
        return 1;

    }


    public function update_tip_4($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_vk')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widget_vk')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,
            'groupid' => $request->groupid,
            'confirmation' => $request->confirmation,


        ]);
        return 1;
    }

    public function update_tip_5($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_viber')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '1';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widget_viber')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);

        $site = DB::table('sites')->where('id', $widget->sites_id)->first();
        $ViberApiController = new ViberApiController();
        return $ViberApiController->registerwebhook($site->hash, $request->apikey);

    }

    public function update_tip_6($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_ok')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '1';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widget_ok')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);


        // https://api.ok.ru/graph/me/subscribe?access_token=tkn18YdUJZe:CQABPOJKAKEKEKEKE
        $OkApiController = new OkApiController();
        $otvet = $OkApiController->set_webhook($request->apikey, $widget->sites_id);
        $arrayotvet = json_decode($otvet);
        if (isset($arrayotvet->success)) {
            return 1;
        } else {
            return $otvet;
        }
        //return 1;
        /*  $site=DB::table('sites')->where('id',$widget->sites_id)->first();
          $ViberApiController=new ViberApiController();
          return $ViberApiController->registerwebhook($site->hash,$request->apikey);*/

    }

    public function update_tip_8($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_telegram')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '1';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widget_telegram')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);


        // https://api.ok.ru/graph/me/subscribe?access_token=tkn18YdUJZe:CQABPOJKAKEKEKEKE
        $OkApiController = new TelegramController();
        $otvet = $OkApiController->set_webhook($request->apikey, $widget->sites_id);
        $arrayotvet = json_decode($otvet);
        if (isset($arrayotvet->success)) {
            return 1;
        } else {
            return $otvet;
        }
        //return 1;
        /*  $site=DB::table('sites')->where('id',$widget->sites_id)->first();
          $ViberApiController=new ViberApiController();
          return $ViberApiController->registerwebhook($site->hash,$request->apikey);*/

    }

    public function update_tip_7($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_fb')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widget_fb')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);

        return 1;
    }


    public function addphone(Request $request)
    {

        $aster = new AsteriskController();
        $request->widget_call_track = $request->id;
        return $aster->addphone_in($request);
    }


    public function deletephone(Request $request)
    {
        $user = Auth::user();
        $RunexisController = new RunexisController();


        $numbers[] = substr($request->number, 1);

        $RunexisController->deleteNumber($numbers);
        $Asterisk = new AsteriskController();

        $Asterisk->deletete_number($request->number);

        DB::table('widgets_phone')->where('my_company_id', $user->my_company_id)->where('input', $request->number)->where('id', $request->ids)->delete();
        return '';

    }

    public function get_date_grafic()
    {
        $user = Auth::user();
        $this->user = $user;  /*    private $stat_start_date;
            private $stat_end_date;*/

        $this->stat_start_date = date('2017-01-01 00.00.00');;
        $this->stat_end_date = date('2050-01-01 23:59:59');;
        if (strlen($this->user->stat_start_date) < 2) {
            $this->stat_start_date = date('2017-01-01 00.00.00');
        } else {
            $this->stat_start_date = date('Y-m-d 00.00.01', strtotime($this->user->stat_start_date));

        }
        if (strlen($this->stat_end_date) < 2) {
            $this->stat_end_date = date('2050-01-01 23:59:59');
        } else {
            $this->stat_end_date = date('Y-m-d 23:59:59', strtotime($this->user->stat_end_date));
        }

    }
}
