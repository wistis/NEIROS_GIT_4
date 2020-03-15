<?php

namespace App\Http\Controllers;

use App\Models\MetrikaCurrentRegion;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Models\MetricaCurrent;
use DB;
use Log;
use Hisune\EchartsPHP\ECharts;

class CallStaticController extends Controller
{


    private $user;
    private $stat_start_date;
    private $stat_end_date;

    function __construct( )
    {



    }

    public function generate_1()
    {
        $widgets = DB::table('widgets')->where('tip', 1)->get()/*->where('my_company_id',$user->my_company_id)*/
        ;
        foreach ($widgets as $widget) {
            $a = mktime(0, 0, 0, 10, 01, 2018);
            $b = mktime(1, 0, 0, 11, 30, 2018);
            while ($a <= $b) {


                $k = ["organic", "referral", "typein", "utm"];

                /* echo date('Y.m.d',$a)."<br />\r\n";*/
                $stdate = date('Y-m-d 00:00:00', $a);
                $endate = date('Y-m-d 23:59:59', $a);

                $get_projects_ids = DB::table('projects')->where('my_company_id', $widget->my_company_id)
                    ->where('widget_id', $widget->id)->whereBetween('created_at', [$stdate, $endate])
                    ->pluck('id')->toArray();

                $get_projects_ids_uniq = DB::table('projects')->where('my_company_id', $widget->my_company_id)
                    ->where('widget_id', $widget->id)->whereBetween('created_at', [$stdate, $endate])->groupby('phone')
                    ->pluck('id');


                for ($i = 0; $i < 4; $i++) {
                    $data[$k[$i]] = array();
                    $MetricaCurrent=new MetricaCurrent();

                    $data['x'] = $MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                        ->wherein('project_id', $get_projects_ids)
                        ->where('typ', $k[$i])->distinct('project_id')
                        ->count();

                    $MetricaCurrent=new MetricaCurrent();
                    $data['zz'] =$MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                        ->wherein('project_id', $get_projects_ids)
                        ->where('typ', $k[$i])->groupby('project_id')
                        ->pluck('project_id')->toArray();
                    $MetricaCurrent=new MetricaCurrent();
                    $data['y'] = $MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                        ->wherein('project_id', $get_projects_ids)
                        ->where('typ', $k[$i])->distinct('project_id')->distinct('project_id')
                        ->distinct('olev_phone_track')
                        ->count();
                    /* `call_amount`(`id`, `amount`, `date`, `site_id`, `widget_id`, `my_company_id`, `amount_uniq`)*/
                    if ($data['x'] > 0) {
                        if (count($data['zz']) > 0) {
                            $ids = implode(',', $data['zz']);
                        } else {
                            $ids = '';
                        }
                        DB::table('call_amount')->insert([
                            'amount' => $data['x'],
                            'date' => date('Y-m-d', $a),
                            'site_id' => $widget->sites_id,
                            'my_company_id' => $widget->my_company_id,
                            'amount_uniq' => $data['y'],
                            'typ' => $k[$i],
                            'widget_tip' => $widget->tip,
                            'project_ids' => $ids,
                            'week' => date('W', $a),
                            'month' => date('m', $a),

                        ]);
                    }
                }

                $a += 86400;
            }


        }


    }

