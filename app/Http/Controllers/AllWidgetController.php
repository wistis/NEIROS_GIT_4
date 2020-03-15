<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Setting\WchatController;
use App\Models\Chat\WidgetsChatMessRule;
use App\Models\Chat\WidgetsChatUrlOperatorNew;
use App\Models\Fb\WidgetFbPage;
use App\Models\Servies\UsersGroup;
use App\Models\WidgetCanal;
use App\Models\Widgets\WidgetCallbackRouting;
use App\Sites;
use App\User;
use App\Widgets;
use Auth;
use DB;
use Log;
use App\Http\Controllers\FbApi\FbController;
class AllWidgetController extends Controller
{

    protected $widget;
    protected $all_widget;
    protected $user;
    protected $stat_start_date;
    protected $stat_end_date;
protected $for_view=null;
    public function __construct($tip, $user)
    {
        $this->user = $user;
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', $tip)->first();


    }


    /*Колбэк*/

    public function widget_router($tip, $subtip, $datainput, $tabs, $switch, $status,$for_view=null)
    {
        $this->for_view=$for_view;

        $this->all_widget = DB::table('all_widget')->where('tip', $tip)->where('subtip', $subtip)->first();
        switch ($tip . $subtip) {
            case 190:
                return $this->widget_190($datainput, $tabs, $switch, $status);
                break;
            case 191:
                return $this->widget_191($datainput, $tabs, $switch, $status);
                break;
            case 192:
                return $this->widget_192($datainput, $tabs, $switch, $status);
                break;
            case 193:
                return $this->widget_193($datainput, $tabs, $switch, $status);
                break;

            case 10:
                return $this->widget_1($datainput, $tabs, $switch, $status);
                break;
            case 11:
                return $this->widget_11($datainput, $tabs, $switch, $status);
                break;
            case 12:
                return $this->widget_12($datainput, $tabs, $switch, $status);
                break;

            case 13:
                return $this->widget_13($datainput, $tabs, $switch, $status);
                break;
            case 14:
                return $this->widget_14($datainput, $tabs, $switch, $status);
                break;
            case 20:
                return $this->widget_20($datainput, $tabs, $switch, $status);
                break;
            case 21:
                return $this->widget_21($datainput, $tabs, $switch, $status);
                break;
            case 22:
                return $this->widget_22($datainput, $tabs, $switch, $status);
                break;
            case 23:
                return $this->widget_23($datainput, $tabs, $switch, $status);
                break;
            case 24:
                return $this->widget_24($datainput, $tabs, $switch, $status);
                break;
            case '00':
                return $this->widget_00($datainput, $tabs, $switch, $status);
                break;
            case 30:
                return $this->widget_30($datainput, $tabs, $switch, $status);
                break;
            case 31:
                return $this->widget_31($datainput, $tabs, $switch, $status);
                break;
            case 90:
                return $this->widget_90($datainput, $tabs, $switch, $status);
                break;
            case 91:
                return $this->widget_91($datainput, $tabs, $switch, $status);
                break;
            case 92:
                return $this->widget_92($datainput, $tabs, $switch, $status);
                break;
            case 100:
                return $this->widget_100($datainput, $tabs, $switch, $status);
                break;
            case 170:
                return $this->widget_170($datainput, $tabs, $switch, $status);
                break;
            case 180:
                return $this->widget_180($datainput, $tabs, $switch, $status);
                break;
            case 220:
                return $this->widget_220($datainput, $tabs, $switch, $status);
                break;
            case 270:
                return $this->widget_270($datainput, $tabs, $switch, $status);
                break;
            case 210:
                return $this->widget_210($datainput, $tabs, $switch, $status);
                break;
            case 160:
                return $this->widget_160($datainput, $tabs, $switch, $status);
                break;
            case 110:
                return $this->widget_110($datainput, $tabs, $switch, $status);
                break;
            case 200:
                return $this->widget_200($datainput, $tabs, $switch, $status);
                break;


            case 120:
                return $this->widget_120($datainput, $tabs, $switch, $status);
                break;
            case 12100:
                return $this->widget_120100($datainput, $tabs, $switch, $status);
                break;
            case 121:
                return $this->widget_120($datainput, $tabs, $switch, $status);
                break;
            case 122:
                return $this->widget_120($datainput, $tabs, $switch, $status);
                break;
            case 123:
                return $this->widget_120($datainput, $tabs, $switch, $status);
                break;
            case 124:
                return $this->widget_120($datainput, $tabs, $switch, $status);
                break;
            case 125:
                return $this->widget_120($datainput, $tabs, $switch, $status);
                break;
            case 155:
                return $this->widget_155($datainput, $tabs, $switch, $status);
                break;
            case 40:
                return $this->widget_40($datainput, $tabs, $switch, $status);
                break;
            case 50:
                return $this->widget_50($datainput, $tabs, $switch, $status);
                break;
            case 60:
                return $this->widget_60($datainput, $tabs, $switch, $status);
                break;
            case 70:
                return $this->widget_70($datainput, $tabs, $switch, $status);
                break;
            case 80:
                return $this->widget_80($datainput, $tabs, $switch, $status);
                break;


            case 126:
                return $this->widget_126($datainput, $tabs, $switch, $status);
                break;
            case 127:
                return $this->widget_127($datainput, $tabs, $switch, $status);
                break;
        }


    }

