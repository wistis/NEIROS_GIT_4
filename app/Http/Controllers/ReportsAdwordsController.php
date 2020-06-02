<?php

namespace App\Http\Controllers;
use App\Models\NeirosUtm;
use App\Models\Reports\My_reports;
use App\Models\Reports\Reports_groping;
use App\Models\Reports\Reports_resourse;
use App\Models\Reports\My_reports_dashboard;
use App\Project;
use App\Http\Controllers\ReportsController;
use App\Sites;
use App\Stage;
use App\Widgets;
use Auth;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;
use App\Models\Adwords\Otchet;
use App\Models\MetricaCurrent;

class ReportsAdwordsController extends Controller
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
    public $re_typ=[] ;
    public $canals=0 ;
    public $ReportsController ;

    public function __construct($my_company_id,$sites_id,$period,$lvl)
    {

        $this->my_company_id=$my_company_id;
        $this->sites_id=$sites_id;
        $this->period=$period;
        $this->my_company_id=$my_company_id;
        $this->lvl=$lvl;
        $this->ReportsController=new ReportsController;

    }
    public function get_direct_data(){

    }

    public function get_new_0_lvl(){
           $odadot= new Otchet(auth()->user()->my_company_id);
        return    $direct_company_id=$odadot->whereBetween('Date', $this->period)->



        select(\DB::raw('SUM(Clicks) as posetitel'),
            \DB::raw('SUM(Clicks) as unique_visit'),
            \DB::raw('SUM(Clicks) as visit'),
            \DB::raw('SUM(Clicks) as count_group'),
            \DB::raw('SUM(Cost) as cost'))->first();



    }

    public function get_lvl( $pole,$val){

        if($this->lvl==1){
            $odadot=new Otchet(auth()->user()->my_company_id);
            $direct_company_id=$odadot->whereBetween('Date', $this->period)->where($pole,$val)->distinct('CampaignId') ->pluck( 'CampaignId');

        }
        if($this->lvl==2){
            $odadot=new Otchet(auth()->user()->my_company_id);
            $direct_company_id=$odadot->whereBetween ('Date', $this->period)->where($pole,$val)->distinct('AdGroupId') ->pluck( 'AdGroupId');



        }
        if($this->lvl==3){
            $odadot=new Otchet(auth()->user()->my_company_id);
            $direct_company_id=$odadot->whereBetween('Date', $this->period)->where($pole,$val)->distinct('Query') ->pluck( 'Query');
        }
        if($this->lvl==4){
            $wher='trim';
            $odadot=new Otchet(auth()->user()->my_company_id);
            $direct_company_id=$odadot->whereBetween('Date', $this->period)->where($pole,$val)->distinct('Query') ->pluck( 'Query');
        }

        if($this->lvl==1){

            $get_ids_metrika=NeirosUtm::where('neiros_p0','google1')->wherein('neiros_p2',$direct_company_id)->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');

        }
        if($this->lvl==2){

            $get_ids_metrika=NeirosUtm::where('neiros_p0','google1')->wherein('neiros_p3',$direct_company_id)->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');

        }
        if($this->lvl==3){

            $get_ids_metrika=NeirosUtm::where('neiros_p0','google1')->wherein('neiros_p5',$direct_company_id)->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');

        }
        if($this->lvl==4){

            $get_ids_metrika=NeirosUtm::where('neiros_p0','google1')->wherein('neiros_p5',$direct_company_id)->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');

        }
        $MetricaCurrent=new MetricaCurrent();
        $sql =  Project::wherein('neiros_visit',$get_ids_metrika)
            ->whereBetween('reports_date', $this->period)
                ->wherein('site_id', $this->sites_id)
                ->select(
                    DB::raw(DB::raw('count(id) as sdelka')),
                    DB::raw( $this->ReportsController->get_zapros('summ')  )
                    );
              $dannie=$sql->first();
        if($dannie){
            $data=collect();
            $data-> sdelka=$dannie-> sdelka;
            $data-> summ=$dannie-> summ;
            $data-> lvl =$this->lvl;

            $data-> posetitel =$dannie-> sdelka;

            $data-> visit =$dannie-> sdelka;
            $data-> count_group =0 ;
            $data-> lead =0;
            if($dannie-> summ>0){
                $lead=$sql->where('summ','>',0)->first() ;
                if($lead){
                    $data-> lead =$lead->sdelka;
                    }

            }
        }








return $data;

    }
    public function get_0_lvl(){



        $get_ids_metrika=NeirosUtm::where('neiros_p0','google1')->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');




        $MetricaCurrent=new MetricaCurrent();
        $result =$MetricaCurrent->setTable('metrica_'.$this->my_company_id)


            ->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->where(function ($query) use ($get_ids_metrika){
                $query->orwherein('neiros_visit',$get_ids_metrika);
                $query->orwhere('typ','direct');

            }) ->select('typ', 'src','cmp',


                DB::raw($this->ReportsController->get_zapros('sdelka')  ),
                DB::raw( $this->ReportsController->get_zapros('lead')),

                DB::raw($this->ReportsController->lvl.' as lvl'),

                DB::raw( $this->ReportsController->get_zapros('summ')),


                DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit'),
                DB::raw('count(DISTINCT(src)) as count_group')
            )->get();


        return $result;









    }


}