    public function generate_2()
    {
        $widgets = DB::table('widgets')->where('tip', 1)->get();

        foreach ($widgets as $widget) {
            $a = mktime(0, 0, 0, 10, 01, 2018);
            $b = mktime(1, 0, 0, 11, 30, 2018);
            while ($a <= $b) {


                $k = ["organic", "referral", "typein", "utm"];

                /* echo date('Y.m.d',$a)."<br />\r\n";*/
                $stdate = date('Y-m-d 00:00:00', $a);
                $endate = date('Y-m-d 23:59:59', $a);

                $get_projects_ids = DB::table('projects')->where('my_company_id', $widget->my_company_id)
                    ->where('widget_id', $widget->id)->whereBetween('created_at', [$stdate, $endate])
                    ->pluck('id');


                for ($i = 0; $i < 4; $i++) {
                    $data[$k[$i]] = array();
                    $MetricaCurrent=new MetricaCurrent();

                    $alls =$MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                        ->wherein('project_id', $get_projects_ids)
                        ->where('typ', $k[$i])
                        //
                        ->groupby('src')
                        ->get();;

                    foreach ($alls as $all) {
                        $am = 0;
                        $data['all'] = $all;
                        $MetricaCurrent=new MetricaCurrent();
                        $am = $MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                            ->where('typ', $k[$i])
                            ->where('src', $all->src)->wherein('project_id', $get_projects_ids)->distinct('project_id')
                            ->count();
                        $MetricaCurrent=new MetricaCurrent();
                        $am2 = $MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                            ->where('typ', $k[$i])
                            ->where('src', $all->src)->wherein('project_id', $get_projects_ids)->distinct('project_id')->distinct('olev_phone_track')
                            ->count();

                        $MetricaCurrent=new MetricaCurrent();
                        $amz =$MetricaCurrent->setTable('metrica_'.$widget->my_company_id)->whereBetween('fd', [$stdate, $endate])
                            ->where('typ', $k[$i])
                            ->where('src', $all->src)->wherein('project_id', $get_projects_ids)->groupby('hash')
                            ->first();
                        $MetricaCurrent=new MetricaCurrent();
                        $amxxx =$MetricaCurrent->setTable('metrica_'.$widget->my_company_id)->whereBetween('fd', [$stdate, $endate])
                            ->where('typ', $k[$i])
                            ->where('src', $all->src)->wherein('project_id', $get_projects_ids)->distinct('project_id')
                            ->pluck('project_id')->toArray();


                        //}  $data['y']=$this->get_all_call_uniq($k[$i],$all->src);;
                        if ($am > 0) {
                            $MetricaCurrent=new MetricaCurrent();
                            $amxxx =$MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                                ->where('typ', $k[$i])
                                ->where('src', $all->src)->wherein('project_id', $get_projects_ids)->distinct('project_id')
                                ->pluck('project_id')->toArray();


                            DB::table('call_amount_2')->insert([
                                'amount' => $am,
                                'date' => date('Y-m-d', $a),
                                'site_id' => $widget->sites_id,
                                'my_company_id' => $widget->my_company_id,
                                'amount_uniq' => $am2,
                                'typ' => $k[$i],
                                'widget_tip' => $widget->tip,
                                'src' => $all->src,
                                'project_ids' => implode(',', $amxxx),
                                'week' => date('W', $a),
                                'month' => date('m', $a),

                            ]);
                        }

                    }

                    /* `call_amount`(`id`, `amount`, `date`, `site_id`, `widget_id`, `my_company_id`, `amount_uniq`)*/

                }

                $a += 86400;
            }


        }


    }

    public function generate_3()
    {
        $widgets = DB::table('widgets')->where('tip', 1)->get();

        foreach ($widgets as $widget) {
            $a = mktime(0, 0, 0, 01, 01, 2018);
            $b = mktime(1, 0, 0, 07, 07, 2018);
            while ($a <= $b) {


                $k = ["utm"];

                /* echo date('Y.m.d',$a)."<br />\r\n";*/
                $stdate = date('Y-m-d 00:00:00', $a);
                $endate = date('Y-m-d 23:59:59', $a);

                $get_projects_ids = DB::table('projects')->where('my_company_id', $widget->my_company_id)
                    ->where('widget_id', $widget->id)->whereBetween('created_at', [$stdate, $endate])
                    ->pluck('id');


                for ($i = 0; $i < 1; $i++) {
                    $data[$k[$i]] = array();

                    $MetricaCurrent=new MetricaCurrent();
                    $alls = $MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                        ->wherein('project_id', $get_projects_ids)
                        ->where('typ', $k[$i])
                        //
                        ->groupby('src')
                        ->get();;

                    foreach ($alls as $all) {
                        $MetricaCurrent=new MetricaCurrent();
                        $alls2 = $MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                            ->wherein('project_id', $get_projects_ids)
                            ->where('typ', $k[$i])
                            ->where('src', $all->src)
                            //
                            ->groupby('trim')
                            ->get();;

                        foreach ($alls2 as $all2) {
                            $am = 0;
                            $data['all'] = $all;
                            $MetricaCurrent=new MetricaCurrent();
                            $am = $MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                                ->where('typ', $k[$i])
                                ->where('src', $all2->src)
                                ->where('trim', $all2->trim)
                                ->wherein('project_id', $get_projects_ids)->distinct('project_id')
                                ->count();
                            $MetricaCurrent=new MetricaCurrent();
                            $am2 = $MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                                ->where('typ', $k[$i])
                                ->where('src', $all2->src)
                                ->where('trim', $all2->trim)
                                ->wherein('project_id', $get_projects_ids)->distinct('project_id')->distinct('olev_phone_track')
                                ->count();


                            if ($am > 0) {
                                $MetricaCurrent=new MetricaCurrent();
                                $amxxx = $MetricaCurrent->setTable('metrica_'.$widget->my_company_id)
                                    ->where('typ', $k[$i])
                                    ->where('src', $all2->src)->where('trim', $all2->trim)->wherein('project_id', $get_projects_ids)->distinct('project_id')
                                    ->pluck('project_id')->toArray();


                                DB::table('call_amount_3')->insert([
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
                                    'week' => date('m', $a),
                                    'month' => date('m', $a),
                                ]);
                            }


                        }


                    }

                    /* `call_amount`(`id`, `amount`, `date`, `site_id`, `widget_id`, `my_company_id`, `amount_uniq`)*/

                }

                $a += 86400;
            }


        }


    }

