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


    public function get_lvl( $pole,$val){
        $odadot=new Otchet(auth()->user()->my_company_id);
        $direct_company_id=$odadot->whereBetween('Date', $this->period)->where($pole,$val)->distinct('CampaignId') ->pluck( 'CampaignId');
        if($this->lvl<3){
            $wher='cmp';
        }
        if($this->lvl==3){
            $wher='cnt';
        }
        if($this->lvl==4){
            $wher='trim';
            $odadot=new Otchet(auth()->user()->my_company_id);
            $direct_company_id=$odadot->whereBetween('Date', $this->period)->where($pole,$val)->distinct('Query') ->pluck( 'Query');
        }

        $MetricaCurrent=new MetricaCurrent();
        $result =$MetricaCurrent->setTable('metrica_'.$this->my_company_id)



            ->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->wherein($wher,$direct_company_id)



            ->select('typ', 'src','cmp',


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
