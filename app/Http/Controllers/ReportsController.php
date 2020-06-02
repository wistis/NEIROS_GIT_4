<?php

namespace App\Http\Controllers;

use App\Models\NeirosUtm;
use App\Models\WidgetCanal;
use App\User;
use Datatables;
use App\Models\Adwords\Otchet;
use App\Http\Controllers\Reports\NewDirectReportsController;
use App\Models\Reports\My_reports;
use App\Models\Reports\My_reports_dashboard;
use App\Models\Reports\Reports_groping;
use App\Models\Reports\Reports_resourse;
use App\Project;
use App\Models\MetricaCurrent;
use App\Sites;
use App\Stage;
use App\Widgets;
use Auth;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Dompdf\Dompdf;
use PDF;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public $my_company_id;
    public $sites_id;
    public $resourse_names;
    public $period_start;
    public $period_end;
    public $period;
    public $grouping;
    public $projects_ids;
    public $all_group;
    public $lvl = 0;
    public $re_typ = [];
    public $canals = 0;
    public $data_all = [];
    public $r = 0;


    public function get_edit($request)
    {

        $user = Auth::user();
        $data['reports_gropings'] = Reports_groping::all();
        $data['reports_resourse'] = Reports_resourse::all();;


        $report = My_reports::where('my_company_id', $user->my_company_id)->where('id', $request->id)->first();
        $data['report'] = $report;

        return view('reports.modal_edit', $data)->render();


    }

    public function get_pdf($type_report, Request $reques)
    {

        $dat = $this->reports_table($type_report, $reques);
        $datas = json_decode($dat);
        // reference the Dompdf namespace


// instantiate and use the dompdf class

        // $pdf = App::make('dompdf.wrapper');
        //$pdf->loadHTML('<h1>Test</h1>');
        $data['table'] = $datas->table;
        $data['title'] = 'Отчет';
        $pdf = PDF::loadView('pdf.report', $data);


        $dompdf = new Dompdf([
            'fontDir' => '/var/www/neiros/data/www/cloud.neiros.ru/public/cdn/v1/chatv2/fonts/',//указываем путь к папке, в которой лежат скомпилированные шрифты
            'defaultFont' => 'dompdf_arial',//делаем наш шрифт шрифтом по умолчанию
        ]);

        $dompdf->loadHtml(view('pdf.report', $data)->render(), 'UTF-8');

// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser
        $dompdf->stream();


    }

    public function index()
    {

        $user = Auth::user();


        if (is_null($user->stat_start_date)) {
            $data['stat_start_date'] = date('Y-m-d', (time() - 86400 * 30));
        } else {
            $data['stat_start_date'] = $user->stat_start_date;
        }
        if (is_null($user->stat_end_date)) {
            $data['stat_end_date'] = date('Y-m-d');
        } else {
            $data['stat_end_date'] = $user->stat_end_date;
        }

        $data['last_report'] = $user->last_report;

        $prov_last_report = My_reports::where('my_company_id', $user->my_company_id)->where('id', $user->last_report)->first();
        if (!$prov_last_report) {
            $data['last_report'] = 1;
        }

        $data['canals'] = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->get();


        $data['stages'] = Stage::where('my_company_id', $user->my_company_id)->get();

        $data['my_reports'] = My_reports::where('my_company_id', $user->my_company_id)->orwhere('my_company_id', 0)->get();

        if (count($data['my_reports']) > 0) {
            if (($user->last_report == 0) || (is_null($user->last_report))) {
                $data['last_report'] = 1;
            }

        } else {
            $data['last_report'] = 1;
        }

        $data['reports_gropings'] = Reports_groping::all();
        $data['reports_resourse'] = Reports_resourse::all();;
        return view('reports.index', $data);
    }

    public function seve($request, $user)
    {

        $create_lead = 0;
        $callback = 0;
        $status = 0;
        if (request()->has('status')) {
            $status = 1;
        }
        if (request()->has('create_lead')) {
            $create_lead = 1;
        }
        if (request()->has('callback')) {
            $callback = 1;
        }
        $widget_js = Widgets::where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->where('id', request()->get('id'))->where('tip', 3)->first();
        if ($widget_js) {


            $data['create_lead'] = $create_lead;
            $data['callback'] = $callback;

            $widget_js->params = $data;
            $widget_js->status = $status;
            $widget_js->save();
        }

        $min = $request->phone_rezerv_time * 60;
        $site = Sites::find(auth()->user()->site);
        $site->phone_rezerv_time = $min;
        $site->save();

        return 1;
    }

    public function setting()
    {


        /*if(request()->method()=='POST'){

            $create_lead=0;
            $callback=0;
            $stataus=0;
            if(request()->has('status')){
                $status=1;
            }
            if(request()->has('create_lead')){
                $create_lead=1;
            }
            if(request()->has('callback')){
                $callback=1;
            }
            $widget_js=Widgets::where('my_company_id',auth()->user()->my_company_id)->where('sites_id',auth()->user()->site)->where('id' , request()->get('id'))->where('tip',3)->first();
            if($widget_js){

 
                $data['create_lead']=$create_lead;
    $data['callback']=$callback;

    $widget_js->params=$data;
    $widget_js->status=$status;
                $widget_js->save();
            }

            session()->flash('success');
        }*/

        $widget_js = Widgets::where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->where('tip', 3)->first();

        if (is_null($widget_js->params)) {
            $data['create_lead'] = 0;
            $data['callback'] = 0;

            $widget_js->params = $data;
            $widget_js->save();
            $widget_js = Widgets::where('my_company_id', auth()->user()->my_company_id)->where('sites_id', auth()->user()->site)->first();
        }


        $my_site = Sites::where('id', auth()->user()->site)->first();
        $min = $my_site->phone_rezerv_time / 60;


        $data['renders'] = view('reports.setting', compact('widget_js', 'min'))->render();
        return $data;
    }

    public function index_ajax($type_report, Request $request)
    {

        switch ($type_report) {

            case 'create':


                return $this->my_report_create($request);
                break;
            case 'create_w':


                return $this->my_report_create_w($request);
                break;
            case 'get_edit':


                return $this->get_edit($request);
                break;
            case 'update_reports':


                return $this->update_reports($request);
                break;
            case 'delete_reports':


                return $this->delete_reports($request);
                break;


        }
    }

    public function delete_reports($rew)
    {
        $user = Auth::user();
        My_reports::where('id', $rew->id)->where('my_company_id', $user->my_company_id)->delete();


    }

    public function update_reports($input_data)
    {

        $user = Auth::user();
        $data['name'] = $input_data->name;
        $data['my_company_id'] = $user->my_company_id;
        $data['grouping'] = json_encode($input_data->grouping);
        $data['resourse'] = json_encode($input_data->resourses);
        $data['type'] = $input_data->type;


        $Myreports = My_reports::where('id', $input_data->report_id)->update($data);
        $data['id'] = $input_data->report_id;
        return json_encode($data);


    }

    public function my_report_create($input_data)
    {
        $user = Auth::user();
        $data['name'] = $input_data->name;
        $data['my_company_id'] = $user->my_company_id;
        $data['resourse'] = $input_data->resourses;
        $data['grouping'] = $input_data->grouping;
        $data['type'] = $input_data->type;


        $Myreports = My_reports::create($data);

        return json_encode($Myreports);


    }

    public function my_report_create_w($input_data)
    {
        $user = Auth::user();
        $data['name'] = $input_data->name;
        $data['my_company_id'] = $user->my_company_id;
        $data['grouping'] = $input_data->grouping;
        $data['resourse'] = $input_data->resourses;
        $data['type'] = $input_data->type;


        $Myreports = My_reports_dashboard::create($data);

        return json_encode($Myreports);


    }

    public function reports_table($type_report, Request $request)
    {

        $this->resourse_names = DB::table('reports_resourse')->pluck('name', 'code')->toArray();

        $user = Auth::user();

        if ($request->canals > 0) {
            $this->canals = $request->canals;
        }

        DB::table('users')->where('id', $user->id)->update(['last_report' => $type_report]);
        $this->my_company_id = $user->my_company_id;
        $this->sites_id = [$user->site];
        Sites::where('my_company_id', $this->my_company_id)->pluck('id');


        $this->format_period($request);

        $report = My_reports::find($type_report);

        if ($this->my_company_id == 40) {

            if (is_null($report->grouping)) {

                $this->grouping = DB::table('reports_groping')->where('id', '!=', 2)->get();
            } else {
                $this->grouping = DB::table('reports_groping')->where('id', '!=', 2)->wherein('id', $report->grouping)->get();
            }
            $this->all_group = DB::table('reports_groping')->where('id', '!=', 2)->pluck('table_name', 'name');

        } else {
            if (is_null($report->grouping)) {

                $this->grouping = DB::table('reports_groping')->get();
            } else {
                $this->grouping = DB::table('reports_groping')->wherein('id', $report->grouping)->get();
            }
            $this->all_group = DB::table('reports_groping')->pluck('table_name', 'name');
        }


        if ($report->type == 'line') {

            return $this->report_table_0($report, $request);
        }
        if ($report->type == 'funnel') {
            return $this->report_1($report, $request);
        }

    }