    public function generate_4()
    {
        $projects = DB::table('projects')->get();
        foreach ($projects as $project) {

            $week = date("W", strtotime($project->created_at));
            $hour = date("H", strtotime($project->created_at));

            DB::table('projects')->where('id', $project->id)->update([
                'hour' => $hour,
                'week' => $week

            ]);


        }


    }


    public function other_start_load_data($fruit)
    {
        $user = Auth::user();
        $widget = DB::table('widgets')->wherein('tip', $fruit)->where('my_company_id', $user->my_company_id)->pluck('id');


        return $this->get_carts_hour($widget, $fruit);


    }

    public function other_all_region($fruit)
    {
        $user = Auth::user();


        return $this->get_carts_5($fruit);


    }

    public function other_all_call($fruit)
    {
        $user = Auth::user();


        return $this->get_carts_4($fruit);


    }

    public function other_start_load_week($fruit)
    {
        $user = Auth::user();
        $widget = DB::table('widgets')->wherein('tip', $fruit)->where('my_company_id', $user->my_company_id)->pluck('id');


        return $this->get_carts_week($widget);


    }


    public function index()
    {

        $user = Auth::user();


        $data['chart'] = $this->get_carts([1, 2]);
        $data['stat_start_date'] = $this->stat_start_date;
        $data['stat_end_date'] = $this->stat_end_date;


        return view('stat.callback', $data);
    }

    public function chart_stolbik($date, $data, $name, $i)
    {

        $chart = new ECharts();
        $chart->tooltip->show = true;
        $chart->legend->data[] = $name;
        $chart->title->text = $name;
        $chart->xAxis[] = array(
            'type' => 'category',
            'data' => $date,

        );
        $yAxis = new \Hisune\EchartsPHP\Doc\IDE\YAxis();
        //$yAxis = new YAxis();
        $yAxis->type = 'value';
        $chart->addYAxis($yAxis);

        $chart->series[] = array(
            'name' => 'Час',
            'type' => 'bar',
            'data' => $data
        );

        return $chart->render('simple-custom-id' . $i);
    }

    public function other()
    {

        $user = Auth::user();


        $data['chart'] = $this->other_start_load_data([1, 2]);;


        $data['stat_start_date'] = $this->stat_start_date;
        $data['stat_end_date'] = $this->stat_end_date;
        return view('stat.other', $data);

    }

    public function other_ajax(Request $request)
    {
        $data['chart'] = $this->other_start_load_data($request->fruit);;
        $data['chart_week'] = $this->other_start_load_week($request->fruit);;
        $data['chart_all'] = $this->other_all_call($request->fruit);;
        $data['chart_region'] = $this->other_all_region($request->fruit);;

        return json_encode($data);

    }

    public function get_carts_hour($widget, $fruit)
    {
        $user = Auth::user();

        /*    $get_projects_ids=DB::table('projects')->where('my_company_id', $user->my_company_id)
        ->where('widget_id', $widget->id)->whereBetween('created_at',[ $stdate,$endate])
        ->pluck('id');*/

        $stdate = date('Y-m-d 00:00:00', strtotime($user->stat_start_date));
        $endate = date('Y-m-d 23:59:59', strtotime($user->stat_end_date));


        $data_array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24];

        for ($i = 1; $i < 24; $i++) {


            $ch = DB::table('projects')->where('my_company_id', $user->my_company_id)->wherein('widget_id', $widget)
                ->whereBetween('created_at', [$stdate, $endate])->where('hour', $data_array[$i])
                ->count();
            $dataz [] = $ch;

        }

