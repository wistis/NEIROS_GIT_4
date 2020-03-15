<?php

namespace App\Http\Controllers\Reports
;

use App\Http\Controllers\RunexisController;
use App\Models\Adwords\Otchet;
use App\Models\MetricaCurrent;
use App\Models\Reports\SmsReport;
use App\Sites;
use App\User;
use App\Widgets;
use Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use function React\Promise\reject;


class SmsReportsController extends Controller
{

public $period;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {


        return   $this->grid();

    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {


        return  $this->form($id) ;

    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return  $this->form() ;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {$user=Auth::user();
        $datas['stages']=SmsReport::where('my_company_id',$user->my_company_id)->get();
        return view('setting.smsreports.list',$datas);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=null)
    {   $user=Auth::user();
        $fields=SmsReport::FIELDS;
        $repeat_sms=SmsReport::REPEAT_SMS;
        $sites=Sites::where('my_company_id',$user->my_company_id)->where('is_deleted',0)->get();

        if(is_null($id)){

            return view('setting.smsreports.add',compact('fields','repeat_sms','sites'));

        }else{

            $sms=SmsReport::where('my_company_id',$user->my_company_id)->findOrFail($id);
            return view('setting.smsreports.edit',compact('fields','repeat_sms','sites','sms'));}



    }

    public  function update(Request $request){

       $sms=SmsReport::where('id',$request->id)->where('my_company_id',auth()->user()->my_company_id)->first();
       if(!$sms){
           return abort(404);
       }


 if(!$request->has('fields')){

     session()->flash('error','Выберите поля отчета');
     return redirect()->back();

 }
        if(!is_array($request->get('fields'))){

            session()->flash('error','Выберите поля отчета');
            return redirect()->back();

        }

        $prov_site=SmsReport::where('my_company_id',auth()->user()->my_company_id)->where('id','!=',$request->id)->where('site_id',$request->site_id)->first();
        if($prov_site){
            session()->flash('error','Сайт уже присутствует в отчетах');
            return redirect()->back();

        }

        $sms->my_company_id=auth()->user()->my_company_id;
        $sms->fields=$request->fields;
        $sms->repeat_sms=$request->repeat_sms;
        $sms->time=$request->time;
        $sms->site_id=$request->site_id;
        $sms->date_reports=$request->date_reports;
        $sms->day_send=$request->day_send;
        $sms->phone=$request->phone;
        $sms->save();

        SmsReport::create_send_date($sms->id);
        return redirect('/setting/smsreports');

    }

    public function store(Request $request){

        if(!$request->has('fields')){

            session()->flash('error','Выберите поля отчета');
            return redirect()->back();

        }
        if(!is_array($request->get('fields'))){

            session()->flash('error','Выберите поля отчета');
            return redirect()->back();

        }
$prov_site=SmsReport::where('my_company_id',auth()->user()->my_company_id)->where('site_id',$request->site_id)->first();
        if($prov_site){
            session()->flash('error','Сайт уже присутствует в отчетах');
            return redirect()->back();

        }
        /*'*','id', 'my_company_id', 'fields', 'repeat_sms', 'site_id', 'time', 'date_reports', 'day_send', 'created_at', 'updated_at'*/
$sms=new  SmsReport();
        $sms->my_company_id=auth()->user()->my_company_id;
        $sms->fields=$request->fields;
        $sms->repeat_sms=$request->repeat_sms;
        $sms->time=$request->time;
        $sms->site_id=$request->site_id;
        $sms->date_reports=$request->date_reports;
        $sms->day_send=$request->day_send;
        $sms->phone=$request->phone;

        $sms->save();
        return redirect('/setting/smsreports');


    }
    public function destroy($id){
        $user=Auth::user();
        SmsReport::where('id',$id)->where('my_company_id',$user->my_company_id)->delete();
    }

    public function updatesort(Request $request){
        $user=Auth::user();
        $datas=$request->del;
        for($i=0;$i<count($datas);$i++){
            Stage::where('id',$datas[$i])->where('my_company_id',$user->my_company_id)->update(['sort'=>$i]);

        }

        return'123';
    }


    public static function create_default_stage($my_company_id){
        $stage_default=[
            'В работе'=>'','Выполнены'=>'#87f2c0','Отказ'=>'#ff8f92'
        ];

        foreach($stage_default as $key=>$val) {
            Stage::insert(['name' =>$key,

                'color' =>$val,
                'my_company_id' => $my_company_id]);
        }
    }

    public function prov_sms(){
        $smss=SmsReport::where('send_date','<',date('Y-m-d H:i:s'))->get();
foreach ($smss as $sms){
    $this->create_report($sms);
}

    }

    public function create_report($sms ){


        if($sms->date_reports=='day'){

            $date_start=date('Y-m-d',strtotime('-1 day',time()));
            $date_end=date('Y-m-d',strtotime('-1 day',time()));
            $this->period=[$date_start,$date_end];

        }
        if($sms->date_reports=='week'){

            $date_start=date('Y-m-d',strtotime('-8 day',time()));
            $date_end=date('Y-m-d',strtotime('-1 day',time()));
            $this->period=[$date_start,$date_end];

        }
        if($sms->date_reports=='month'){

            $date_start=date('Y-m-d',strtotime('-1 month',time()));
            $date_end=date('Y-m-d',strtotime('-1 day',time()));
            $this->period=[$date_start,$date_end];

        }

        $data=[];
        $data['date_start']=$date_start;
        $data['date_end']=$date_end;
$date_all=$this->get_data_all($sms);
$data=array_merge($date_all,$data);
$data_edwords=$this->get_summ_adwords($sms);
$data_direct=$this->get_summ_direct($sms);
$rashod=$data_edwords+$data_direct;
        $data['conversionsd']=$this->get_conversion($data['visit'], $data['sdelka']);
        $data['conversionld']=$this->get_conversion($data['visit'], $data['lead']);
if($data['lead']>0){
    $data['srcheck']=round($rashod/$data['lead']);
}else{
    $data['srcheck']=0;
}
        if($rashod>0){$roi=round(($data['summ']-$rashod)/$rashod*100,2).'';}else{$roi='';}
     $data['roi']=$roi;


      $text='Отчет Neiros по сайту '.$sms->site->name." за период с ".date('d.m.Y',strtotime($date_start))." по ".date('d.m.Y',strtotime($date_end)).'.\r\n';



      foreach (SmsReport::FIELDS as $key=>$val){

          if(in_array($key,$sms->fields)){

              $text.=$val.': '.$data[$key].SmsReport::FIELDS_ELK[$key].'\r\n';

          }


      }

$text=trim($text,',');
$runex=new RunexisController();

$runex->send_sms_1($text,$sms->phone);


        SmsReport::create_send_date($sms->id);




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
    function  get_data_all($sms){
        $MetricaCurrent=new MetricaCurrent();


        return $MetricaCurrent->setTable('metrica_'.$sms->my_company_id)->where('site_id', $sms->site_id)->whereBetween('reports_date', $this->period)->where('bot', 0)
            -> select(


                DB::raw($this->get_zapros('sdelka')),
                DB::raw($this->get_zapros('lead')),



                DB::raw($this->get_zapros('summ')),


                DB::raw('count(DISTINCT(neiros_visit)) as visit'))

            ->first()->toArray();



    }
    public function get_summ_direct($sms){


        $sum=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$sms->my_company_id)->whereBetween('Date', $this->period)->sum('Cost');

        return round($sum / 1000000*1.2, 2);

    }


    public function get_summ_adwords($sms){

        $odadot=new Otchet($sms->my_company_id);

        $sum=$odadot->whereBetween('Date', $this->period)->sum('Cost');
return round($sum / 1000000*1.2, 2);

    }

    public function get_zapros($pole)
    {
        $text = 'sum(' . $pole . ') as ' . $pole;

        return $text;

    }
}