public function get_direct_lead(){
    $get_ids_metrika=NeirosUtm::where('neiros_p0','direct1')->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');
return Project::wherein('neiros_visit',$get_ids_metrika)->whereBetween('reports_date', $this->period)->count();

}
    public function get_adwords_lead(){
        $get_ids_metrika=NeirosUtm::where('neiros_p0','google1')->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');

        return Project::wherein('neiros_visit',$get_ids_metrika)->whereBetween('reports_date', $this->period)->count();

    }
    public function get_direct_0_lvl(){
        $ReportsDirectController = new NewDirectReportsController($this->my_company_id, $this->sites_id, $this->period,0);

    return    $get_direct_companys = $ReportsDirectController->get_new_0_lvl();

    }


    public function get_adwords_0_lvl(){
        $ReportsDirectController = new ReportsAdwordsController($this->my_company_id, $this->sites_id, $this->period,0);

        return    $get_direct_companys = $ReportsDirectController->get_new_0_lvl();

    }

    public function report_table_0($report, $request)
    {

        $data_to[] = '';

        foreach ($this->grouping as $item) {

            $code_arr = explode('|', $item->code);
            $pole_arr = explode('|', $item->pole);
            for ($i = 0; $i < count($pole_arr); $i++) {
                $array_group[] = $pole_arr[$i];
                $this->re_typ[$pole_arr[$i]][] = $code_arr[$i];
            }


        }

        if (isset($request->lvl)) {
            if ($request->lvl == 1) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;

            }
            if ($request->lvl == 2) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;
                $this->re_typ['src'][] = $request->src;

            }
            if ($request->lvl == 3) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;
                $this->re_typ['src'][] = $request->src;
                $this->re_typ['cmp'][] = $request->cmp;

            }
            if ($request->lvl == 4) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;
                $this->re_typ['src'][] = $request->src;
                $this->re_typ['cmp'][] = $request->cmp;
                $this->re_typ['cnt'][] = $request->cnt;

            }
            $this->lvl = $request->lvl;
        }


        $visit = $this->amount_visit_table();


        /*for ($i = 0; $i < count($report->resourse); $i++) {

            $return['names'][] = $this->resourse_names[$report->resourse[$i]];
            $return['series'][$forI]['data'] = $return[$report->resourse[$i]];
            $return['series'][$forI]['name'] = $this->resourse_names[$report->resourse[$i]];
            $return['series'][$forI]['type'] = 'line';
            // $return['series'][$forI]['barGap'] = 'barGap';
            $forI++;


        }*/


        $return['table'] = view('reports.pritails.table_header')->render();
        $tr_table = '';

        $this->data_all['posetitel'] = 0;
        $this->data_all['visit'] = 0;
        $this->data_all['sdelka'] = 0;
        $this->data_all['lead'] = 0;
        $this->data_all['summ'] = 0;
        $this->data_all['conversionsd'] = 0;
        $this->data_all['conversionld'] = 0;
        $this->r = 0;
        foreach ($visit as $repgroup) {
            $hash = md5(rand(1, 99999999999));
            $newlvl = '';
            $namegroup = '';
            if ($repgroup->lvl == 0) {
                $namegroup = $this->all_group[$repgroup->typ] . '(' . $repgroup->typ . ')';

                if ($repgroup->count_group > 1) {
                    $newlvl = '<i class="fa fa-plus clicklvl" style="color: blue;cursor: pointer;font-size: 10px;
color: #0878b4;" data-lvl="' . ($repgroup->lvl + 1) . '" data-typ="' . $repgroup->typ . '"  data-report="' . $report->id . '"  data-hash="m' . $hash . '" data-opened="0"  data-plus="0"></i>';
                }
            }
            if ($repgroup->lvl == 1) {
                $namegroup = $repgroup->src;

                if ($repgroup->count_group > 1) {
                    $newlvl = '<i class="fa fa-plus clicklvl" style="color: blue;cursor: pointer;font-size: 10px;
color: #0878b4;" data-lvl="' . ($repgroup->lvl + 1) . '" data-typ="' . $repgroup->typ . '"  data-src="' . $repgroup->src . '"  data-report="' . $report->id . '" data-hash="m' . $hash . '" data-plus="0" data-opened="0"></i>';
                }
            }

            if ($repgroup->lvl == 2) {
                $namegroup = $repgroup->cmp;

                if ($repgroup->count_group > 1) {
                    $newlvl = '<i class="fa fa-plus clicklvl" style="color: blue;cursor: pointer;font-size: 10px;
color: #0878b4;" data-lvl="' . ($repgroup->lvl + 1) . '" data-typ="' . $repgroup->typ . '"  data-src="' . $repgroup->src . '" data-cmp="' . $repgroup->cmp . '"    data-report="' . $report->id . '" data-hash="m' . $hash . '" data-plus="0" data-opened="0"></i>';
                }
            }
            if ($repgroup->lvl == 3) {
                $namegroup = $repgroup->cnt;

                if ($repgroup->count_group > 0) {
                    $newlvl = '<i class="fa fa-plus clicklvl" style="color: blue;cursor: pointer;font-size: 10px;
color: #0878b4;" data-cnt="' . $repgroup->cnt . '" data-lvl="' . ($repgroup->lvl + 1) . '" data-typ="' . $repgroup->typ . '"  data-src="' . $repgroup->src . '"  data-cmp="' . $repgroup->cmp . '"  data-report="' . $report->id . '" data-hash="m' . $hash . '" data-plus="0" data-opened="0"></i>';
                }
            }
            if ($repgroup->lvl == 4) {
                $namegroup = $repgroup->trim;

                if ($repgroup->count_group > 1) {
                    $newlvl = '<i class="fa fa-plus clicklvl" style="color: blue;cursor: pointer;font-size: 10px;
color: #0878b4;" data-lvl="' . ($repgroup->lvl + 1) . '" data-typ="' . $repgroup->typ . '"  data-src="' . $repgroup->src . '" data-cmp="' . $repgroup->cmp . '"  data-cnt="' . $repgroup->cnt . '" data-report="' . $report->id . '" data-hash="m' . $hash . '" data-plus="0" data-opened="0"></i>';
                }
            }
            if ($repgroup->lvl == 0) {


                $this->data_all['posetitel'] += $repgroup->posetitel;
                $this->data_all['visit'] += $repgroup->visit;
                $this->data_all['sdelka'] += $repgroup->sdelka;
                $this->data_all['lead'] += $repgroup->lead;
                $this->data_all['summ'] += $repgroup->summ;
                $this->data_all['conversionsd'] += $this->get_conversion($repgroup->visit, $repgroup->sdelka);
                $this->data_all['conversionld'] = +$this->get_conversion($repgroup->visit, $repgroup->lead);
                $this->r++;

            }

            $con_st = $this->get_conversion($repgroup->posetitel, $repgroup->sdelka);
            $con_lt = $this->get_conversion($repgroup->visit, $repgroup->lead);
            $mass_width = request()->get('mass_width');

            

            $tr_table .= view('reports.pritails.table_tr_1',
                compact('newlvl', 'namegroup', 'hash', 'repgroup', 'con_st', 'con_lt', 'mass_width'
                ))->render();
        }

        /*adwords*/
        $ReportsAdwordsController = new ReportsAdwordsController($this->my_company_id, $this->sites_id, $this->period, $this->lvl);
        $get_adwords_companys = $ReportsAdwordsController->get_0_lvl();

        if (count($get_adwords_companys) > 0) {


            if ($this->lvl == 0) {
                if (auth()->user()->get_site->get_widget_on(20)->status == 1) {
                    $tr_table .= $this->gettableadwords($get_adwords_companys, $return, $report);
                }
            }


        }


        $ReportsDirectController = new NewDirectReportsController($this->my_company_id, $this->sites_id, $this->period, $this->lvl);

        $get_direct_companys = $ReportsDirectController->get_0_lvl();

        if (count($get_direct_companys) > 0) {


            if ($this->lvl == 0) {
                if (auth()->user()->get_site->get_widget_on(11)->status == 1) {
                    $tr_table .= $this->gettabledirect($get_direct_companys, $return, $report);
                }
            }


        }
        if ($this->lvl == 0) {
            if ($this->r == 0) {


                $return['table'] .= reports_table;
            } else {


                $return['table'] .= $tr_table;
            }
        } else {
            $return['table'] .= $tr_table;
        }


        $return['table'] .= view('reports.pritails.teble_footer')->render();;

        $return['dates'] = $this->period;
        $return['type'] = $report->type;
        return json_encode($return, JSON_UNESCAPED_UNICODE);
    }

    public function getdirectcost($pole, $val, $tip)
    {
        if ($tip == 0) {
            $countgr = 'AdNetworkType';
        }
        if ($tip == 1) {
            $countgr = 'CampaignId';
        }
        if ($tip == 2) {
            $countgr = 'AdId';
        }
        if ($tip == 3) {
            $countgr = 'AdId';
        }
        if ($tip == 4) {
            $countgr = 'AdId';
        }

        $direct_company = DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $this->my_company_id)->where(function ($query) use ($pole, $val, $tip) {

            if ($tip > 0) {
                $query->where($pole, $val);
            }


        })->whereBetween('Date', $this->period)->select('CampaignName', 'AdGroupName', 'Query',
            DB::raw('SUM(Cost) as Cost'),
            DB::raw('SUM(Clicks) as Clicks'),
            DB::raw('SUM(Impressions) as Impressions'),
            DB::raw('count(DISTINCT(' . $countgr . ')) as count_group')

        )->first();

        return $direct_company;

    }

    public function getadwordscost($pole, $val, $tip)
    {
        if ($tip == 0) {
            $countgr = 'AdNetworkType1';
        }
        if ($tip == 1) {
            $countgr = 'CampaignId';
        }
        if ($tip == 2) {
            $countgr = 'AdGroupId';
        }
        if ($tip == 3) {
            $countgr = 'Query';
        }
        if ($tip == 4) {
            $countgr = 'Query';
        }
        $odadot = new Otchet(auth()->user()->my_company_id);
        $direct_company = $odadot->where(function ($query) use ($pole, $val, $tip) {

            if ($tip > 0) {
                $query->where($pole, $val);
            }


        })->whereBetween('Date', $this->period)->select('CampaignName', 'AdGroupName', 'Query',
            DB::raw('SUM(Cost) as Cost'),
            DB::raw('SUM(Clicks) as Clicks'),

            DB::raw('count(DISTINCT(' . $countgr . ')) as count_group')

        )->first();

        return $direct_company;

    }

    public function reports_table_direct($type_report, Request $request)
    {

        $this->resourse_names = DB::table('reports_resourse')->pluck('name', 'code')->toArray();

        $user = Auth::user();

        if ($request->canals > 0) {
            $this->canals = $request->canals;
        }

        DB::table('users')->where('id', $user->id)->update(['last_report' => $type_report]);
        $this->my_company_id = $user->my_company_id;
        $this->sites_id = [$user->site];
        Sites::where('my_company_id', $this->my_company_id)->pluck('id');


        $this->format_period($request);

        $report = My_reports::find($type_report);
        $this->grouping = DB::table('reports_groping')->wherein('id', $report->grouping)->get();
        $this->all_group = DB::table('reports_groping')->pluck('table_name', 'name');


        if ($report->type == 'line') {
            return $this->report_table_direct_0($report, $request);
        }
        /* if ($report->type == 'funnel') {
             return $this->report_1($report, $request);
         }*/

    }

    public function reports_table_adwords($type_report, Request $request)
    {

        $this->resourse_names = DB::table('reports_resourse')->pluck('name', 'code')->toArray();

        $user = Auth::user();

        if ($request->canals > 0) {
            $this->canals = $request->canals;
        }

        DB::table('users')->where('id', $user->id)->update(['last_report' => $type_report]);
        $this->my_company_id = $user->my_company_id;
        $this->sites_id = [$user->site];
        Sites::where('my_company_id', $this->my_company_id)->pluck('id');


        $this->format_period($request);

        $report = My_reports::find($type_report);
        $this->grouping = DB::table('reports_groping')->wherein('id', $report->grouping)->get();
        $this->all_group = DB::table('reports_groping')->pluck('table_name', 'name');

        if ($report->type == 'line') {
            return $this->report_table_adwords_0($report, $request);
        }
        /* if ($report->type == 'funnel') {
             return $this->report_1($report, $request);
         }*/

    }

    public function report_table_adwords_0($report, $request)
    {

        $data_to[] = '';

        foreach ($this->grouping as $item) {

            $code_arr = explode('|', $item->code);
            $pole_arr = explode('|', $item->pole);
            for ($i = 0; $i < count($pole_arr); $i++) {
                $array_group[] = $pole_arr[$i];
                $this->re_typ[$pole_arr[$i]][] = $code_arr[$i];
            }


        }
        if (isset($request->lvl)) {
            if ($request->lvl == 1) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;

            }
            $this->lvl = $request->lvl;
        }

        $name = '';
        if ($this->lvl == 1) {
            $name = 'Сеть';
        };
        if ($this->lvl == 2) {
            $name = 'Компания';
        };
        if ($this->lvl == 3) {
            $name = 'Объявления';
        };
        if ($this->lvl == 4) {
            $name = 'Ключи';
        };

        $return['table'] = view('reports.pritails.adwords.t_head', compact('name'))->render();


        $ReportsDirectController = new ReportsAdwordsController($this->my_company_id, $this->sites_id, $this->period, $this->lvl);


        if ($this->lvl == 1) {
            $odadot = new Otchet(auth()->user()->my_company_id);
            $direct_company_id = $odadot->whereBetween('Date', $this->period)->distinct('AdNetworkType1')->pluck('AdNetworkType1');
            foreach ($direct_company_id as $item) {


                $get_direct_companys = $ReportsDirectController->get_lvl('AdNetworkType1', $item);


                $return['table'] .= $this->gettableadwords_new($get_direct_companys, $return, $report, $item);

            }


        }
        if ($this->lvl == 2) {
            $odadot = new Otchet(auth()->user()->my_company_id);
            $direct_company_id = $odadot->whereBetween('Date', $this->period)->where('AdNetworkType1', $request->typ)->distinct('CampaignId')->pluck('CampaignId');
            foreach ($direct_company_id as $item) {

            $get_direct_companys = $ReportsDirectController->get_lvl('CampaignId', $item);
                $return['table'] .= $this->gettableadwords_new($get_direct_companys, $return, $report, $item);


            }/*SELECT *  FROM `neiros_utms` WHERE `neiros_p0` LIKE 'google1' AND `created_at` BETWEEN '2020-03-19' AND '2020-04-18' AND `my_company_id` = 12*/


        }
        if ($this->lvl == 3) {
            $odadot = new Otchet(auth()->user()->my_company_id);
            $direct_company_id = $odadot->whereBetween('Date', $this->period)->where('CampaignId', $request->typ)->distinct('AdGroupId')->pluck('AdGroupId');
            foreach ($direct_company_id as $item) {

                $get_direct_companys = $ReportsDirectController->get_lvl('AdGroupId', $item);
                $return['table'] .= $this->gettableadwords_new($get_direct_companys, $return, $report, $item);

            }


        }
        if ($this->lvl == 4) {
            $odadot = new Otchet(auth()->user()->my_company_id);
            $direct_company_id = $odadot->whereBetween('Date', $this->period)->where('AdGroupId', $request->typ)->groupby('Query')->get();
            foreach ($direct_company_id as $item) {

                $get_direct_companys = $ReportsDirectController->get_lvl('Query', $item->Query);;
                $return['table'] .= $this->gettableadwords_new($get_direct_companys, $return, $report, $item->Query, $item->Query);

            }


        }


        $return['table'] .= view('reports.pritails.adwords.t_fooot', compact('name'))->render();

        $return['dates'] = $this->period;
        $return['type'] = $report->type;
        return json_encode($return);
    }

    public function report_table_direct_0($report, $request)
    {

        $data_to[] = '';

        foreach ($this->grouping as $item) {

            $code_arr = explode('|', $item->code);
            $pole_arr = explode('|', $item->pole);
            for ($i = 0; $i < count($pole_arr); $i++) {
                $array_group[] = $pole_arr[$i];
                $this->re_typ[$pole_arr[$i]][] = $code_arr[$i];
            }


        }
        if (isset($request->lvl)) {
            if ($request->lvl == 1) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;

            }
            $this->lvl = $request->lvl;
        }

        $name = '';
        if ($this->lvl == 1) {
            $name = 'Сеть';
        };
        if ($this->lvl == 2) {
            $name = 'Компания';
        };
        if ($this->lvl == 3) {
            $name = 'Объявления';
        };

        $return['table'] = view('reports.pritails.direct.t_head', compact('name'))->render();


        $ReportsDirectController = new ReportsDirectController($this->my_company_id, $this->sites_id, $this->period, $this->lvl);


        if ($this->lvl == 1) {
            $direct_company_id = DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $this->my_company_id)->whereBetween('Date', $this->period)->distinct('AdNetworkType')->pluck('AdNetworkType');
            foreach ($direct_company_id as $item) {

                $get_direct_companys=
                    $ReportsDirectController->get_lvl_new('AdNetworkType', $item);

;

                  $get_project = $ReportsDirectController->get_lvl_new_project('AdNetworkType', $item,'CampaignId','neiros_p2');
                $get_direct_companys->lead=$get_project;
                $get_direct_companys->sdelka=$get_project;
                $get_direct_companys->summ=0;

                $return['table'] .= $this->gettabledirect_new($get_direct_companys, $return, $report, $item,$get_project);

            }


        }
        if ($this->lvl == 2) {
            $direct_company_id = DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $this->my_company_id)->whereBetween('Date', $this->period)->where('AdNetworkType', $request->typ)->distinct('CampaignId')->pluck('CampaignId');
            foreach ($direct_company_id as $item) {

                $get_direct_companys=
                    $ReportsDirectController->get_lvl_new('CampaignId', $item);

                ;

                $get_project = $ReportsDirectController->get_lvl_new_project('CampaignId', $item,'CampaignId','neiros_p2');

                $get_direct_companys->lead=$get_project;
                $get_direct_companys->sdelka=$get_project;
                $get_direct_companys->summ=0;

                $return['table'] .= $this->gettabledirect_new($get_direct_companys, $return, $report, $item,$get_project);


            }


        }
        if ($this->lvl == 3) {
            $direct_company_id = DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $this->my_company_id)->whereBetween('Date', $this->period)->where('CampaignId', $request->typ)->distinct('AdId')->pluck('AdId');
            foreach ($direct_company_id as $item) {


                $get_direct_companys = $ReportsDirectController->get_lvl_new('AdId', $item);

                $get_project = $ReportsDirectController->get_lvl_new_project('AdId', $item,'AdId','neiros_p3');

                $get_direct_companys->lead=$get_project;
                $get_direct_companys->sdelka=$get_project;
                $get_direct_companys->summ=0;

                $return['table'] .= $this->gettabledirect_new($get_direct_companys, $return, $report, $item);

            }


        }
        if ($this->lvl == 4) {
;            $direct_company_id = DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $this->my_company_id)->whereBetween('Date', $this->period)->where('AdId', $request->typ)->groupby('Query')->pluck('Query');
            foreach ($direct_company_id as $item) {


                $get_direct_companys = $ReportsDirectController->get_lvl_new('Query', $item);

                $get_project = $ReportsDirectController->get_lvl_new_project('Query', $item,'Query','neiros_p4');

                $get_direct_companys->lead=$get_project;
                $get_direct_companys->sdelka=$get_project;
                $get_direct_companys->summ=0;

                $return['table'] .= $this->gettabledirect_new($get_direct_companys, $return, $report, $item);

            }


        }


        $return['table'] .= view('reports.pritails.adwords.t_foot')->render();

        $return['dates'] = $this->period;
        $return['type'] = $report->type;
        return json_encode($return);
    }


    public function gettableadwords_new($repgroup, $return, $report, $item = null, $item2 = null)
    {
        $text = '';





            $hash = md5(rand(1, 99999999999));
            $newlvl = '';
            $namegroup = '';

            if ($this->lvl == 1) {
                $directINFO = $this->getadwordscost('AdNetworkType1', $item, $this->lvl);
                $namegroup = $item;
                if ($item == 'AD_NETWORK') {
                    $namegroup = 'РСЯ';
                }
                if ($item == 'SEARCH') {
                    $namegroup = 'ПОИСК';
                }
                if ($item == 'Search Network') {
                    $namegroup = 'ПОИСК';
                }



                if ($directINFO->count_group > 0) {
                    /*                    $newlvl = '<i class="fa fa-plus clickadwordslvl" style="color: blue;cursor: pointer;font-size: 10px;
                    color: #0878b4;" data-lvl="' . ($this->lvl + 1) . '" data-typ="' . $item . '"  data-report="' . $report->id . '" data-hash="m' . $hash . '" data-plus="0" data-opened="0"></i>';*/

                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="AdwordsApi" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';

                }
            }
            if ($this->lvl == 2) {
                $directINFO = $this->getadwordscost('CampaignId', $item, $this->lvl);
                $namegroup = $directINFO->CampaignName;
                if ($directINFO->count_group > 0) {
                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="AdwordsApi" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';


                }
            }
            if ($this->lvl == 3) {

                $directINFO = $this->getadwordscost('AdGroupId', $item, $this->lvl);

                $namegroup = $directINFO->AdGroupName;
                if ($directINFO->count_group > 0) {
                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="AdwordsApi" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';

                }
            }
            if ($this->lvl == 4) {
                ;
                $directINFO = $this->getadwordscost('Query', $item, $this->lvl);
                $namegroup = $directINFO->Query;
                if ($directINFO->count_group > 0) {
                    $newlvl = '' . $namegroup;

                }
            }

            $summ_rashod = round($directINFO->Cost / 1000000 * 1.2, 2);
            if ($repgroup->sdelka > 0) {

                $requrey = round($summ_rashod / $repgroup->sdelka, 2);
            } else {
                $requrey = 0;
            }

            /*ROI = (Выручка - размер вложений) / Размер вложений * 100%*/
            if ($summ_rashod > 0) {
                $roi = round(
                        ($repgroup->summ - $summ_rashod) /
                        $summ_rashod * 100, 2) . '%';
            } else {
                $roi = '';
            }


            $con_sd = $this->get_conversion($directINFO->Clicks, $repgroup->sdelka);
            $con_ld = $this->get_conversion($directINFO->Clicks, $repgroup->lead);

            $mass_width = request()->get('mass_width');
            $text .= view('reports.pritails.adwords.tr', compact('newlvl'
                , 'namegroup', 'hash', 'directINFO', 'repgroup', 'summ_rashod', 'requrey', 'roi', 'con_sd', 'con_ld', 'mass_width'))->render();


        return $text;
    }
    public function gettableadwords($get_direct_companys, $return, $report, $item = null, $item2 = null)
    {
        $text = '';


        foreach ($get_direct_companys as $repgroup) {


            $hash = md5(rand(1, 99999999999));
            $newlvl = '';
            $namegroup = '';
            if ($this->lvl == 0) {
                $namegroup = 'Adwords';
                $directINFO = $this->getadwordscost('CampaignId', $repgroup->cmp, $this->lvl);
                if ($directINFO->count_group > 0) {
                    $newlvl = '<i class="fa fa-plus clickadwordslvl" style="color: blue;cursor: pointer;font-size: 10px;
color: #0878b4;" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $repgroup->typ . '"  data-report="' . $report->id . '"  data-hash="m' . $hash . '" data-opened="0"  data-plus="0"></i>';
                }
            }
            if ($this->lvl == 1) {
                $directINFO = $this->getadwordscost('AdNetworkType1', $item, $this->lvl);
                $namegroup = $item;
                if ($item == 'AD_NETWORK') {
                    $namegroup = 'РСЯ';
                }
                if ($item == 'SEARCH') {
                    $namegroup = 'ПОИСК';
                }
                if ($directINFO->count_group > 0) {
                    /*                    $newlvl = '<i class="fa fa-plus clickadwordslvl" style="color: blue;cursor: pointer;font-size: 10px;
                    color: #0878b4;" data-lvl="' . ($this->lvl + 1) . '" data-typ="' . $item . '"  data-report="' . $report->id . '" data-hash="m' . $hash . '" data-plus="0" data-opened="0"></i>';*/

                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="AdwordsApi" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';

                }
            }
            if ($this->lvl == 2) {
                $directINFO = $this->getadwordscost('CampaignId', $item, $this->lvl);
                $namegroup = $directINFO->CampaignName;
                if ($directINFO->count_group > 0) {
                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="AdwordsApi" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';


                }
            }
            if ($this->lvl == 3) {

                $directINFO = $this->getadwordscost('AdGroupId', $item, $this->lvl);

                $namegroup = $directINFO->AdGroupName;
                if ($directINFO->count_group > 0) {
                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="AdwordsApi" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';

                }
            }
            if ($this->lvl == 4) {
                ;
                $directINFO = $this->getadwordscost('Query', $item, $this->lvl);
                $namegroup = $directINFO->Query;
                if ($directINFO->count_group > 0) {
                    $newlvl = '' . $namegroup;

                }
            }
            if ($this->lvl == 0) {

                $this->data_all['posetitel'] += $directINFO->Clicks;
                $this->data_all['visit'] += $directINFO->Clicks;
                $this->data_all['sdelka'] += $repgroup->sdelka;
                $this->data_all['lead'] += $repgroup->lead;
                $this->data_all['summ'] += $repgroup->summ;
                $this->data_all['conversionsd'] += $this->get_conversion($repgroup->visit, $repgroup->sdelka);
                $this->data_all['conversionld'] += $this->get_conversion($repgroup->visit, $repgroup->lead);
                $this->r++;

            }
            $summ_rashod = round($directINFO->Cost / 1000000 * 1.2, 2);
            if ($repgroup->sdelka > 0) {

                $requrey = round($summ_rashod / $repgroup->sdelka, 2);
            } else {
                $requrey = 0;
            }

            /*ROI = (Выручка - размер вложений) / Размер вложений * 100%*/
            if ($summ_rashod > 0) {
                $roi = round(
                        ($repgroup->summ - $summ_rashod) /
                        $summ_rashod * 100, 2) . '%';
            } else {
                $roi = '';
            }


            $con_sd = $this->get_conversion($directINFO->Clicks, $repgroup->sdelka);
            $con_ld = $this->get_conversion($directINFO->Clicks, $repgroup->lead);

            $mass_width = request()->get('mass_width');
            $text .= view('reports.pritails.adwords.tr', compact('newlvl'
                , 'namegroup', 'hash', 'directINFO', 'repgroup', 'summ_rashod', 'requrey', 'roi', 'con_sd', 'con_ld', 'mass_width'))->render();
        }

        return $text;
    }
    public function gettabledirect_new($repgroup, $return, $report, $item = null, $item2 = null,$get_project=null)
    {
        $text = '';


        /*  $direct_company = DB::table('direct_otchet_parcer_' . $this->my_company_id)->whereBetween('Date', $this->period)->distinct('CampaignId')->pluck('CampaignName', 'CampaignId');*/




            $hash = md5(rand(1, 99999999999));
            $newlvl = '';
            $namegroup = '';
            if ($this->lvl == 0) {
                $namegroup = 'Директ';
                $directINFO = $this->getdirectcost('CampaignId', $repgroup->cmp, $this->lvl);
                if ($directINFO->count_group > 0) {
                    $newlvl = '<i class="fa fa-plus clickdirectlvl" style="color: blue;cursor: pointer;font-size: 10px;
color: #0878b4;" data-lvl="' . ($this->lvl + 1) . '" data-typ="' . $repgroup->typ . '"  data-report="' . $report->id . '"  data-hash="m' . $hash . '" data-opened="0"  data-plus="0"></i>';
                }
            }
            if ($this->lvl == 1) {
                $directINFO = $this->getdirectcost('AdNetworkType', $item, $this->lvl);
                $namegroup = $item;
                if ($item == 'AD_NETWORK') {
                    $namegroup = 'РСЯ';
                }
                if ($item == 'SEARCH') {
                    $namegroup = 'ПОИСК';
                }
                if ($directINFO->count_group > 0) {
                    /*                    $newlvl = '<i class="fa fa-plus clickdirectlvl" style="color: blue;cursor: pointer;font-size: 10px;
                    color: #0878b4;" data-lvl="' . ($this->lvl + 1) . '" data-typ="' . $item . '"  data-report="' . $report->id . '" data-hash="m' . $hash . '" data-plus="0" data-opened="0"></i>';*/

                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="Директ" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';


                }
            }
            if ($this->lvl == 2) {
                $directINFO = $this->getdirectcost('CampaignId', $item, $this->lvl);
                $namegroup = $directINFO->CampaignName;
                if ($directINFO->count_group > 0) {
                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="Директ" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';

                }
            }
            if ($this->lvl == 3) {
                $directINFO = $this->getdirectcost('AdId', $item, $this->lvl);
                $namegroup = $directINFO->AdGroupName;
                if ($directINFO->count_group > 0) {
                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="Директ" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';

                }
            }
            if ($this->lvl == 4) {
                ;
                $directINFO = $this->getdirectcost('Query', $item, $this->lvl);
                $namegroup = $directINFO->Query;
                if ($directINFO->count_group > 0) {
                    $newlvl = '' . $namegroup;

                }
            }
            if ($this->lvl == 0) {

                $this->data_all['posetitel'] += $directINFO->Clicks;
                $this->data_all['visit'] += $directINFO->Clicks;
                $this->data_all['sdelka'] += $repgroup->sdelka;
                $this->data_all['lead'] += $repgroup->lead;
                $this->data_all['summ'] += $repgroup->summ;
                $this->data_all['conversionsd'] += $this->get_conversion($repgroup->visit, $repgroup->sdelka);
                $this->data_all['conversionld'] += $this->get_conversion($repgroup->visit, $repgroup->lead);
                $this->r++;

            }

            $summ_rashod = round($directINFO->Cost / 1000000 * 1.2, 2);

            if ($repgroup->sdelka > 0) {

                $requrey = round($summ_rashod / $repgroup->sdelka, 2);;
            } else {
                $requrey = 0;
            }
            if ($summ_rashod > 0) {
                $roi = round(($repgroup->summ - $summ_rashod) / $summ_rashod * 100, 2) . '%';
            } else {
                $roi = '';
            }

            $con_sd = $this->get_conversion($directINFO->Clicks, $repgroup->sdelka);
            $con_ld = $this->get_conversion($directINFO->Clicks, $repgroup->lead);
            $mass_width = request()->get('mass_width');
            $text .= view('reports.pritails.direct.tr', compact('newlvl'
                , 'namegroup', 'hash', 'directINFO', 'repgroup', 'summ_rashod', 'requrey', 'roi', 'con_sd', 'con_ld', 'mass_width'))->render();



        return $text;
    }

    public function gettabledirect($get_direct_companys, $return, $report, $item = null, $item2 = null,$get_project=null)
    {
        $text = '';


        /*  $direct_company = DB::table('direct_otchet_parcer_' . $this->my_company_id)->whereBetween('Date', $this->period)->distinct('CampaignId')->pluck('CampaignName', 'CampaignId');*/

        foreach ($get_direct_companys as $repgroup) {


            $hash = md5(rand(1, 99999999999));
            $newlvl = '';
            $namegroup = '';
            if ($this->lvl == 0) {
                $namegroup = 'Директ';
                $directINFO = $this->getdirectcost('CampaignId', $repgroup->cmp, $this->lvl);
                if ($directINFO->count_group > 0) {
                    $newlvl = '<i class="fa fa-plus clickdirectlvl" style="color: blue;cursor: pointer;font-size: 10px;
color: #0878b4;" data-lvl="' . ($this->lvl + 1) . '" data-typ="' . $repgroup->typ . '"  data-report="' . $report->id . '"  data-hash="m' . $hash . '" data-opened="0"  data-plus="0"></i>';
                }
            }
            if ($this->lvl == 1) {
                $directINFO = $this->getdirectcost('AdNetworkType', $item, $this->lvl);
                $namegroup = $item;
                if ($item == 'AD_NETWORK') {
                    $namegroup = 'РСЯ';
                }
                if ($item == 'SEARCH') {
                    $namegroup = 'ПОИСК';
                }
                if ($directINFO->count_group > 0) {
                    /*                    $newlvl = '<i class="fa fa-plus clickdirectlvl" style="color: blue;cursor: pointer;font-size: 10px;
                    color: #0878b4;" data-lvl="' . ($this->lvl + 1) . '" data-typ="' . $item . '"  data-report="' . $report->id . '" data-hash="m' . $hash . '" data-plus="0" data-opened="0"></i>';*/

                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="Директ" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';


                }
            }
            if ($this->lvl == 2) {
                $directINFO = $this->getdirectcost('CampaignId', $item, $this->lvl);
                $namegroup = $directINFO->CampaignName;
                if ($directINFO->count_group > 0) {
                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="Директ" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';

                }
            }
            if ($this->lvl == 3) {
                $directINFO = $this->getdirectcost('AdId', $item, $this->lvl);
                $namegroup = $directINFO->AdGroupName;
                if ($directINFO->count_group > 0) {
                    $newlvl = '<div class="more-data more-data-child2"><i style="display: none;" class="fa fa-minus" aria-hidden="true"></i> <i class="fa fa-plus" data-lvl="' . ($this->lvl + 1) . '" data-type="' . $item . '" data-typ="Директ" data-report="' . $report->id . '" data-hash="m' . $hash . '" aria-hidden="true" style="display: block;"></i><span>' . $namegroup . '</span><i style="display: none;" class="fa fa-spinner fa-spin  fa-fw"></i></div>';

                }
            }
            if ($this->lvl == 4) {
                ;
                $directINFO = $this->getdirectcost('AdId', $item, $this->lvl);
                $namegroup = $directINFO->Query;
                if ($directINFO->count_group > 0) {
                    $newlvl = '' . $namegroup;

                }
            }
            if ($this->lvl == 0) {

                $this->data_all['posetitel'] += $directINFO->Clicks;
                $this->data_all['visit'] += $directINFO->Clicks;
                $this->data_all['sdelka'] += $repgroup->sdelka;
                $this->data_all['lead'] += $repgroup->lead;
                $this->data_all['summ'] += $repgroup->summ;
                $this->data_all['conversionsd'] += $this->get_conversion($repgroup->visit, $repgroup->sdelka);
                $this->data_all['conversionld'] += $this->get_conversion($repgroup->visit, $repgroup->lead);
                $this->r++;

            }

            $summ_rashod = round($directINFO->Cost / 1000000 * 1.2, 2);

            if ($repgroup->sdelka > 0) {

                $requrey = round($summ_rashod / $repgroup->sdelka, 2);;
            } else {
                $requrey = 0;
            }
            if ($summ_rashod > 0) {
                $roi = round(($repgroup->summ - $summ_rashod) / $summ_rashod * 100, 2) . '%';
            } else {
                $roi = '';
            }


            $con_sd = $this->get_conversion($directINFO->Clicks, $repgroup->sdelka);
            $con_ld = $this->get_conversion($directINFO->Clicks, $repgroup->lead);
            $mass_width = request()->get('mass_width');
            $text .= view('reports.pritails.direct.tr', compact('newlvl'
                , 'namegroup', 'hash', 'directINFO', 'repgroup', 'summ_rashod', 'requrey', 'roi', 'con_sd', 'con_ld', 'mass_width'))->render();


        }

        return $text;
    }


    function get_conversion($all, $bingo)
    {

        $itog = 0;
        if ($all == 0) {
            return $itog;
        }
        $itog = round($bingo * 100 / $all, 2);
        return $itog;

    }


    public function amount_visit_table()
    {


        if ($this->lvl == 0) {
            $grop = array_keys($this->re_typ);
            $distinct = 'src';
        }
        if ($this->lvl == 1) {
            $grop = 'src';
            $distinct = 'cmp';
        }
        if ($this->lvl == 2) {
            $grop = 'cmp';
            $distinct = 'cnt';
        }

        if ($this->lvl == 3) {
            $grop = 'cnt';
            $distinct = 'trim';
        }
        if ($this->lvl == 4) {
            $grop = 'trim';
            $distinct = ' trim';
        }

        $MetricaCurrent = new MetricaCurrent();


        $result = $MetricaCurrent->setTable('metrica_' . $this->my_company_id)->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->where(function ($query) {

                foreach ($this->re_typ as $key => $val) {
                    if ($this->lvl > 1) {
                        for ($i = 0; $i < count($val); $i++) {
                            $query->where(function ($query) use ($key, $val, $i) {

                                $query->where($key, $val[$i]);


                            });

                        }
                    } else {

                        for ($i = 0; $i < count($val); $i++) {
                            $query->orwhere(function ($query) use ($key, $val, $i) {

                                $query->where($key, $val[$i]);


                            });

                        }

                    }


                }


            })->select('typ', 'src', 'cmp', 'trim', 'cnt',


                DB::raw($this->get_zapros('sdelka')),
                DB::raw($this->get_zapros('lead')),

                DB::raw($this->lvl . ' as lvl'),

                DB::raw($this->get_zapros('summ')),


                DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit'),
                DB::raw('count(DISTINCT(' . $distinct . ')) as count_group')
            )->groupBy($grop)->orderby('posetitel', 'desc')->get();

        return $result;

    }

    public function get_zapros($pole)
    {
        $text = 'sum(' . $pole . ') as ' . $pole;
        if ($this->canals > 0) {
            $text = 'sum(CASE  when widget_id=' . $this->canals . ' THEN ' . $pole . ' ELSE 0
 END) as ' . $pole . '';
        }
        return $text;

    }

    public function router($type_report, Request $request)
    {
        if ($request->canals > 0) {
            $this->canals = $request->canals;
        }

        $this->resourse_names = DB::table('reports_resourse')->pluck('name', 'code')->toArray();

        $user = Auth::user();
        DB::table('users')->where('id', $user->id)->update(['last_report' => $type_report]);
        $this->my_company_id = $user->my_company_id;
        $this->sites_id = [$user->site];//Sites::where('my_company_id', $this->my_company_id)->pluck('id');


        $this->format_period($request);
        if (isset($request->dashboard)) {
            $report = My_reports_dashboard::find($type_report);
        } else {
            $report = My_reports::find($type_report);
        }
        if (is_null($report->grouping)) {

            $this->grouping = DB::table('reports_groping')->get();
        } else {
            $this->grouping = DB::table('reports_groping')->wherein('id', $report->grouping)->get();
        }

        if ($report->type == 'line') {
            return $this->report_0($report, $request);
        }
        if ($report->type == 'funnel') {
            return $this->report_1($report, $request);
        }

    }


    public
    function format_period($request)
    {
        if (!isset($request->period_start) || is_null($request->period_start)) {
            $this->period_start = '2010-06-06';
        } else {
            $this->period_start = date('Y-m-d', strtotime($request->period_start));
        }
        if (!isset($request->period_end) || is_null($request->period_end)) {
            $this->period_end = date('Y-m-d');
        } else {
            $this->period_end = date('Y-m-d', strtotime($request->period_end));
        }

        $this->period = [$this->period_start, $this->period_end];

    }

    public
    function get_returns($leads, $visit = null, $posetitel = null, $sales = null, $costs = null)
    {

        /*+"reports_date": "2019-01-01"
  +"sdelka": "0"

  +"summ": "0"
   */
        for ($i = 0; $i < count($this->period); $i++) {


            if (isset($leads[$this->period[$i]])) {
                $data[$this->period[$i]]['sdelka'] = $leads[$this->period[$i]]->sdelka;
                $data[$this->period[$i]]['lead'] = $leads[$this->period[$i]]->lead;
                $data[$this->period[$i]]['visit'] = $leads[$this->period[$i]]->visit;
                $data[$this->period[$i]]['posetitel'] = $leads[$this->period[$i]]->posetitel;
                $data[$this->period[$i]]['summ'] = $leads[$this->period[$i]]->summ;
                $data[$this->period[$i]]['cost'] = 0;
                $data[$this->period[$i]]['conversion'] = $this->get_conversion($leads[$this->period[$i]]->visit, $leads[$this->period[$i]]->sdelka);
                $data[$this->period[$i]]['conversion_lead'] = $this->get_conversion($leads[$this->period[$i]]->visit, $leads[$this->period[$i]]->lead);
            } else {
                $data[$this->period[$i]]['sdelka'] = 0;
                $data[$this->period[$i]]['lead'] = 0;
                $data[$this->period[$i]]['visit'] = 0;
                $data[$this->period[$i]]['posetitel'] = 0;
                $data[$this->period[$i]]['summ'] = 0;
                $data[$this->period[$i]]['cost'] = 0;
                $data[$this->period[$i]]['conversion'] = 0;
                $data[$this->period[$i]]['conversion_lead'] = 0;
            }


            $return['sdelka'][] = $data[$this->period[$i]]['sdelka'];
            $return['lead'][] = $data[$this->period[$i]]['lead'];
            $return['visit'][] = $data[$this->period[$i]]['visit'];
            $return['posetitel'][] = $data[$this->period[$i]]['posetitel'];
            $return['summ'][] = $data[$this->period[$i]]['summ'];
            $return['cost'][] = $data[$this->period[$i]]['cost'];
            $return['conversion_lead'][] = $data[$this->period[$i]]['conversion_lead'];
            $return['conversion'][] = $data[$this->period[$i]]['conversion'];


        }


        return $return;
    }

    public function report_1($report, $request)
    {


        $sql = $this->get_zapros_for_day();


        $sql_cop = clone $sql;
        $this->projects_ids = $sql_cop->pluck('project_id')->toArray();
        $this->projects_ids = array_unique($this->projects_ids);

        $forI = 0;
        $return['names'] = [];
        $array_max = [];
        for ($i = 0; $i < count($report->resourse); $i++) {

            if ($report->resourse[$i] == 'lead') {
                $datain['sales'] = 1;
                $sales = $this->amount_lead_funnel($datain);;;

            }
            if ($report->resourse[$i] == 'posetitel') {
                $sales = $this->get_for_funnel('posetitel', $sql);;;

            }
            if ($report->resourse[$i] == 'sdelka') {
                $sales = $this->amount_lead_funnel([]);;

            }
            if ($report->resourse[$i] == 'visit') {

                $sales = $this->get_for_funnel('visit', $sql);

            }
            $return['series'][$forI]['data'] = $sales;
            $array_max[] = $sales;
            $return['series'][$forI]['name'] = $this->resourse_names[$report->resourse[$i]];
            $return['series'][$forI]['percent'] = 0;

            /*  0 => "sales"
              1 => "posetitel"
              2 => "leads"
              3 => "visits"*/


            $forI++;


        }
        $percent = max($array_max) / 100;

        $step = round(100 / count($return['series']));

        $price = array();
        foreach ($return['series'] as $key => $row) {
            $price[$key] = $row['data'];
        }
        array_multisort($price, SORT_DESC, $return['series']);

        $return['type'] = $report->type;
        $per = 100;
        for ($i = 0; $i < count($return['series']); $i++) {

            $return['series'][$i]['value'] = $per;
            $return['series'][$i]['name'] = $return['series'][$i]['name'] . '(' . $return['series'][$i]['data'] . ')' . '(' . round($return['series'][$i]['data'] / $percent, 2) . ')';


            $per = $per - $step;
        }


        return json_encode($return, JSON_UNESCAPED_UNICODE);
    }

    public
    function report_0($report, $request)
    {

        //

        /*groy_by day*/
        if ($request->group == 'day') {

            $sql = $this->get_zapros_for_day();
            $visit = $this->get_for_day('visits', $sql);


            $this->period_dat();

            $return = $this->get_returns($visit);


        }

        /*group week*/


        if (in_array($request->group, ['week', 'month'])) {

            if ($request->group == 'week') {
                $dateformat = '%u';
            }
            if ($request->group == 'month') {
                $dateformat = '%Y-%m';
            }
            $sql = $this->get_zapros_for_day();
            $visit = $this->amount_visit_month('visits', $sql, $dateformat);


            if ($request->group == 'week') {
                $this->period_week();
            }
            if ($request->group == 'month') {
                $this->period_month();
            }


            $return = $this->get_returns($visit);// dd($posetitel,$return);

        }


        $forI = 0;
        $return['names'] = [];
        for ($i = 0; $i < count($report->resourse); $i++) {

            $return['names'][] = $this->resourse_names[$report->resourse[$i]];
            $return['series'][$forI]['data'] = $return[$report->resourse[$i]];
            $return['series'][$forI]['name'] = $this->resourse_names[$report->resourse[$i]];
            $return['series'][$forI]['type'] = $request->type_charts;
            // $return['series'][$forI]['barGap'] = 'barGap';
            $forI++;


        }
        $rtd = [];
        if ($request->group == 'week') {
            $www = $this->period_week2();
            for ($io = 0; $io < count($www); $io++)
                $rtd[] = $www[$io];


        } else {
            for ($io = 0; $io < count($this->period); $io++) {

                $rtd[] = date('d.m.Y', strtotime($this->period[$io]));
            }


        }

        $return['dates'] = $rtd;// $this->period;
        $return['type'] = $request->type_charts;
        return json_encode($return, JSON_UNESCAPED_UNICODE);
    }

    public
    function amount_posetitel($data)
    {


        //   return  DB::connection('mongodb')->collection('metrica_test')->where('site_id',$this->sites_id)->distinct('hash')->count('hash');
        $MetricaCurrent = new MetricaCurrent();

        return $MetricaCurrent->setTable('metrica_' . $this->my_company_id)->wherein('site_id', $this->sites_id)->whereBetween('fd', $this->period)->distinct('hash')->count('hash');

    }


    public
    function amount_visit($data)
    {
        $MetricaCurrent = new MetricaCurrent();


        return $MetricaCurrent->setTable('metrica_' . $this->my_company_id)->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->count('id');


    }

    public
    function amount_lead_funnel($datain)
    {

        $data = DB::table('projects')->where('my_company_id', $this->my_company_id)->wherein('id', $this->projects_ids)
            ->where(function ($query) use ($datain) {
                if (isset($datain['sales'])) {
                    $query->where('summ', '>', 0);
                }

                /* if (is_numeric($request->stage)) {
                     $query->where('stage_id', $request->stage);
                 }*/

            })->whereBetween('created_at', $this->period)->count();

        return $data;


    }

    public
    function get_costs_dat()
    {


        return $data = DB::connection('neiros_direct1')->table('direct_otchet_parcer')->where('my_company_id', $this->my_company_id)->whereBetween('Date', $this->period)->select('Date', DB::raw('sum(Cost) as total'))
            ->groupBy('Date')->pluck('total', 'Date')->toArray();


    }

    public
    function amount_lead_day($datain)
    {

        $data = DB::table('projects')->where('my_company_id', $this->my_company_id)->wherein('id', $this->projects_ids)
            ->where(function ($query) use ($datain) {
                if (isset($datain['sales'])) {
                    $query->where('summ', '>', 0);
                }

                /* if (is_numeric($request->stage)) {
                     $query->where('stage_id', $request->stage);
                 }*/

            })->whereBetween('created_at', $this->period)->select('reports_date', DB::raw('count(*) as total', 'summ'))
            ->groupBy('reports_date')->pluck('total', 'reports_date')->toArray();

        return $data;


    }

    public
    function get_costs_wm($request, $dateformat)
    {
        return $data = DB::connection('neiros_direct1')->table('direct_otchet_parcer')->where('my_company_id', $this->my_company_id)->whereBetween('Date', $this->period)->select(DB::raw('DATE_FORMAT(Date, "' . $dateformat . '") as Date'), DB::raw('sum(Cost) as total'))
            ->groupBy(DB::raw('DATE_FORMAT(Date, "' . $dateformat . '")  '))->pluck('total', 'Date')->toArray();

    }

    public
    function amount_lead_month($request, $dateformat)
    {


        $data = DB::table('projects')->where('my_company_id', $this->my_company_id)->wherein('id', $this->projects_ids)
            ->where(function ($query) use ($request) {

                if (is_numeric($request->stage)) {
                    $query->where('stage_id', $request->stage);
                }
                if (is_numeric($request->summ)) {
                    $query->where('summ', '>', 0);
                }
            })->whereBetween('created_at', $this->period)
            ->select(DB::raw('DATE_FORMAT(reports_date, "' . $dateformat . '") as reports_date_week'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('DATE_FORMAT(reports_date, "' . $dateformat . '")'))->pluck('total', 'reports_date_week')->toArray();

        return $data;


    }

    public
    function get_zapros_for_day()
    {
        $MetricaCurrent = new MetricaCurrent();
        return $MetricaCurrent->setTable('metrica_' . $this->my_company_id)->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->where(function ($query) {

                foreach ($this->grouping as $item) {
                    $query->orwhere(function ($query) use ($item) {
                        $code_arr = explode('|', $item->code);
                        $pole_arr = explode('|', $item->pole);
                        for ($i = 0; $i < count($pole_arr); $i++) {
                            $query->where($pole_arr[$i], $code_arr[$i]);

                        }

                    });

                }

            });
    }
    function get_zapros_for_day_1($ar)
    {
        $MetricaCurrent = new MetricaCurrent();
        return $MetricaCurrent->setTable('metrica_' . $this->my_company_id)->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
             ->wherein('typ',$ar);
    }
    public
    function get_for_funnel($tip, $sql)
    {
        $result = [];
        $sql_copy = clone $sql;


        if ($tip == 'visits') {


            $result = $sql->count();;

        }
        if ($tip == 'posetitel') {
            $result = $sql_copy->select('hash')->groupby('hash')->get();//->count();
            $result = count($result);


        }


        return $result;
    }

    public
    function get_for_day($tip, $sql)
    {
        $data = [];
        $sql_copy = clone $sql;

        $result = $sql->select('reports_date',
            DB::raw($this->get_zapros('sdelka')), DB::raw($this->get_zapros('lead')),
            DB::raw($this->get_zapros('summ')), DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit')
        )->groupBy('reports_date')->get();
        foreach ($result as $item) {
            $data[$item->reports_date] = $item;
        }


        return $data;
    }


    public
    function amount_visit_month($tip, $sql, $dateformat)
    {


        $result = $sql->select(DB::raw('DATE_FORMAT(reports_date, "' . $dateformat . '") as reports_date_week'),
            DB::raw($this->get_zapros('sdelka')), DB::raw($this->get_zapros('lead')),
            DB::raw($this->get_zapros('summ')), DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit'))->groupBy(DB::raw('DATE_FORMAT(reports_date, "' . $dateformat . '")'))->get();
        foreach ($result as $item) {
            $data[$item->reports_date_week] = $item;
        }


        return $data;

    }

    function amount_visit_hours($tip, $sql, $dateformat)
    {


        $result = $sql->select(DB::raw('DATE_FORMAT(created_at, "' . $dateformat . '") as reports_date_week'),

            DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit'))->groupBy(DB::raw('DATE_FORMAT(created_at, "' . $dateformat . '")'))->get();
        foreach ($result as $item) {
            $data[$item->reports_date_week] = $item;
        }


        return $data;

    }

    public
    function amount_lead($request)
    {


        return Project::where('my_company_id', $this->my_company_id)->whereBetween('created_at', $this->period)->where(function ($query) use ($request) {

            if (is_numeric($request->stage)) {
                $query->where('stage_id', $request->stage);
            }
            if (is_numeric($request->summ)) {
                $query->where('summ', '>', 0);
            }
        });


    }


    public
    function period_dat()
    {
        $period = new DatePeriod(
            new DateTime($this->period_start),
            new DateInterval('P1D'),
            new DateTime($this->period_end . ' 23:59:59')
        );
        $arr = [];
        foreach ($period as $key => $value) {
            $arr[] = $value->format('Y-m-d');
        }
        $this->period = $arr;
    }

    public
    function period_month()
    {
        $period = new DatePeriod(
            new DateTime($this->period_start),
            new DateInterval('P1M'),
            new DateTime($this->period_end . ' 23:59:59')
        );
        $arr = [];
        foreach ($period as $key => $value) {
            $arr[] = $value->format('Y-m');
        }
        $this->period = $arr;
    }

    public function period_hour()
    {
        $data = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'
            , '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'];
        return $data;;
    }

    public
    function period_week()
    {
        $period = new DatePeriod(
            new DateTime($this->period_start),
            new DateInterval('P1W'),
            new DateTime($this->period_end . ' 23:59:59')
        );
        $arr = [];
        foreach ($period as $key => $value) {
            $arr[] = $value->format('W');
        }
        $this->period = $arr;
    }

    function period_week2()
    {
        $period = new DatePeriod(
            new DateTime($this->period_start),
            new DateInterval('P1W'),
            new DateTime($this->period_end . ' 23:59:59')
        );
        $arr = [];
        foreach ($period as $key => $value) {
            $ww = $this->getStartAndEndDate($value->format('W'), 2019);
            $arr[] = implode('-', $ww);
        }
        return $arr;
    }

    function getStartAndEndDate($week, $year)
    {
        $week = $week - 1;

        $time = strtotime("1 January $year", time());
        $day = date('w', $time);
        $time += ((7 * $week) + 1 - $day) * 24 * 3600;
        $return[0] = date('d.m', $time);
        $time += 6 * 24 * 3600;
        $return[1] = date('d.m', $time);
        return $return;
    }

    public function get_all()
    {
        $user = Auth::user();


        if (is_null($user->stat_start_date)) {
            $data['stat_start_date'] = date('Y-m-d', (time() - 86400 * 30));
        } else {
            $data['stat_start_date'] = $user->stat_start_date;
        }
        if (is_null($user->stat_end_date)) {
            $data['stat_end_date'] = date('Y-m-d');
        } else {
            $data['stat_end_date'] = $user->stat_end_date;
        }

        $data['last_report'] = $user->last_report;

        $prov_last_report = My_reports::where('my_company_id', $user->my_company_id)->where('id', $user->last_report)->first();
        if (!$prov_last_report) {
            $data['last_report'] = 1;
        }

        $data['canals'] = Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->get();


        $data['stages'] = Stage::where('my_company_id', $user->my_company_id)->get();

        $data['my_reports'] = My_reports::where('my_company_id', $user->my_company_id)->orwhere('my_company_id', 0)->get();

        if (count($data['my_reports']) > 0) {
            if (($user->last_report == 0) || (is_null($user->last_report))) {
                $data['last_report'] = 1;
            }

        } else {
            $data['last_report'] = 1;
        }

        $data['reports_gropings'] = Reports_groping::all();
        $data['reports_resourse'] = Reports_resourse::all();;
        return view('reports.index_new', $data);

    }

    public function anyData(Request $request)
    {

        $this->resourse_names = DB::table('reports_resourse')->pluck('name', 'code')->toArray();

        $user = Auth::user();

        if ($request->canals > 0) {
            $this->canals = $request->canals;
        }

        //DB::table('users')->where('id', $user->id)->update(['last_report' => $type_report]);
        $this->my_company_id = $user->my_company_id;
        $this->sites_id = [$user->site];
        Sites::where('my_company_id', $this->my_company_id)->pluck('id');


        $this->format_period($request);
        $type_report = 1;
        $report = My_reports::find($type_report);


        if (is_null($report->grouping)) {

            $this->grouping = DB::table('reports_groping')->get();
        } else {
            $this->grouping = DB::table('reports_groping')->wherein('id', $report->grouping)->get();
        }
        $this->all_group = DB::table('reports_groping')->pluck('table_name', 'name');


        /*   if ($report->type == 'line') {
               return $this->report_table_0($report, $request);
           }
           if ($report->type == 'funnel') {
               return $this->report_1($report, $request);
           }*/


        $data_to[] = '';

        foreach ($this->grouping as $item) {

            $code_arr = explode('|', $item->code);
            $pole_arr = explode('|', $item->pole);
            for ($i = 0; $i < count($pole_arr); $i++) {
                $array_group[] = $pole_arr[$i];
                $this->re_typ[$pole_arr[$i]][] = $code_arr[$i];
            }


        }
        if (isset($request->lvl)) {
            if ($request->lvl == 1) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;

            }
            if ($request->lvl == 2) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;
                $this->re_typ['src'][] = $request->src;

            }
            if ($request->lvl == 3) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;
                $this->re_typ['src'][] = $request->src;
                $this->re_typ['cmp'][] = $request->cmp;

            }
            if ($request->lvl == 4) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;

                $this->re_typ['src'][] = $request->src;
                $this->re_typ['cmp'][] = $request->cmp;
                $this->re_typ['cnt'][] = $request->cnt;

            }
            $this->lvl = $request->lvl;
        }


        if ($this->lvl == 0) {
            $grop = array_keys($this->re_typ);
            $distinct = 'src';
        }


        $this->re_typ['typ'][] = 'Директ';
        $this->re_typ['typ'][] = 'AdwordsApi';
       /* $this->re_typ['typ'][] = 'yandex_direct';*/


        if ($this->my_company_id == 40) {
            for ($r = 0; $r < count($this->re_typ['typ']); $r++) {
                if ($this->re_typ['typ'][$r] != 'utm') {
                    $array_vibor[] = $this->re_typ['typ'][$r];
                }

            }
        } else {

            $array_vibor = $this->re_typ['typ'];

        }
