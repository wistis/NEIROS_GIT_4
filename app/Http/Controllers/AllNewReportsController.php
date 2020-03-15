<?php

namespace App\Http\Controllers;

use App\Models\Adwords\Otchet;
use App\Http\Controllers\Reports\NewDirectReportsController;
use App\Models\MetricaCurrent;
use App\Models\NeirosUtm;
use App\Models\Reports\My_reports;
use App\Models\Reports\My_reports_dashboard;
use App\Models\Reports\Reports_groping;
use App\Models\Reports\Reports_resourse;
use App\Project;
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

class AllNewReportsController extends Controller
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
    public $data_all=[];
    public $r=0;



    public function index($neiros_p0=null,$neiros_p1=null,$neiros_p2=null,$neiros_p3=null,$neiros_p4=null)
    {
        $user = Auth::user();



        if(is_null($neiros_p0)){
$field='neiros_p0';
            $direct_utms=NeirosUtm::where('my_company_id',$user->my_company_id)->where('site_id',$user->site)->groupby('neiros_p0')->pluck('neiros_p0');


  }elseif(is_null($neiros_p1)){

            $direct_utms=NeirosUtm::where('my_company_id',$user->my_company_id)->where('site_id',$user->site)
                ->where('neiros_p0',$neiros_p0)
                ->groupby('neiros_p1')->pluck('neiros_p1');
            $field='neiros_p1';

        }elseif(is_null($neiros_p2)){

            $direct_utms=NeirosUtm::where('my_company_id',$user->my_company_id)->where('site_id',$user->site)
                ->where('neiros_p1',$neiros_p1)
                ->groupby('neiros_p2')->pluck('neiros_p2');
            $field='neiros_p2';

        }elseif(is_null($neiros_p3)){

            $direct_utms=NeirosUtm::where('my_company_id',$user->my_company_id)->where('site_id',$user->site)
                ->where('neiros_p2',$neiros_p2)
                ->groupby('neiros_p3')->pluck('neiros_p3');
            $field='neiros_p3';

        }elseif(is_null($neiros_p4)){

            $direct_utms=NeirosUtm::where('my_company_id',$user->my_company_id)->where('site_id',$user->site)
                ->where('neiros_p3',$neiros_p3)
                ->groupby('neiros_p4')->pluck('neiros_p4');
            $field='neiros_p4';

        }





$data_neiros=[];
foreach ($direct_utms as $key=>$val){

    $data_neiros[$val]['val']=$val;
    $data_neiros[$val]['neiros_visit']=$this->get_neiros($field,$val );
    $data_neiros[$val]['data']=$this->get_metrica_data($data_neiros[$val]['neiros_visit']);
    $data_neiros[$val]['projects']=$this->get_project($data_neiros[$val]['neiros_visit']);
    $data_neiros[$val]['chat']=$this->get_chat($data_neiros[$val]['neiros_visit']) ;




}
$data_widget=[];
$widgets=Widgets::with('get_name')->where('my_company_id',auth()->user()->my_company_id)->get();
foreach ($widgets as $widget){
    $data_widget[$widget->id]=$widget;

}
        return view('allnewreports.index',compact('data_neiros','neiros_p0','neiros_p1','neiros_p2','neiros_p3','neiros_p4','data_widget')  );
    }


    public function get_project($neiros_visit){
   return Project::wherein('neiros_visit',$neiros_visit) ->select(
          DB::raw('COUNT(id) as amount'),'widget_id')->groupby('widget_id')->pluck('amount','widget_id')->toArray();



    }

    public function get_neiros($field,$val ){

         return NeirosUtm::where('my_company_id',auth()->user()->my_company_id)->where('site_id',auth()->user()->site)
           -> where($field,$val)
            ->groupby('neiros_visit' )->pluck('neiros_visit')->toArray();



    }
public function get_chat($neiros_visit){


    return DB::table('chat_tema')->wherein('neiros_visit', $neiros_visit)->count();
}
    public function get_metrica_data($neiros_visit){


        $MetricaCurrent=new MetricaCurrent();
        return $MetricaCurrent->setTable('metrica_'.auth()->user()->my_company_id) ->select(
            DB::raw($this->get_zapros('sdelka')), DB::raw($this->get_zapros('lead')),
            DB::raw($this->get_zapros('summ')), DB::raw('count(DISTINCT(neiros_visit)) as posetitel'), DB::raw('count(id) as visit')
        )->wherein('neiros_visit',$neiros_visit)->first();


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
}
