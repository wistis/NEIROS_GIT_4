<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\WidgetApiController;
use App\Models\Reports\My_reports_dashboard;
use App\Models\Reports\Reports_groping;
use App\Models\Reports\Reports_resourse;
use App\Models\Servies\CurrencyCurs;
use App\Project;
use App\Sites;
use App\Stage;
use App\Widgets;
use Auth;
use DB;
use DateTime;
use Illuminate\Http\Request;
use Log;
use App\Models\MetricaCurrent;
use LaravelGoogleAds\Services\AuthorizationService;
use LaravelGoogleAds\Services\AdWordsService;

class IndexController extends Controller
{  protected $authorizationService;
    protected $adWordsService;

    public function __construct(AdWordsService $adWordsService,AuthorizationService $authorizationService)
    {
        $this->adWordsService = $adWordsService;
        $this->authorizationService = $authorizationService;
    }









public function jivosite(Request $request){

    Log::info('benefis jivo');
    Log::info($request->all());
return 'ok';
}

    public function get_pay_check()
    {

        return DB::table('Checkcompanys')->where('my_company_id', Auth::user()->my_company_id)->where('status', 0)->count();

    }

    public function upaudio($id)
    {
        $cal = DB::connection('asterisk')->table('calls')->where('id', $id)->first();
        //  DB::connection('asterisk')->table('calls')->where('id',$id)->update(['totext'=>1]);


        //record_file
        $start_in = 'http://82.146.43.227/records/' . date("Y", strtotime($cal->calldate)) . '/' . date("m", strtotime($cal->calldate)) . '/' . date("d", strtotime($cal->calldate)) . '/' . $cal->record_file . '-in.mp3';
        $start_out = 'http://82.146.43.227/records/' . date("Y", strtotime($cal->calldate)) . '/' . date("m", strtotime($cal->calldate)) . '/' . date("d", strtotime($cal->calldate)) . '/' . $cal->record_file . '-out.mp3';

        copy($start_in, '/var/www/neiros/data/www/cloud.neiros.ru/public/audiorecord/' . $cal->record_file . '-in.mp3');
        copy($start_out, '/var/www/neiros/data/www/cloud.neiros.ru/public/audiorecord/' . $cal->record_file . '-out.mp3');
        $file1 = $cal->record_file . '-in.mp3';
        $file2 = $cal->record_file . '-out.mp3';


        exec('/usr/bin/perl /var/www/neiros/data/www/cloud.neiros.ru/1.pl "' . $file1 . '" "' . $file2 . '" ' . $id . ' >1log');


    }


    public function asterisk(Request $request)
    {
Log::info('Колбек тайм'.time());
        $WidgetApiController = new WidgetApiController();
        $WidgetApiController->index($request);
        DB::table('widgets_phone')->where('input', $request->did)->increment('amout_call');

        return 'ok';
    }