        return $this->chart_stolbik($data_array, $dataz, 'Звонки по часам', 1);
    }

    public function get_carts_week($widget)
    {
        $user = Auth::user();

        /*    $get_projects_ids=DB::table('projects')->where('my_company_id', $user->my_company_id)
        ->where('widget_id', $widget->id)->whereBetween('created_at',[ $stdate,$endate])
        ->pluck('id');*/

        $stdate = date('W', strtotime($user->stat_start_date));
        $endate = date('W', strtotime($user->stat_end_date));

        $data_array=[];
        if($stdate==$endate){
            $data_array[] = $endate;
            $ch = DB::table('projects')->where('my_company_id', $user->my_company_id)
                ->where('week', $endate)->wherein('widget_id', $widget)
                ->count();
            $dataz [] = $ch;


        }elseif ($stdate>$endate){
            for ($i = (int)$stdate; $i <=  52; $i++) {

                $data_array[] = $i;
                $ch = DB::table('projects')->where('my_company_id', $user->my_company_id)
                    ->where('week', $i)->wherein('widget_id', $widget)
                    ->count();
                $dataz [] = $ch;

            }
            for ($i = (int)1; $i <=  $endate; $i++) {

                $data_array[] = $i;
                $ch = DB::table('projects')->where('my_company_id', $user->my_company_id)
                    ->where('week', $i)->wherein('widget_id', $widget)
                    ->count();
                $dataz [] = $ch;

            }

        }else{




        }




        for ($i = (int)$stdate; $i <= $endate; $i++) {

            $data_array[] = $i;
            $ch = DB::table('projects')->where('my_company_id', $user->my_company_id)
                ->where('week', $i)->wherein('widget_id', $widget)
                ->count();
            $dataz [] = $ch;

        }

        return $this->chart_stolbik($data_array, $dataz, 'Звонки по неделям', 2);

    }

    public function get_carts($fruit, $tip = null)
    {
        $user = Auth::user();


        if ($tip== 0) {
        $tips = 'line';
    } else {
        $tips = 'bar';
    }


  /* if($tip==0) {
       $chart_dates = DB::table('call_amount')->where('my_company_id', $user->my_company_id)
           ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])->wherein('widget_tip', $fruit)->
           groupby('date')->pluck('date')->toArray();
   }
        if($tip==1) {
            $chart_dates = DB::table('call_amount')->where('my_company_id', $user->my_company_id)
                ->whereBetween('week', [$week_start, $week_end])->wherein('widget_tip', $fruit)->
                groupby('date')->pluck('week')->toArray();
        }*/






        $week_start=date('W',strtotime($this->stat_start_date)) ;
        $week_end=date('W',strtotime($this->stat_end_date)) ;


        $month_start=date('m',strtotime($this->stat_start_date))-1;
        $month_end=date('m',strtotime($this->stat_end_date)) ;

        $a = strtotime($user->stat_start_date);
        $b = strtotime($user->stat_end_date);
        $data_array = array();
       if($tip==0) {
           while ($a <= $b) {

               $data_array[] = date('d-m-Y', $a);
               $a += 86000;
           }
       }
        if($tip==1) {
            while ($week_start <= $week_end) {

                $data_array[] =$week_start   ;
                $week_start +=1;
            }
        }
        if($tip==2) {
            while ($month_start <= $month_end) {

                $data_array[] =$month_start   ;
                $month_start +=1;
            }
        }

        $k = ["organic", "referral", "typein", "utm"];
        for ($i = 0; $i < 4; $i++) {

            $dataz[$i]['name'] = $k[$i];
            for ($y = 0; $y < count($data_array); $y++) {

                if($tip==0) {
                    $x = DB::table('call_amount')->where('my_company_id', $user->my_company_id)->where('typ', $k[$i])->wherein('widget_tip', $fruit)
                        ->where('date', date("Y-m-d", strtotime($data_array[$y])))
                        ->sum('amount');
                    $dataz[$i]['data'][] = $x;
                }
                if($tip==1){
                    $x = DB::table('call_amount')->where('my_company_id', $user->my_company_id)->where('typ', $k[$i])->wherein('widget_tip', $fruit)
                        ->where('week',  $data_array[$y] )
                        ->sum('amount');
                    $dataz[$i]['data'][] = $x;

                }
                if($tip==2){
                    $x = DB::table('call_amount')->where('my_company_id', $user->my_company_id)->where('typ', $k[$i])->wherein('widget_tip', $fruit)
                        ->where('month',  $data_array[$y] )
                        ->sum('amount');
                    $dataz[$i]['data'][] = $x;

                }
            }
        }



        return $this->chartLine($data_array,
            $dataz, 'График', $tips);
    }

    public function get_carts_5($fruit)
    {
        $user = Auth::user();


        $widget = DB::table('widgets')->wherein('tip', $fruit)->where('my_company_id', $user->my_company_id)->pluck('id');

         $date_end=date('Y-m-d',strtotime('+ 1 day',strtotime($user->stat_end_date)));
        $neiros_visit=Project::where('my_company_id', $user->my_company_id)->wherein('widget_id', $widget)
            ->whereBetween('projects.created_at', [$user->stat_start_date,$date_end ])->pluck('neiros_visit');

   $x=MetrikaCurrentRegion::wherein('neiros_visit',$neiros_visit)->distinct('city')->pluck('city')->toArray();
        $data = array();
        array_unique($x);
        for ($i = 0; $i < count($x); $i++) {

            $proje = DB::table('projects')
                ->where('my_company_id', $user->my_company_id)->wherein('widget_id', $widget)
                ->whereBetween('created_at', [$user->stat_start_date, $date_end])->pluck('neiros_visit')->toArray();
            array_unique($proje);
            $x1 = DB::table('metrika_current_region')
                ->wherein('neiros_visit', $proje)->where('city', $x[$i])->select('neiros_visit')->distinct('neiros_visit')->get();


            $data[$i]['value'] = count($x1);
            $data[$i]['name'] = $x[$i];

        }


        return $this->chartpie($x,
            $data, 'Звоник по регионам', 3
        );
    }


    public function get_carts_4($fruit)
    {
        $user = Auth::user();

        $a = strtotime($user->stat_start_date);
        $b = strtotime($user->stat_end_date);
        $data_array = array();
        while ($a <= $b) {

            $data_array[] = date('d-m-Y', $a);
            $a += 86000;
        }

        $k = ["organic"];

        $i = 0;
        $dataz[$i]['name'] = '';
        for ($y = 0; $y < count($data_array); $y++) {
            $x = DB::table('call_amount')->where('my_company_id', $user->my_company_id)->wherein('widget_tip', $fruit)->wherein('widget_tip', $fruit)
                ->where('date', date("Y-m-d", strtotime($data_array[$y])))
                ->sum('amount');
            $dataz[$i]['data'][] = $x;


        }

        return $this->chartLine($data_array,
            $dataz, 'Общая динамика звонков', 3
        );
    }

    public function get_carts_2($typ, $src, $fruit,$tip)
    {
        $user = Auth::user();
        $dataz = [];
        $chart_dates = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('typ', $typ)->wherein('widget_tip', $fruit)
            ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])->
            groupby('date')->pluck('date')->toArray();
        if ($tip== 0) {
            $tips = 'line';
        } else {
            $tips = 'bar';
        }
        $a = strtotime($user->stat_start_date);
        $b = strtotime($user->stat_end_date);
        $week_start=date('W',strtotime($this->stat_start_date)) ;
        $week_end=date('W',strtotime($this->stat_end_date));


        $month_start=date('m',strtotime($this->stat_start_date))-1;
        $month_end=date('m',strtotime($this->stat_end_date));



        $data_array = array();
        if($tip==0) {
            while ($a <= $b) {

                $data_array[] = date('d-m-Y', $a);
                $a += 86000;
            }
        }
        if($tip==1) {
            $week_start1=$week_start;
            while ($week_start1 <= $week_end) {

                $data_array[] =$week_start1   ;
                $week_start1 +=1;
            }
        }
        if($tip==2) {
            $month_start1=$month_start;
            while ($month_start1 <= $month_end) {

                $data_array[] =$month_start1   ;
                $month_start1 +=1;
            }
        }
        if($tip==0) {
            $xys = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('typ', $typ)->where('amount', '>', 0)->wherein('widget_tip', $fruit)
                ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])->groupby('src')
                ->get();
        }
        if($tip==1) {
            $xys = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('typ', $typ)->where('amount', '>', 0)->wherein('widget_tip', $fruit)
                ->whereBetween('week', [$week_start, $week_end])->groupby('src')
                ->get();
        }
        Log::info($week_start);
        Log::info($week_end);
        if($tip==2) {
            $xys = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('typ', $typ)->where('amount', '>', 0)->wherein('widget_tip', $fruit)
                ->whereBetween('month', [$month_start, $month_end])->groupby('src')
                ->get();
        }



        $z = 0;
        foreach ($xys as $xy) {

            $dataz[$z]['name'] = $xy->src;
            Log::info('2000');
            for ($i = 0; $i < count($data_array); $i++) {

                if($tip==0) {
                    $x = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('typ', $typ)->wherein('widget_tip', $fruit)
                        ->where('date', date("Y-m-d", strtotime($data_array[$i])))->where('src', $xy->src)
                        ->sum('amount');
                }
                if($tip==1) { Log::info('20');
                    $x = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('typ', $typ)->wherein('widget_tip', $fruit)
                        ->where('week',  $data_array[$i])->where('src', $xy->src)
                        ->sum('amount');
                }
                if($tip==2) {
                    $x = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('typ', $typ)->wherein('widget_tip', $fruit)
                        ->where('month',  $data_array[$i])->where('src', $xy->src)
                        ->sum('amount');
                }
                $dataz[$z]['data'][] = $x;;
            }

            $z++;

        }