    public function widget_155($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();

        $ChatController = new ChatController();
        $data = $ChatController->get_data_to_chat();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 15)->first();
        $data['widget_data'] = DB::table('widgets_off_promokod')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->where('site_id', $user->site)->get();
        return $this->get_renders($data, $datainput, $tabs, $switch, $status);
    }

    public function widget_126($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->all_widget = DB::table('all_widget')->where('tip', 99)->where('subtip', 6)->first();
        $ChatController = new ChatController();
        $data = $ChatController->get_data_to_chat();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);
    }

    public function widget_127($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();

        $data['widget'] = $this->widget;
        $data['sites'] = DB::table('sites')->where('id', $data['widget']->sites_id)->first();
        $data['costs'] = DB::table('widgets_chat_fastotvet')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->get();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);
    }

    public function widget_80($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 8)->first();
        $data['widget'] = $this->widget;
        $data['sites'] = DB::table('sites')->where('id', $data['widget']->sites_id)->first();
        $data['widget_vk'] = DB::table('widget_telegram')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);
    }

    public function widget_70($datainput, $tabs, $switch, $status)
    {

        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 7)->first();
        $data['widget'] = $this->widget;
        $data['sites'] = DB::table('sites')->where('id', $data['widget']->sites_id)->first();
        $data['widget_vk'] = DB::table('widget_fb')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();
        $FbController=new FbController();
        $data['fb_url']=$FbController->get_url_for_token();
        $data['fb_pages']=WidgetFbPage::where('my_company_id',$user->my_company_id)->get();


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);
    }

    public function widget_60($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 6)->first();
        $data['widget'] = $this->widget;
        $data['sites'] = DB::table('sites')->where('id', $data['widget']->sites_id)->first();
        $data['widget_vk'] = DB::table('widget_ok')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);
    }


    public function widget_50($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 5)->first();
        $data['widget'] = $this->widget;
        $data['sites'] = DB::table('sites')->where('id', $data['widget']->sites_id)->first();
        $data['widget_vk'] = DB::table('widget_viber')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);
    }

    public function widget_40($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 4)->first();
        $data['widget'] = $this->widget;
        $data['sites'] = DB::table('sites')->where('id', $data['widget']->sites_id)->first();
        $data['widget_vk'] = DB::table('widget_vk')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);
    }
    public function widget_120100($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 12)->first();
        $data['widget'] = $this->widget;
        $data['widget_vk'] = DB::table('widgets_chat')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        $data['url_operators'] = DB::table('widgets_chat_url_operator')->where('widget_id', $data['widget_vk']->id)->get();
        $ua = \Request::server('HTTP_USER_AGENT');
        $prov_google_token = DB::table('users_push')->where('user_id', $user->id)->where('ua', $ua)->first();
        if ($prov_google_token) {
            $data['prov_google_token'] = 0;
            DB::table('users_push')->where('id', $prov_google_token->id)->update(['time_online' => time()]);
        } else {

            $data['prov_google_token'] = 1;
        }
    $data['groups'] = UsersGroup::where('my_company_id', $user->my_company_id)->with('users')->get();