    public function index()
    {


        $_COOKIE['wistis']=1;
        \Cookie::queue(\Cookie::forever('neiros_visitq', '1') );

        $user=Auth::user();
        if (is_null($user->stat_start_date)) {
            $data['stat_start_date'] = date('Y-m-d');
        } else {
            $data['stat_start_date'] = $user->stat_start_date;
        }
        if (is_null($user->stat_end_date)) {
            $data['stat_end_date'] = date('Y-m-d');
        } else {
            $data['stat_end_date'] = $user->stat_end_date;
        }

        $data['last_report'] = $user->last_report;


        $data['stages'] = Stage::where('my_company_id', $user->my_company_id)->get();

        $data['my_reports'] = My_reports_dashboard::where('my_company_id', $user->my_company_id)->where('private',0)->get();


        $data['my_reports_0'] = My_reports_dashboard::where('id',0)->first();




        if (count($data['my_reports']) > 0) {
            if (($user->last_report == 0) || (is_null($user->last_report))) {
                $Mye = My_reports_dashboard::where('my_company_id', $user->my_company_id)->first();
                $data['last_report'] = $Mye->id;
            }

        } else {
            $data['last_report'] = 0;
        }

        $data['reports_gropings'] = Reports_groping::all();
        $data['reports_resourse'] = Reports_resourse::all();;

        $MetricaCurrent=new MetricaCurrent();


        $data['amount_visit']= $MetricaCurrent->setTable('metrica_'.$user->my_company_id)
 ->where('site_id', $user->site)->where('reports_date',date('Y-m-d'))->where('bot', 0)
              ->DISTINCT('hash')
            ->count();
        $data['amount_sdelka']= Project:: where('my_company_id', $user->my_company_id)->where('site_id',auth()->user()->site)->where('reports_date',date('Y-m-d'))

            ->count();
       $data['amount_sdelka_hour']= Project:: where('my_company_id', $user->my_company_id)->where('reports_date',date('Y-m-d'))->where('site_id',auth()->user()->site)
            ->select(DB::raw('COUNT(*) as total'),'hour')->groupby('hour')
            ->pluck('total','hour');


        $data['amount_summ']= Project:: where('my_company_id', $user->my_company_id)->where('site_id',auth()->user()->site)->where('reports_date',date('Y-m-d'))

            ->sum('summ');




        $amount_sdelka_summs= Project:: where('my_company_id', $user->my_company_id)->where('site_id',auth()->user()->site)->whereBetween('reports_date',[date('Y-m-d',(time()-86400*7)),date('Y-m-d')])
            ->select(DB::raw('sum(summ) as total'),'reports_date')->groupby('reports_date')
            ->orderby('reports_date','asc')->get();
$daf=[];$i=0;
foreach($amount_sdelka_summs as $item){

    $daf[$i]['date']= date('m/d/y',strtotime($item->reports_date)) ;
    $daf[$i]['alpha']=$item->total;
$i++;


}

  $data['amount_sdelka_summ'] =json_encode($daf);





        return view('index', $data);
    }

    public function logout()
    {

        if (\Cookie::get('admin')) {
            $prov = DB::table('users')->where('id', \Cookie::get('admin'))->first();
            if ($prov) {
                \Cookie::queue('admin', '0', 3600 * 24);
                Auth::loginUsingId($prov->id);
                return redirect('/setting/adminclient');
            }


        };


        Auth::logout();
        return redirect('/');
    }

    public function set_sites(Request $request)
    {
        $user = Auth::user();
        $res1 = Sites::where('my_company_id', $user->my_company_id)->where('is_deleted', 0)->where('id', $request->selsites)->first();
        if ($res1) {
            DB::table('users')->where('id', $user->id)->update(['site' => $request->selsites]);

            return 1;
        }
        if ($request->selsites == 0) {
            DB::table('users')->where('id', $user->id)->update(['site' => 0]);

            return 1;
        }
        return 0;
    }

    public function getNewProject()
    {
        $user = Auth::user();
        $count = Project::where('my_company_id', $user->my_company_id)->where('is_viewed', '!=', 1)->count();
        if ($count > 0) {
            return '<span class="label bg-blue-400">' . $count . '</span>';
        }
    }

    public function getNewChat()
    {
        $user = Auth::user();
        $count = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('status', '=', 1)->count();
        if ($count > 0) {
            return '<span class="label bg-blue-400">' . $count . '</span>';
        }
    }

    public function getNewadminmess()
    {
        $user = Auth::user();
        if ($user->super_admin == 0) {
            $count = DB:: table('admin_messages_read')->where('user_id', $user->id)->where('status', 0)->count();
            if ($count > 0) {

                return '<span class="label bg-blue-400">' . $count . '</span>';
            }
        }
    }


    public function get_sites()
    {


        $user = Auth::user();

        $res = Sites::where('my_company_id', $user->my_company_id)->where('is_deleted', 0)->get();


        if (count($res) == 1) {
            foreach ($res as $re) {

                DB::table('users')->where('id', $user->id)->update(['site' => $re->id]);
            }

        }

        return $res;

    }

    public function get_ballans()
    {
        $user = Auth::user();
        $gets = DB::table('users_company')->where('id', $user->my_company_id)->first();
        if ($gets) {
            return $gets->ballans;
        }
    }


    public function get_system_messages(){
        $user=Auth::user();
        return DB::table('admin_messages_read')->
        join('admin_messages','admin_messages.id','=','admin_messages_read.mess_id')->
        where('admin_messages_read.user_id',$user->id)->
        where('admin_messages_read.status',0)->
        select('admin_messages_read.*','admin_messages.tema as tema','admin_messages.message as message','admin_messages.tickets as tickets')->orderby('admin_messages_read.created_at','desc')->get();


    }
}