Log::info($tip);
        return $this->chartLine($data_array,
            $dataz, 'График ' . $typ, $tips
        );
    }

    public function get_carts_3($typ, $src, $fruit)
    {
        $user = Auth::user();
        $dataz = [];
        $chart_dates = DB::table('call_amount_3')->where('my_company_id', $user->my_company_id)->where('typ', $typ)->wherein('widget_tip', $fruit)
            ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])->
            groupby('date')->pluck('date')->toArray();

        $a = strtotime($user->stat_start_date);
        $b = strtotime($user->stat_end_date);
        $data_array = array();
        while ($a <= $b) {

            $data_array[] = date('d-m-Y', $a);
            $a += 86000;
        }

        $xys = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('typ', $typ)->where('amount', '>', 0)->wherein('widget_tip', $fruit)
            ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])->groupby('src')
            ->get();
        $z = 0;
        foreach ($xys as $xy) {
            $dataz[$z]['name'] = $xy->src;

            for ($i = 0; $i < count($data_array); $i++) {


                $x = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('typ', $typ)->wherein('widget_tip', $fruit)
                    ->where('date', date("Y-m-d", strtotime($data_array[$i])))->where('src', $xy->src)
                    ->sum('amount');


                $dataz[$z]['data'][] = $x;;
            }

            $z++;

        }