$array_vibor[]='cpc';
$array_vibor[]='social';

        $canals_array = WidgetCanal::where('my_company_id', $user->my_company_id)->where('site_id', $user->site)->pluck('code')->toArray();
        $array_vibor = array_merge($array_vibor, $canals_array);










        $info = DB::connection('neiros_metrica')->table('metrica_' . $this->my_company_id)
            ->wherein('typ', $array_vibor)->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->select('typ', 'src', 'cmp', 'trim', 'cnt',
                DB::raw($this->get_zapros('unique_visit')),
                DB::raw($this->get_zapros('cost')),
                DB::raw($this->get_zapros('sdelka')),
                DB::raw($this->get_zapros('lead')),

                DB::raw($this->get_zapros('summ')),

                DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit'),
                DB::raw('count(DISTINCT(' . $distinct . ')) as count_group')
            )
            ->groupBy($grop) ;


        $datares= Datatables::queryBuilder($info) ->make(true);
   $res_array=$datares->getOriginalContent();
   for($i=0;$i<count($res_array['data']);$i++){
 if($res_array['data'][$i]['typ']=='Директ'){


$data_diret=$this->get_direct_0_lvl();
$get_lead=$this->get_direct_lead(); 
     $res_array['data'][$i]['unique_visit']=$data_diret->posetitel;
     $res_array['data'][$i]['posetitel']=$data_diret->posetitel;
     $res_array['data'][$i]['visit']=$data_diret->posetitel;
     $res_array['data'][$i]['sdelka']=$get_lead;

     $res_array['data'][$i]['cost']=  $summ_rashod = round($data_diret->cost / 1000000 * 1.2, 2);;

 }elseif($res_array['data'][$i]['typ']=='AdwordsApi'){


           $data_diret=$this->get_adwords_0_lvl();
           $get_lead=$this->get_adwords_lead(); 
           $res_array['data'][$i]['unique_visit']=($data_diret->posetitel==0)?'':$data_diret->posetitel;
           $res_array['data'][$i]['posetitel']=($data_diret->posetitel==0)?'':$data_diret->posetitel;
           $res_array['data'][$i]['visit']=($data_diret->posetitel==0)?'':$data_diret->posetitel;
           $res_array['data'][$i]['sdelka']=$get_lead==0?"":$get_lead;
           $res_array['data'][$i]['lead']=$res_array['data'][$i]['lead']==0?'':$res_array['data'][$i]['lead'];
           $summ_rashod = round($data_diret->cost / 1000000 * 1.2, 2);
           $res_array['data'][$i]['cost']=$summ_rashod==0?'':$summ_rashod  ;

       }else{

     $res_array['data'][$i]['unique_visit']=$res_array['data'][$i]['unique_visit']==0?'':$res_array['data'][$i]['unique_visit'];
     $res_array['data'][$i]['posetitel']=$res_array['data'][$i]['posetitel']==0?'':$res_array['data'][$i]['posetitel'];
     $res_array['data'][$i]['visit']=$res_array['data'][$i]['visit']==0?'':$res_array['data'][$i]['visit'];
     $res_array['data'][$i]['sdelka']=$res_array['data'][$i]['sdelka']==0?'':$res_array['data'][$i]['sdelka'];
     $res_array['data'][$i]['lead']=$res_array['data'][$i]['lead']==0?'':$res_array['data'][$i]['lead'];

     $res_array['data'][$i]['cost']=$res_array['data'][$i]['cost']==0?'':$res_array['data'][$i]['cost'];

 }






   }


   return $res_array;

    }


    public function reportsconstruct()
    {

        $this->resourse_names = explode(',', request()->get('resourse_names'));
        $user = Auth::user();

        $this->my_company_id = $user->my_company_id;
        $this->sites_id = [$user->site];
        Sites::where('my_company_id', $this->my_company_id)->pluck('id');


        $this->format_period(request());
        $type_report = 1;

        $report = My_reports::find($type_report);


        if (is_null($report->grouping)) {

            $this->grouping = DB::table('reports_groping')->get();
        } else {
            $this->grouping = DB::table('reports_groping')->wherein('id', $report->grouping)->get();
        }
        $this->all_group = DB::table('reports_groping')->where('name', '!=', 'utm')->pluck('table_name', 'name');


        $data_to[] = '';

        foreach ($this->grouping as $item) {

            $code_arr = explode('|', $item->code);
            $pole_arr = explode('|', $item->pole);
            for ($i = 0; $i < count($pole_arr); $i++) {
                $array_group[] = $pole_arr[$i];
                $this->re_typ[$pole_arr[$i]][] = $code_arr[$i];
            }


        }
        if (isset($request->lvl)) {
            if ($request->lvl == 1) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;

            }
            if ($request->lvl == 2) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;
                $this->re_typ['src'][] = $request->src;

            }
            if ($request->lvl == 3) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;
                $this->re_typ['src'][] = $request->src;
                $this->re_typ['cmp'][] = $request->cmp;

            }
            if ($request->lvl == 4) {
                $this->re_typ = [];

                $this->re_typ['typ'][] = $request->typ;

                $this->re_typ['src'][] = $request->src;
                $this->re_typ['cmp'][] = $request->cmp;
                $this->re_typ['cnt'][] = $request->cnt;

            }
            $this->lvl = $request->lvl;
        }


        if ($this->lvl == 0) {
            $grop = array_keys($this->re_typ);
            $distinct = 'src';
        }


        $this->re_typ['typ'][] = 'Директ';
        $this->re_typ['typ'][] = 'AdwordsApi';
    /*    $this->re_typ['typ'][] = 'yandex_direct';*/



            for ($r = 0; $r < count($this->re_typ['typ']); $r++) {
                if ($this->re_typ['typ'][$r] != 'utm') {
                    $array_vibor[] = $this->re_typ['typ'][$r];
                }

            }

        $canals_array = WidgetCanal::where('my_company_id', $user->my_company_id)->where('site_id', $user->site)->pluck('code')->toArray();
        $array_vibor = array_merge($array_vibor, $canals_array);
        $info = DB::connection('neiros_metrica')->table('metrica_' . $this->my_company_id)->wherein('typ', $array_vibor)->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->select('typ', 'reports_date',
                DB::raw($this->get_zapros('sdelka')),
                DB::raw($this->get_zapros('sdelka')),
                DB::raw($this->get_zapros('lead')),
                DB::raw($this->get_zapros('cost')),
                DB::raw($this->get_zapros('summ')),
                DB::raw('count(DISTINCT(neiros_visit)) as posetitel'),
                DB::raw('count(id) as visit'),
                DB::raw('count(DISTINCT(' . $distinct . ')) as count_group')
            );
        if (!request()->has('nogroup')) {
            $info->groupBy($grop);
        }
        $infor = $info->get();

        if (request()->has('group')) {

            if (request()->get('group') == 'hours') {
                $array1 = [];
                $period = $hours = $this->period_hour();
                $infor = $this->report_100($hours);
                for ($ip = 0; $ip < count($period); $ip++) {


                    if (isset($infor[$period[$ip]])) {

                        foreach ($infor[$period[$ip]] as $key1 => $val1) {
                            if (in_array($key1, $this->resourse_names)) {

                                $array1['h-' . $period[$ip]][$key1] = $val1;
                            }
                        }
                    } else {

                        for ($n = 0; $n < count($this->resourse_names); $n++) {
                            $array1[$period[$ip]][$this->resourse_names[$n]] = 0;
                        }


                    }


                }
            }


            if (request()->get('group') == 'day') {
                $infor = $this->report_99($array_vibor);
                $this->period_dat();
                $array1 = [];

                for ($ip = 0; $ip < count($this->period); $ip++) {

                    foreach ($infor as $key1 => $val1) {


                        if (!request()->has('nogroup')) {
                            if ($key1 == 'typ') {
                                $array1[$this->period[$ip]] = $val1[$ip];
                            }
                        }
                        if (in_array($key1, $this->resourse_names)) {

                            $array1[$this->period[$ip]][$key1] = $val1[$ip];
                        }


                    }


                }

            }


            if (request()->get('group') == 'month' || request()->get('group') == 'week') {

                $period = $this->period;
                if (request()->get('group') == 'month') {
                    $infor = $this->report_99();;
                    $this->period_month();
                }
                if (request()->get('group') == 'week') {
                    $infor = $this->report_99();;
                    $this->period_week();
                }


                $array1 = [];

                for ($ip = 0; $ip < count($period); $ip++) {

                    foreach ($infor as $key1 => $val1) {


                        if (!request()->has('nogroup')) {
                            if ($key1 == 'typ') {
                                $array1[$period[$ip]] = $val1[$ip];
                            }
                        }

                        if (in_array($key1, $this->resourse_names)) {

                            $array1[$period[$ip]][$key1] = $val1[$ip];
                        }


                    }


                }

            }


            /*group week*/


        } else {

            $array1 = [];
            $i = 0;
            foreach ($infor as $key1 => $val1) {

                foreach ($val1 as $key => $val) {
                    if (!request()->has('nogroup')) {
                        if ($key == 'typ') {
                            $array1[$i][$key] = $val;
                        }
                    }
                    if (in_array($key, $this->resourse_names)) {

                        $array1[$i][$key] = $val;
                    }
                }
                $i++;


            }
        }


        return json_encode($array1);


    }

    function report_100($hours)
    {
        $dateformat = '%H';
        $sdelki = Project::where('site_id', auth()->user()->site)->whereBetween('reports_date', $this->period)
            ->select(\DB::raw('COUNT(id) as sdelka'), DB::raw('DATE_FORMAT(created_at, "' . $dateformat . '") as reports_date_week'))->groupby('hour')->pluck('sdelka', 'reports_date_week')->toArray();
        $lead = Project::where('site_id', auth()->user()->site)->where('summ', '>', 0)->whereBetween('reports_date', $this->period)
            ->select(\DB::raw('COUNT(id) as sdelka'), DB::raw('DATE_FORMAT(created_at, "' . $dateformat . '") as reports_date_week'))->groupby('hour')->pluck('sdelka', 'reports_date_week')->toArray();
        $summ = Project::where('site_id', auth()->user()->site)->whereBetween('reports_date', $this->period)
            ->select(\DB::raw('SUM(summ) as summ'), DB::raw('DATE_FORMAT(created_at, "' . $dateformat . '") as reports_date_week'))->groupby('hour')->pluck('summ', 'reports_date_week')->toArray();;
        $dateformat = '%H';

        $sql = $this->get_zapros_for_day();
        $visit = $this->amount_visit_hours('visits', $sql, $dateformat);


        $array_return = [];
        for ($i = 0; $i < count($hours); $i++) {

            if (isset($sdelki[$hours[$i]])) {
                $array_return[$hours[$i]]['sdelka'] = $sdelki[$hours[$i]];
            } else {
                $array_return[$hours[$i]]['sdelka'] = 0;
            }
            if (isset($lead[$hours[$i]])) {
                $array_return[$hours[$i]]['lead'] = $lead[$hours[$i]];
            } else {
                $array_return[$hours[$i]]['lead'] = 0;
            }
            if (isset($summ[$hours[$i]])) {
                $array_return[$hours[$i]]['summ'] = $summ[$hours[$i]];
            } else {
                $array_return[$hours[$i]]['summ'] = 0;
            }

            if (isset($visit[$hours[$i]])) {
                $array_return[$hours[$i]]['posetitel'] = $visit[$hours[$i]]->posetitel;
                $array_return[$hours[$i]]['visit'] = $visit[$hours[$i]]->visit;
            } else {
                $array_return[$hours[$i]]['posetitel'] = 0;
                $array_return[$hours[$i]]['visit'] = 0;
            }


        }


        return $array_return;

    }

    function report_99($array_vibor)
    {

        //

        /*groy_by day*/
        if (request()->group == 'day') {

            $sql = $this->get_zapros_for_day_1($array_vibor);
            $visit = $this->get_for_day('visits', $sql);


            $this->period_dat();

            $return = $this->get_returns($visit);


        }

        /*group week*/


        if (in_array(request()->group, ['week', 'month'])) {

            if (request()->group == 'week') {
                $dateformat = '%u';
            }
            if (request()->group == 'month') {
                $dateformat = '%Y-%m';
            }
            $sql = $this->get_zapros_for_day();
            $visit = $this->amount_visit_month('visits', $sql, $dateformat);


            if (request()->group == 'week') {
                $this->period_week();
            }
            if (request()->group == 'month') {
                $this->period_month();
            }


            $return = $this->get_returns($visit);// dd($posetitel,$return);

        }

        return $return;;
    }
}
