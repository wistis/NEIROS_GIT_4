<?php

namespace App\Http\Controllers\Reports;
use App\Models\NeirosUtm;

use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Controller;
use Auth;

use DB;

use App\Models\MetricaCurrent;

class NewDirectReportsController extends Controller
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
        $this->ReportsController=new ReportsController();

    }




    public function get_lvl( $pole,$val){
        $direct_company_id=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->distinct('CampaignId') ->pluck( 'CampaignId');
        if($this->lvl<3){
            $wher='cmp';
        }
        if($this->lvl==3){
            $wher='cnt';
        }
        if($this->lvl==4){
            $wher='trim';
            $direct_company_id=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->where($pole,$val)->distinct('Query') ->pluck( 'Query');
        }

        $MetricaCurrent=new MetricaCurrent();


        $result = $MetricaCurrent->setTable('metrica_'.$this->my_company_id)



            ->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->wherein($wher,$direct_company_id) ->select('typ', 'src','cmp',


                DB::raw($this->ReportsController->get_zapros('sdelka')  ),
                DB::raw( $this->ReportsController->get_zapros('lead')),

                DB::raw($this->ReportsController->lvl.' as lvl'),

                DB::raw( $this->ReportsController->get_zapros('summ')),


                DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit'),
                DB::raw('count(DISTINCT(src)) as count_group')
            )->get();

        return $result;









    }


    public function get_new_0_lvl(){
     return   $direct_company_id=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->
            select(\DB::raw('SUM(Clicks) as posetitel'),
                \DB::raw('SUM(Clicks) as unique_visit'),
                \DB::raw('SUM(Clicks) as visit'),
                \DB::raw('SUM(Clicks) as count_group'),
                \DB::raw('SUM(Cost) as cost'))->first();



    }


    public function get_0_lvl(){



        $direct_company_id=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->distinct('CampaignId')->pluck( 'CampaignId');


        $get_ids_metrika=NeirosUtm::wherein('neiros_p2',$direct_company_id)->pluck('neiros_visit');



        $result = DB::connection('neiros_metrica')->table('metrica_'.$this->my_company_id)
            ->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->where(function ($query) use ($get_ids_metrika){
                $query->orwherein('neiros_visit',$get_ids_metrika);
                $query->orwhere('typ','direct');

            })


          ->select('typ', 'src','cmp',


                DB::raw($this->ReportsController->get_zapros('sdelka')  ),
                DB::raw( $this->ReportsController->get_zapros('lead')),

                DB::raw($this->ReportsController->lvl.' as lvl'),

                DB::raw( $this->ReportsController->get_zapros('summ')),


                DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit'),
                DB::raw('count(DISTINCT(src)) as count_group')
            )->get() ;


        return $result;









    }



    public function get_0_new(){





        $direct_company_id=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$this->my_company_id)->whereBetween('Date', $this->period)->distinct('CampaignId')->pluck( 'CampaignId');


        $get_ids_metrika=NeirosUtm::wherein('neiros_p2',$direct_company_id)->pluck('neiros_visit');



        $result = DB::connection('neiros_metrica')->table('metrica_'.$this->my_company_id)
            ->wherein('site_id', $this->sites_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            ->where(function ($query) use ($get_ids_metrika){
                $query->orwherein('neiros_visit',$get_ids_metrika);
                $query->orwhere('typ','direct','direct');

            })


            ->select( DB::raw('0 as typ'), 'src','cmp',


                DB::raw($this->ReportsController->get_zapros('sdelka')  ),
                DB::raw( $this->ReportsController->get_zapros('lead')),

                DB::raw($this->ReportsController->lvl.' as lvl'),

                DB::raw( $this->ReportsController->get_zapros('summ')),


                DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit'),
                DB::raw('count(DISTINCT(src)) as count_group')
            ) ;


        return $result;









    }

}