return $data_array;
        return $this->chartLine($data_array,
            $dataz, 'График ' . $typ, 1
        );
    }

    public function get_all_call_g($typ, $src, $stdate, $endate)
    {
        $user = Auth::user();
        $widget = DB::table('widgets')->where('tip', 2)->where('my_company_id', $user->my_company_id)->first();


        $get_projects_ids = DB::table('projects')->where('my_company_id', $user->my_company_id)
            ->where('widget_id', $widget->id)->whereBetween('created_at', [$stdate, $endate])
            ->pluck('id');

        $MetricaCurrent=new MetricaCurrent();
        return $MetricaCurrent->setTable('metrica_'.$user->my_company_id)
            ->wherein('project_id', $get_projects_ids)
            ->where('typ', $typ)
            ->where('src', $src)
            ->count();

    }

    public function get_all_call($typ, $src)
    {
        $user = Auth::user();
        $widget = DB::table('widgets')->where('tip', 2)->where('my_company_id', $user->my_company_id)->first();


        $get_projects_ids = DB::table('projects')->where('my_company_id', $user->my_company_id)
            ->where('widget_id', $widget->id)->whereBetween('created_at', [$this->stat_start_date, $this->stat_end_date])
            ->pluck('id');

        $MetricaCurrent=new MetricaCurrent();

        return $MetricaCurrent->setTable('metrica_'.$user->my_company_id)
            ->wherein('project_id', $get_projects_ids)
            ->where('typ', $typ)
            ->where('src', $src)
            ->count();

    }

    public function get_all_call_uniq($typ, $src)
    {
        $user = Auth::user();
        $widget = DB::table('widgets')->where('tip', 2)->where('my_company_id', $user->my_company_id)->first();



        $get_projects_ids = DB::table('projects')->where('my_company_id', $user->my_company_id)
            ->where('widget_id', $widget->id)->groupby('phone')->whereBetween('created_at', [$this->stat_start_date, $this->stat_end_date])
            ->pluck('id');

        $MetricaCurrent=new MetricaCurrent();

        return $MetricaCurrent->setTable('metrica_'.$user->my_company_id)
            ->wherein('project_id', $get_projects_ids)
            ->where('typ', $typ)
            ->where('src', $src)
            ->count();
    }


    public function start_date(Request $request)
    {
        $user = Auth::user();
        $start_date = null;
        $end_date = null;
        if (strlen($request->start_date)) {
            $start_date = date('Y-m-d', strtotime($request->start_date));
        }
        if (strlen($request->end_date)) {
            $end_date = date('Y-m-d', strtotime($request->end_date));
        }

        DB::table('users')->where('id', $user->id)->update([
            'stat_end_date' => $end_date,
            'stat_start_date' => $start_date,


        ]);

    }

    public function get_date_grafic($user=null)
    {
        if(is_null($user)){$user=Auth::user();}else{
            $user=$user;
        }

        /*    private $stat_start_date;
            private $stat_end_date;*/

        $this->stat_start_date = date('2017-01-01 00.00.00');;
        $this->stat_end_date = date('2050-01-01 23:59:59');;
        if (strlen($user->stat_start_date) < 2) {
            $this->stat_start_date = date('2017-01-01 00.00.00');
        } else {
            $this->stat_start_date = date('Y-m-d 00.00.01', strtotime($user->stat_start_date));

        }
        if (strlen($this->stat_end_date) < 2) {
            $this->stat_end_date = date('2050-01-01 23:59:59');
        } else {
            $this->stat_end_date = date('Y-m-d 23:59:59', strtotime($user->stat_end_date));
        }

    }

    public function start_load_data(Request $request)
    {

        $user = Auth::user();
$this->get_date_grafic($user);

        $data['stat_start_date'] = $this->stat_start_date;
        $data['stat_end_date'] = $this->stat_end_date;

        $widget = DB::table('widgets')->where('tip', 2)->where('my_company_id', $user->my_company_id)->first();


        $text = '  <thead>
            <tr>
                <th></th>
                <th>Сайт</th>
                <th>Звонки</th>
                <th>Уникальные Звонки</th>
                <th>Повторные Звонки</th>

            </tr>
            </thead>
            <tbody > 

';
        $k = ["organic", "referral", "typein", "utm"];
        $get_projects_ids = DB::table('projects')->where('my_company_id', $user->my_company_id)
            ->where('widget_id', $widget->id)->whereBetween('created_at', [$this->stat_start_date, $this->stat_end_date])
            ->pluck('id');
        $get_projects_ids_uniq = DB::table('projects')->where('my_company_id', $user->my_company_id)
            ->where('widget_id', $widget->id)->whereBetween('created_at', [$this->stat_start_date, $this->stat_end_date])->groupby('phone')
            ->pluck('id');
        for ($i = 0; $i < 4; $i++) {
            $data[$k[$i]] = array();


            $data['x'] = DB::table('call_amount')->where('my_company_id', $user->my_company_id)
                ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
                ->where('typ', $k[$i])->wherein('widget_tip', $request->fruit)
                ->sum('amount');



            $data['y'] = DB::table('call_amount')->where('my_company_id', $user->my_company_id)
                ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
                ->where('typ', $k[$i])->wherein('widget_tip', $request->fruit)
                ->sum('amount_uniq');;


            $data['type'] = $k[$i];
            $text .= view('stat.table_first_step', $data)->render();
        }


        $data['text'] = $text . ' </tbody>';

        $chart_dates = DB::table('call_amount')->where('my_company_id', $user->my_company_id)
            ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])->wherein('widget_tip', $request->fruit)
            ->pluck('date');

        /*['2018-01-01','2018-01-02','2018-01-03','2018-01-04','2018-01-05','2018-01-06','2018-01-07','2018-01-08','2018-01-09','2018-01-10'],
       [
           ['name' => '数据1', 'data' => [99,102,20,235,112,675,76,24,657,32]],
           ['name' => '数据2', 'data' => [199,202,30,335,212,575,176,124,457,132]],
       ],
       '测试数据'*/


        $data['chart'] = $this->get_carts($request->fruit, $request->myradio );
        return json_encode($data);


    }

    public function two_load_data(Request $request)
    {

        $user = Auth::user();
        /*type*/

        $data['stat_start_date'] = $this->stat_start_date;
        $data['stat_end_date'] = $this->stat_end_date;

        $widget = DB::table('widgets')->where('tip', 2)->where('my_company_id', $user->my_company_id)->first();


        $text = '  <thead>
            <tr class="active">
                <th></th>
                <th>Сайт</th>
                <th>Обращения</th>';
        if (in_array(1, $request->fruit)) {
            $text .= '<th>Колбэк</th>';
        }
        if (in_array(2, $request->fruit)) {
            $text .= '<th>Колтрекинг</th>';
        }


        $text .= '<th>Уникальные Звонки</th>
                <th>Повторные Звонки</th>
                <th>Сделки</th>

            </tr>
            </thead>
            <tbody > 

';
        $k = ["organic", "referral", "typein", "utm"];
        /* $get_projects_ids=DB::table('projects')->where('my_company_id', $user->my_company_id)
             ->where('widget_id', $widget->id)->whereBetween('created_at',[ $this->stat_start_date,$this->stat_end_date])
             ->pluck('id');


         $alls= DB::table('call_amount')->where('my_company_id', $user->my_company_id)
             ->whereBetween('date',[ $this->stat_start_date,$this->stat_end_date])
             ->groupby('typ')
             ->get();*/


        /*  <td>{{$x=$stat->get_all_call('organic',$client->src)}}</td>
    <td>{{$y=$stat->get_all_call_uniq('organic',$client->src)}}</td>*/


        $datasd = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->wherein('widget_tip', $request->fruit)
            ->whereBetween('date', [$user->stat_start_date, $user->stat_end_date])
            ->where('typ', $request->type)
            ->groupby('src')->get();;
        foreach ($datasd as $daf) {
            $data['all'] = $daf;

            $amount = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->wherein('widget_tip', $request->fruit)
                ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
                ->where('typ', $request->type)
                ->where('src', $daf->src)->sum('amount');;
            $data['amount_1'] = 0;
            $data['amount_2'] = 0;
            if (in_array(1, $request->fruit)) {
                $data['amount_1'] = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('widget_tip', 1)
                    ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
                    ->where('typ', $request->type)
                    ->where('src', $daf->src)->sum('amount');;
            }
            if (in_array(2, $request->fruit)) {
                $data['amount_2'] = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->where('widget_tip', 2)
                    ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
                    ->where('typ', $request->type)
                    ->where('src', $daf->src)->sum('amount');;;
            }


            $projids = DB::table('call_amount_2')->where('my_company_id', $user->my_company_id)->wherein('widget_tip', $request->fruit)
                ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
                ->where('typ', $request->type)
                ->where('src', $daf->src)->pluck('project_ids')->toArray();;
            $data['x'] = $amount;;
            $data['y'] = 0;;
            $data['z'] = $data['x'] - $data['y'];
            $data['project_ids'] = implode(',', $projids);
            $data['fruit'] = $request->fruit;


            $text .= view('stat.table_two_step', $data)->render();
        }


        $data['text'] = $text . ' </tbody>';
        $data['chart'] = $data['chart'] = $this->get_carts_2($request->type, $data['all']->src, $request->fruit,$request->myradio);
        return json_encode($data);


    }

    public function tree_load_data(Request $request)
    {

        $user = Auth::user();
        /*type*/

        $data['stat_start_date'] = $this->stat_start_date;
        $data['stat_end_date'] = $this->stat_end_date;


        $text = '  <thead>
            <tr class="active">
                <th></th>
                <th>Ключ</th>
                <th>Обращения</th>';
        if (in_array(1, $request->fruit)) {
            $text .= '<th>Колбэк</th>';
        }
        if (in_array(2, $request->fruit)) {
            $text .= '<th>Колтрекинг</th>';
        }


        $text .= '<th>Уникальные Звонки</th>
                <th>Повторные Звонки</th>
                <th>Сделки</th>

            </tr>
            </thead>
            <tbody > 

';


        $datasd = DB::table('call_amount_3')->where('my_company_id', $user->my_company_id)->wherein('widget_tip', $request->fruit)
            ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
            ->where('src', $request->type)
            ->groupby('keyword')->get();;
        foreach ($datasd as $daf) {
            $data['all'] = $daf;

            $amount = DB::table('call_amount_3')->where('my_company_id', $user->my_company_id)->wherein('widget_tip', $request->fruit)->where('keyword', $daf->keyword)
                ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
                ->where('src', $request->type)->sum('amount');;
            $data['amount_1'] = 0;
            $data['amount_2'] = 0;
            if (in_array(1, $request->fruit)) {
                $data['amount_1'] = DB::table('call_amount_3')->where('my_company_id', $user->my_company_id)->where('widget_tip', 1)->where('keyword', $daf->keyword)
                    ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
                    ->where('src', $request->type)
                    ->sum('amount');;
            }
            if (in_array(2, $request->fruit)) {
                $data['amount_2'] = DB::table('call_amount_3')->where('my_company_id', $user->my_company_id)->where('widget_tip', 2)->where('keyword', $daf->keyword)
                    ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
                    ->where('src', $request->type)
                    ->sum('amount');;;
            }


            $projids = DB::table('call_amount_3')->where('my_company_id', $user->my_company_id)->wherein('widget_tip', $request->fruit)->where('keyword', $daf->keyword)
                ->whereBetween('date', [$this->stat_start_date, $this->stat_end_date])
                ->where('src', $request->type)->pluck('project_ids')->toArray();;
            $data['x'] = $amount;;
            $data['y'] = 0;;
            $data['z'] = $data['x'] - $data['y'];
            $data['project_ids'] = implode(',', $projids);
            $data['fruit'] = $request->fruit;


            $text .= view('stat.table_tree_step', $data)->render();
        }


        $data['text'] = $text . ' </tbody>';
        $data['chart'] = '';
        return json_encode($data);


    }

    function chartpie($date, $data, $name, $i)
    {
        $chart = new ECharts();
        $chart->tooltip->show = true;
        $chart->tooltip->formatter = "{a} <br/>{b} : {c} ({d}%)";

        $chart->legend->data = $date;
        $chart->legend->orient = 'vertical';
        $chart->legend->x = 'left';
        $chart->legend->y = 'center';

        $color = ['#c23531', '#2f4554', '#61a0a8', '#d48265', '#91c7ae', '#749f83', '#ca8622', '#bda29a', '#6e7074', '#546570', '#c4ccd3'];
        shuffle($color);
        $chart->title->text = $name;


        $chart->series[] = array(
            'name' => 'Час',
            'type' => 'pie',
            'radius' => '55%',
            'data' => $data
        );
        /* series : [
                {
                    name:'访问来源',
                    type:'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:[
                        {value:335, name:'直接访问'},
                        {value:310, name:'邮件营销'},
                        {value:234, name:'联盟广告'},
                        {value:135, name:'视频广告'},
                        {value:1548, name:'搜索引擎'}
                    ]
                }*/
        return $chart->render('simple-custom-id88');

        return $chart->render(uniqid());
    }

    function chartLine($xAxisData, $seriesData, $title = '', $tip = 'line')
    {
        $chart = new \Hisune\EchartsPHP\ECharts();
        $xAxis = new \Hisune\EchartsPHP\Doc\IDE\XAxis();
        $yAxis = new \Hisune\EchartsPHP\Doc\IDE\YAxis();

        $color = ['#c23531', '#2f4554', '#61a0a8', '#d48265', '#91c7ae', '#749f83', '#ca8622', '#bda29a', '#6e7074', '#546570', '#c4ccd3'];
        shuffle($color);

        $title && $chart->title->text = $title;
        $chart->color = $color;
        $chart->tooltip->trigger = 'axis';
        $chart->toolbox->show = false;
        $chart->toolbox->feature->dataZoom->yAxisIndex = 'none';
        $chart->toolbox->feature->dataView->readOnly = false;
        $chart->toolbox->feature->magicType->type = ['line', 'bar'];
        $chart->toolbox->feature->saveAsImage = [];

        $xAxis->type = 'category';


        $xAxis->boundaryGap = false;
        $xAxis->data = $xAxisData;

        foreach ($seriesData as $ser) {
            $chart->legend->data[] = $ser['name'];
            $series = new \Hisune\EchartsPHP\Doc\IDE\Series();
            $series->name = $ser['name'];
            $series->type = 'line';
            $series->data = $ser['data'];
            $chart->addSeries($series);
        }

        $chart->addXAxis($xAxis);
        $chart->addYAxis($yAxis);

        return $chart->render(uniqid());
    }
}