$urole=\DB::table('group_role_user')->where('group_id',2)->pluck('user_id');
        $data['operators']=User::where('my_company_id', $user->my_company_id)->wherein('id',$urole)->get();
$data['operator_urls']=WidgetsChatUrlOperatorNew::where('widget_id',$this->widget->id)->get();
$data['mess_rules']=WidgetsChatMessRule::where('widget_id',$this->widget->id)->get();
        return $this->get_renders($data, $datainput, $tabs, $switch, $status);
    }
    public function widget_120($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 12)->first();
        $data['widget'] = $this->widget;
        $data['widget_vk'] = DB::table('widgets_chat')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        $data['url_operators'] = DB::table('widgets_chat_url_operator')->where('widget_id', $data['widget_vk']->id)->get();
        $ua = \Request::server('HTTP_USER_AGENT');
        $prov_google_token = DB::table('users_push')->where('user_id', $user->id)->where('ua', $ua)->first();
        if ($prov_google_token) {
            $data['prov_google_token'] = 0;
            DB::table('users_push')->where('id', $prov_google_token->id)->update(['time_online' => time()]);
        } else {

            $data['prov_google_token'] = 1;
        }
        return $this->get_renders($data, $datainput, $tabs, $switch, $status);
    }

    public function widget_110($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 11)->first();
        $data['widget_vk'] = DB::table('widget_direct')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();
        $data['counters'] = DB::table('metrika_direct_company')->where('my_company_id', $user->my_company_id)->where('widget_direct_id', $data['widget_vk']->id)->get();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }
    public function widget_220($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 22)->first();

        $data['widget_ga_call'] =$this->widget;


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }
    public function widget_270($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 27)->first();
        $data['widget_ga_call'] =$this->widget;

        $data['site']=Sites::find($user->site);
        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }
    public function widget_210($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 21)->first();
        $data['widget_ga_call'] =$this->widget;

        $data['site']=Sites::find($user->site);
        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }
    public function widget_200($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 20)->first();
        $data['widget_ad'] = DB::table('widget_adwords')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();
        $data['counters_ad'] = DB::table('metrika_adwords_company')->where('my_company_id', $user->my_company_id)->where('widget_direct_id', $data['widget_ad']->id)->get();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }
    public function widget_100($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $data['metrika_widget'] = DB::table('widget_metrika')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();
        $data['metrika_counters'] = DB::table('metrika_counter')->where('my_company_id', $user->my_company_id)->where('widget_metrika_id', $data['metrika_widget']->id)->get();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }


    public function widget_180($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 18)->first();
        $data['widgets_item'] = DB::table('widgets_roistar')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();;
        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_170($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 17)->first();
        $data['widgets_bitrix24'] = DB::table('widgets_amocrm')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_160($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 16)->first();
        $data['widgets_bitrix24'] = DB::table('widgets_bitrix24')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();


        $data['widgets_bitrix24_statusis_lead'] = DB::table('widgets_bitrix24_status')->where('my_company_id', Auth::user()->my_company_id)->where('widget_crm_id', $this->widget->id)->where('type','lead')->get();
        $data['widgets_bitrix24_statusis_crm'] = DB::table('widgets_bitrix24_status')->where('my_company_id', Auth::user()->my_company_id)->where('widget_crm_id', $this->widget->id)->where('type','crm')->get();
        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_91($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $data['widget'] = $this->widget;


        $data['widget_vk'] = DB::table('widgets_email')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_92($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $data['widget'] = $this->widget;
        $data['widget_vks'] = DB::table('widgets_email_static')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->get();
        $data_widget_vk = DB::table('widgets_email')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        $search_email = explode("@", $data_widget_vk->email);
        if (count($search_email) == 2) {
            $start = $search_email[0];
            $end = $search_email[1];
        } else {
            $start = '';
            $end = '';
        }
        $data['start'] = $start;
        $data['end'] = $end;


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_90($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();

        $EmailController = new EmailController();
        $data['statistik'] = $EmailController->get_all();


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_30($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();


        $data['widget'] = $this->widget;
        $data['chart'] = '';;
        $CallStaticController = new CallStaticController();
        $data['chart'] = $CallStaticController->get_carts([1, 2]);
        $data['stat_start_date'] = $user->stat_start_date;
        $data['stat_end_date'] = $user->stat_end_date;


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_31($datainput, $tabs, $switch, $status)
    {

        $user = Auth::user();
        $data['user'] = $user;
        $data['widget'] = $this->widget;
        $data['canals'] = WidgetCanal::orwhere('id',22)->orwhere(function ($query)use ($user){
            $query-> where('my_company_id',$user->my_company_id)->where('site_id',$user->site);
        })->get();
        $data['costs'] = DB::table('Costs')
            ->join('widget_canals', 'widget_canals.id', '=', 'Costs.canal_id')
            ->where('Costs.my_company_id', $user->my_company_id)->where('Costs.site_id', $user->site)
            ->select('Costs.*', 'widget_canals.name as canal_name')
            ->orderby('id', 'desc')->get();


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }


    public function widget_00($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $data['user'] = $user;
        $this->widget = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 0)->first();
        $data['widget_prom'] = $this->widget;
        $data['widget_promokod'] = DB::table('widgets_promokod')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }


    public function widget_24($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $data['user'] = $user;
        $data['widget'] = $this->widget;
        $data['phones_unic'] = \App\Widgets_phone::where('widget_id', $data['widget']->id)->pluck('input');


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_23($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $data['user'] = $user;
        $data['widget'] = $this->widget;
        $data['routes'] = \App\Widgets_phone_routing::where('widget_id', $this->widget->id)->get();
        $data['witget_canals']=WidgetCanal::wherein('my_company_id',[0,$user->my_company_id])->get();
        $data['widget_calltrack_regions'] = DB::table('widget_calltrack_region')->get();
        $roistat = Widgets::where('my_company_id', $user->my_company_id)->where('status', 1)->where('sites_id', $user->site)->where('tip', 18)->first();
        $data['roistat'] = 0;
        if ($roistat) {
            $data['roistat'] = 1;
        }
        $data['widget_call_track'] = DB::table('widget_call_track')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_22($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();

        $data['widget_calltrack_regions'] = DB::table('widget_calltrack_region')->get();
        $data['phones'] = \App\Widgets_phone::where('widget_id', $this->widget->id)->get();
        $data['widget_call_track'] = DB::table('widget_call_track')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_21($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();


        $data['widget_call_track'] = DB::table('widget_call_track')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        $data['widget'] = $this->widget;
        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_20($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();


        $data['widget'] = $this->widget;
        $data['chart'] = '';;
        $CallStaticController = new CallStaticController();
        $CallStaticController->get_date_grafic();
        $data['stat_start_date'] = $user->stat_start_date;
        $data['stat_end_date'] = $user->stat_end_date;


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_1($datainput, $tabs, $switch, $status)
    {



        $user = Auth::user();



        $data['widget_vk'] = DB::table('widget_callback')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();



        $data['widget'] = $this->widget;

        $data['routings']=WidgetCallbackRouting::where('sites_id',$this->widget->sites_id) ->get();


        $data['catch_who_call_first']=auth()->user()->getglsetvithinstall('callbach_who_call_first_'.$this->widget->sites_id);
        $data['catch_who_man_wooman']=auth()->user()->getglsetvithinstall('callbach_who_man_wooman_'.$this->widget->sites_id);
        $data['catch_aou']=auth()->user()->getglsetvithinstall('callback_aou_'.$this->widget->sites_id);



        $data['fields'] = DB::table('widget_callback_worktime') ->where('sites_id',  $this->widget->sites_id)->orderby('day', 'ASC')->where('is_work',1)->get();


$data['widget_js']=Widgets::where('tip',3) ->where('sites_id',  $this->widget->sites_id)->first();
$widget_chat_call=Widgets::where('tip',12) ->where('sites_id',  $this->widget->sites_id)->first();;

$data['widget_chat_call']=DB::table('widgets_chat')->where('widget_id', $widget_chat_call->id)->first();













        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_190($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();


        $data['widget'] = $this->widget;
        $data['widget_vk'] = DB::table('widget_catch_lead')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();
        $data['routings']=WidgetCallbackRouting::where('sites_id',$this->widget->sites_id)->get();




        $data['catch_who_call_first']=auth()->user()->getglsetvithinstall('callbach_who_call_first_'.$this->widget->sites_id);
        $data['catch_who_man_wooman']=auth()->user()->getglsetvithinstall('callbach_who_man_wooman_'.$this->widget->sites_id);
        $data['catch_aou']=auth()->user()->getglsetvithinstall('callback_aou_'.$this->widget->sites_id);



        $data['fields'] = DB::table('widget_callback_worktime')->where('sites_id', $this->widget->sites_id)->where('my_company_id', $user->my_company_id)->orderby('day', 'ASC')->where('is_work',1)->get();
        $new_w=Widgets::where('tip',1) ->where('sites_id',$this->widget->sites_id)->first();
$data['widget_vk_callback']= DB::table('widget_callback')->where('widget_id',$new_w->id)->first();

        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_191($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();


        $data['widget'] = $this->widget;
        $data['widget_vk'] = DB::table('widget_catch_lead')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();
        $data['fields'] = DB::table('widget_callback_worktime')->where('sites_id', $this->widget->sites_id)->where('my_company_id', $user->my_company_id)->orderby('day', 'ASC')->get();


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }
    public function widget_192($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $data['widget_vk'] = DB::table('widget_catch_lead')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        $data['widget'] = $this->widget;

        $prov=DB::table('widget_catch_lead_ab')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->where('is_null',1)->first();
if(!$prov){
           $data_insert['ab']['position_1_text'] = 'Вы нашли, что искали?';
           $data_insert['ab']['position_1_yes_text'] = 'Да';
           $data_insert['ab']['widget_catch_lead_id'] = $data['widget_vk']->id;
           $data_insert['ab']['position_1_not_text'] = 'Нет';
           $data_insert['ab']['position_1_yes_bcolor'] = '#00B9EE';
           $data_insert['ab']['position_1_yes_tcolor'] = '#fff';
           $data_insert['ab']['position_1_not_bcolor'] = '#00B9EE';
           $data_insert['ab']['position_1_not_rcolor'] = '#fff';
           $data_insert['ab']['first_step_status'] = 1;
           $data_insert['ab']['is_null'] = 1;
           $data_insert['ab']['my_company_id'] = $user->my_company_id;
           $data_insert['ab']['widget_id'] =  $this->widget->id;

    DB::table('widget_catch_lead_ab')->insert(

        $data_insert
    )   ;
    
}







        $data['fields'] = DB::table('widget_catch_lead_ab')->where('widget_id', $this->widget->id)->where('is_null', 0)->where('my_company_id', $user->my_company_id)->get();


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }
    public function widget_193($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();
        $data['widget_vk'] = DB::table('widget_catch_lead')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->first();

        $data['widget'] = $this->widget;




        $ad=DB::table('widget_catch_lead_ab')->where('widget_id', $this->widget->id) ->where('my_company_id', $user->my_company_id)->pluck('id');




        $data['fields'] =[];/* DB::table('widget_catch_lead_ab_view')->wherein('ab_id',$ad)
            ->where('my_company_id', $user->my_company_id)   ->where(function ($query){
                $query ->where('lead',1)   ->orwhere('step_1','>',0)->orwhere('step_2','>',0);



            })

            ->get();*/


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }
    public function widget_13($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();


        $data['widget'] = $this->widget;
        $data['fields'] = DB::table('widget_callback_worktime')->where('sites_id', $this->widget->sites_id)->where('my_company_id', $user->my_company_id)->orderby('day', 'ASC')->get();


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }
    public function widget_14($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();


        $data['widget'] = $this->widget;


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }
    public function widget_12($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();


        $data['widget'] = $this->widget;
        $data['fields'] = DB::table('neiros_hash_fields')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->get();


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function widget_11($datainput, $tabs, $switch, $status)
    {
        $user = Auth::user();


        $data['widget'] = $this->widget;
        $data['forms'] = DB::table('widget_callback_form')->where('widget_id', $this->widget->id)->where('my_company_id', $user->my_company_id)->get();


        return $this->get_renders($data, $datainput, $tabs, $switch, $status);


    }

    public function get_renders($info, $datainput, $tabs, $switch, $status)
    {
        $info['name_h2'] = $this->all_widget->name_h2;
        $info['idw'] = $this->all_widget->tip . '-' . $this->all_widget->subtip;;
        $datainput['jss'][] = view('widgets.js.' . $this->all_widget->folder . '.' . $this->all_widget->file, $info)->render();
        if ($status == 1) {
            if ($this->widget->status == 1) {
                $w_status = 'checked';
				$name_w = 'Отключить';
            } else {
                $w_status = '';
				$name_w = 'Подключить';
            } 
			if($w_status == 'checked'){
				
				} 
				else{
					
					}
            $info['status_checkbox_metrika'] = '  <div class="form-group">
                               
                               
								<button type="button" class="btn btn-primary w_safebutton widget_status_checkbox ' . $w_status . '" data-id="' . $this->widget->id . '">' . $name_w . '</button>
                                
                             
                            </div>';
            $info['status_checkbox_metrika_modal'] = '  
                                
                                <div class="col-xs-12">
								<button type="button" class="btn btn-primary  widget_status_checkbox ' . $w_status . '" data-id="' . $this->widget->id . '">' . $name_w . '</button>
                                </div>
                            ';
        } else {

            $info['status_checkbox_metrika'] = '';
            $info['status_checkbox_metrika_modal'] = ' ';
        }

        $info['for_view']=$this->for_view;

        $datainput['renders'][] = view('widgets.render.' . $this->all_widget->folder . '.' . $this->all_widget->file, $info)->render();

        if ($tabs == 1) {
            $datainput['tabs'] = view('widgets.tabs.' . $this->all_widget->folder . '.' . $this->all_widget->file, $info)->render();
            $datainput['title'] = $this->all_widget->title;
        }

        if (!is_null($this->widget)) {
            if ($this->widget->status == 1) {
                $w_status = 'checked';

            } else {
                $w_status = '';
            }
            if ($switch == 1) {
                $datainput['status_checkbox'] = ' <div class="checkbox checkbox-switchery col-md-1">
                                        <label><input type="checkbox" class="switchery widget_status_checkbox"  
                   name="status" ' . $w_status . '  data-id="' . $this->widget->id . '" ></label>
                                    </div>';
            }
        }



        $datainput['widget']= $this->widget->id;
        return $datainput;
    }


}
