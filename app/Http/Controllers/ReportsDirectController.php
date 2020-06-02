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
use App\Models\MetricaCurrent;

class ReportsDirectController extends Controller
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
public function get_lvl_new_project($pole,$val,$group_field,$neirosield){
   $dannie=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->groupby($group_field)->pluck($group_field) ;

    $get_ids_metrika=NeirosUtm::wherein($neirosield,$dannie)->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');
    return Project::wherein('neiros_visit',$get_ids_metrika)->whereBetween('reports_date', $this->period)->count();


}
    public function get_lvl_new( $pole,$val){

        if($this->lvl==1){

         return   DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->
            select(\DB::raw('SUM(Clicks) as posetitel'),
                \DB::raw('SUM(Clicks) as unique_visit'),
                \DB::raw('SUM(Clicks) as visit'),
                \DB::raw('SUM(Clicks) as count_group'),
                \DB::raw('SUM(Cost) as cost')
                ,$pole
            )->first();
            $company=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->pluck('CampaignId');dd($company);
            $get_ids_metrika=NeirosUtm::where('neiros_p0','direct1')->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');
            return Project::wherein('neiros_visit',$get_ids_metrika)->count();






        }
        if($this->lvl==2){

            return   DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->
            select(\DB::raw('SUM(Clicks) as posetitel'),
                \DB::raw('SUM(Clicks) as unique_visit'),
                \DB::raw('SUM(Clicks) as visit'),
                \DB::raw('SUM(Clicks) as count_group'),
                \DB::raw('SUM(Cost) as cost')
                ,$pole
            )->first();
            $company=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->pluck('CampaignId');
            $get_ids_metrika=NeirosUtm::where('neiros_p0','direct1')->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');
            return Project::wherein('neiros_visit',$get_ids_metrika)->whereBetween('created_at', $this->period)->count();






        }
        if($this->lvl==3){

            return   DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->
            select(\DB::raw('SUM(Clicks) as posetitel'),
                \DB::raw('SUM(Clicks) as unique_visit'),
                \DB::raw('SUM(Clicks) as visit'),
                \DB::raw('SUM(Clicks) as count_group'),
                \DB::raw('SUM(Cost) as cost')
                ,$pole
            )->first();
            $company=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->pluck('CampaignId');
            $get_ids_metrika=NeirosUtm::where('neiros_p0','direct1')->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');
            return Project::wherein('neiros_visit',$get_ids_metrika)->whereBetween('created_at', $this->period)->count();






        }   if($this->lvl==4){

            return   DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->
            select(\DB::raw('SUM(Clicks) as posetitel'),
                \DB::raw('SUM(Clicks) as unique_visit'),
                \DB::raw('SUM(Clicks) as visit'),
                \DB::raw('SUM(Clicks) as count_group'),
                \DB::raw('SUM(Cost) as cost')
                ,$pole
            )->first();
            $company=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->pluck('Query');
            $get_ids_metrika=NeirosUtm::wherein('neiros_p4',$company)->where('my_company_id',$this->my_company_id)->whereBetween('created_at', $this->period)->pluck('neiros_visit');
            dd($company);
            return Project::wherein('neiros_visit',$get_ids_metrika)->whereBetween('created_at', $this->period)->count();






        }
    }

    public function get_lvl( $pole,$val,$adid=null){
        $direct_company_id=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->distinct('CampaignId') ->pluck( 'CampaignId');

        if($val=='AD_NETWORK'){
            $val='context';
        }

        $get_ids_metrika=NeirosUtm::where('neiros_p0','direct1')->where('neiros_p1',$val)->wherein('neiros_p2',$direct_company_id)->distinct('neiros_visit')->pluck('neiros_visit');

        if($this->lvl==2){
            $wher='neiros_visit';
            $get_ids_metrika=NeirosUtm::where('neiros_p2',$val) ->pluck('neiros_visit');
        }
        if($this->lvl==3){
            $wher='neiros_visit';
            $get_ids_metrika=NeirosUtm::where('neiros_p3',$val) ->pluck('neiros_visit');
        }
        if($this->lvl==4){
            $wher='neiros_visit';
            $get_ids_metrika=NeirosUtm::where('neiros_p4',$val)->where('neiros_p3',$adid) ->pluck('neiros_visit');
        }
        $wher='neiros_visit';
        $MetricaCurrent=new MetricaCurrent();


        $result =$MetricaCurrent->setTable('metrica_'.$this->my_company_id)



            ->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->wherein($wher,$get_ids_metrika) ->select('typ', 'src','cmp',


                DB::raw($this->ReportsController->get_zapros('sdelka')  ),
                DB::raw( $this->ReportsController->get_zapros('lead')),

                DB::raw($this->ReportsController->lvl.' as lvl'),

                DB::raw( $this->ReportsController->get_zapros('summ')),


                DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit'),
                DB::raw('count(DISTINCT(src)) as count_group')
            )->get();

        return $result;









    }






    public function get_0_lvl(){

        $direct_company_id=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->distinct('CampaignId')->pluck( 'CampaignId');
        $MetricaCurrent=new MetricaCurrent();



        $result = $MetricaCurrent->setTable('metrica_'.$this->my_company_id)



            ->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->wherein('cmp',$direct_company_id) ->select('typ', 'src','cmp',


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
