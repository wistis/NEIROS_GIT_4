<?php

namespace App\Http\Controllers;

use App\Models\Phscript_data;
use Auth;
use DB;
use Illuminate\Http\Request;


class PhscriptController extends Controller
{

    public function script_tab_productivity($ii,Request $request){
     $data['title']='';
        $user=Auth::user();
        $data['ii']=$ii;
        ;$data['users']=DB::table('users')->get();
        $data['stat_start_date']=$user->start_date;
        $data['stat_end_date']=$user->end_date;
        $data['amout_logs'] = DB::table('Phscript_log')->where('project_id', $ii)->where(function ($query) use ($request){
            if($request->method()=="POST") {

                $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
            }   })->count();
        $call_users_alls= DB::table('Phscript_log')->where('project_id', $ii)->where(function ($query) use ($request){
            if($request->method()=="POST") {

                $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
            }   })
            ->select('user_id', DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->get();
        $call_users_goods= DB::table('Phscript_log')->where('project_id', $ii)->where('result',0)->where(function ($query) use ($request){
            if($request->method()=="POST") {
            $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
            }   })->select('user_id', DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->get();

$alls=[];
$alls_good=[];
foreach ($call_users_alls as $call_users_all){
    $alls[$call_users_all->user_id]=$call_users_all->total;

}
        foreach ($call_users_goods as $call_users_all){
            $alls_good[$call_users_all->user_id]=$call_users_all->total;

        }
$data['alls']=$alls;
$data['alls_good']=$alls_good;
        if($request->method()=="GET"){
            return view('phscript.script_tab_productivity', $data);


        }else{
            return view('phscript.script_tab_productivity_ajax', $data)->render();
        }


    }


public function script_tab_togoal($ii,Request $request){
    $user=Auth::user();
    $data['ii']=$ii;
    $data['stat_start_date']=$user->start_date;
    $data['stat_end_date']=$user->end_date;
    $data['amout_logs'] = DB::table('Phscript_log')->where('project_id', $ii)->where(function ($query) use ($request){
        if($request->method()=="POST") {
            if($request->operators>0){
                $query->where('user_id',$request->operators);


            }
            $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
        }




    })->where('is_goal',1)->count();
    $data['logs'] = DB::table('Phscript_data')->where('project_id', $ii)->where('is_goal',1) ->get();
    $Phscript_datas_pluck = DB::table('Phscript_data')->where('project_id', $ii)->where('is_goal',1)->pluck('sc_id');//получаем

    $amount_add_not_otvets= DB::table('Phscript_data_log')->where('project_id', $ii)->wherein('key',$Phscript_datas_pluck)->where(function ($query) use ($request){
        if($request->method()=="POST") {
            if($request->operators>0){
                $query->where('user_id',$request->operators);


            }
            $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
        }




    })
        ->select('key', DB::raw('count(*) as total'))
        ->groupBy('key')
        ->get();
$amount_prohod=[];$i=0;
foreach ($amount_add_not_otvets as $add_not_otvet){
    $amount_prohod[$add_not_otvet->key]=$add_not_otvet->total;;

$i++;
}
$data['amount_prohod']=$amount_prohod;;
    $data['operators']=DB::table('users')->where('my_company_id',$user->my_company_id)->get();



$data['title']='Конверсия в цели';

    if($request->method()=="GET"){
        return view('phscript.script_tab_conversion_togoals', $data);


    }else{
        return view('phscript.script_tab_conversion_togoals_ajax', $data)->render();
    }

}


    public   function script_tab_conversion($ii,Request $request)
    {
        $user=Auth::user();
        $data['ii']=$ii;
        $data['stat_start_date']=$user->start_date;
        $data['stat_end_date']=$user->end_date;
        $Phscript_datas = DB::table('Phscript_data')->where('project_id', $ii)->get();


        $data['operators']=DB::table('users')->where('my_company_id',$user->my_company_id)->get();


        $data['amount_call']=$amount_call= DB::table('Phscript_log')->where('project_id', $ii)->where(function ($query) use ($request){
            if($request->method()=="POST") {
                if($request->operators>0){
$query->where('user_id',$request->operators);


                }
                $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
            }




        })->count();
        $not_otvet= DB::table('Phscript_log')->where('project_id', $ii)->where('result',2)->where(function ($query) use ($request){
            if($request->method()=="POST") {
                if($request->operators>0){
                    $query->where('user_id',$request->operators);


                }
                $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
            }




        })->count();
        $call_end= DB::table('Phscript_log')->where('project_id', $ii)->where('result',1)->where(function ($query) use ($request){
            if($request->method()=="POST") {
                if($request->operators>0){
                    $query->where('user_id',$request->operators);


                }
                $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
            }




        })->count();


        $amount_add_not_otvet= DB::table('Phscript_log')->where('project_id', $ii)->where('result',2)->where(function ($query) use ($request){
            if($request->method()=="POST") {
                if($request->operators>0){
                    $query->where('user_id',$request->operators);


                }
                $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
            }




        })
            ->select('end_step', DB::raw('count(*) as total'))
            ->groupBy('end_step')
            ->get();  ;
        $amount_add_end= DB::table('Phscript_log')->where('project_id', $ii)->where('result',1)->where(function ($query) use ($request){
            if($request->method()=="POST") {
                if($request->operators>0){
                    $query->where('user_id',$request->operators);


                }
                $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
            }




        })
            ->select('end_step', DB::raw('count(*) as total'))
            ->groupBy('end_step')
            ->get();  ;
        $amount_add_all= DB::table('Phscript_data_log')->where('project_id', $ii)->where(function ($query) use ($request){
            if($request->method()=="POST") {
                if($request->operators>0){
                    $query->where('user_id',$request->operators);


                }
                $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
            }




        })
            ->select('key', DB::raw('count(*) as total'))
            ->groupBy('key')
            ->get();  ;
        /*нет конец разговора*/

        /**/

 ;
 ;$dbcount=DB::table('Phscript_data_log')->where('project_id', $ii)->where(function ($query) use ($request){
        if($request->method()=="POST") {
            if($request->operators>0){
                $query->where('user_id',$request->operators);


            }
            $query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);
        }




    })->count();;
if($dbcount<=0){$persent_end=0;}else {
    $persent_end = 100 /$dbcount;
}
        $count_end=[];
        $count_end_end=[];
        $count_end_end_all=[];


        foreach ($amount_add_not_otvet as $am){
            $count_end[$am->end_step]=round($am->total*$persent_end,2);


        }
        foreach ($amount_add_end as $am){
            $count_end_end[$am->end_step]=round($am->total*$persent_end,2);


        }
        foreach ($amount_add_all as $am){
            $count_end_end_all[$am->key]=round($am->total*$persent_end,2);


        }


















        $data_table = [];
        foreach ($Phscript_datas as $phscript_data) {

            $data_table[$phscript_data->sc_id]['id'] = $phscript_data->sc_id;
            $data_table[$phscript_data->sc_id]['parent_id'] = $phscript_data->parent_id;
            $data_table[$phscript_data->sc_id]['tip'] = $phscript_data->parent_id;
            $data_table[$phscript_data->sc_id]['text_label'] = $phscript_data->text_label;
            $data_table[$phscript_data->sc_id]['tip_label'] = $phscript_data->tip_label;
            $data_table[$phscript_data->sc_id]['x'] = $phscript_data->x;
            $data_table[$phscript_data->sc_id]['y'] = $phscript_data->y;
            $data_table[$phscript_data->sc_id]['text'] = $phscript_data->text;
            $data_table[$phscript_data->sc_id]['title'] = $phscript_data->title;
            $data_table[$phscript_data->sc_id]['is_goal'] = $phscript_data->is_goal;
            $data_table[$phscript_data->sc_id]['tipblock'] = $phscript_data->tipblock;

            if(isset($count_end[$phscript_data->sc_id])){
                $data_table[$phscript_data->sc_id]['end__not'] = $count_end[$phscript_data->sc_id];
            }else{
                $data_table[$phscript_data->sc_id]['end__not'] = 0;
            }
            if(isset($count_end_end[$phscript_data->sc_id])){
                $data_table[$phscript_data->sc_id]['end__not_end'] = $count_end_end[$phscript_data->sc_id];
            }else{
                $data_table[$phscript_data->sc_id]['end__not_end'] = 0;
            }
            if(isset($count_end_end_all[$phscript_data->sc_id])){
                $data_table[$phscript_data->sc_id]['end__not_end_all'] = $count_end_end_all[$phscript_data->sc_id];
            }else{
                $data_table[$phscript_data->sc_id]['end__not_end_all'] = 0;
            }


        }
        $data['data_tables'] = $data_table;
        $data['ii'] = $ii;
        $data['Phscript_datas'] = $Phscript_datas;











if ($amount_call==0){
    $onepercent=0;
}else{
    $onepercent=100/$amount_call;
}

$not_otvet_percent=round($not_otvet*$onepercent,1);
        $call_end_percent=round($call_end*$onepercent,1);
$data['not_otvet']=$not_otvet;
$data['call_end']=$call_end;
$data['norm_call']=$amount_call-$not_otvet-$call_end;
$data['norm_call_percent']=100-$not_otvet_percent-$call_end_percent;

        $data['not_otvet_percent']=$not_otvet_percent;
        $data['call_end_percent']=$call_end_percent;
        if($request->method()=="GET"){
        return view('phscript.script_tab_conversion', $data);


        }else{
            return view('phscript.script_tab_conversion_ajax', $data)->render();
        }
    }


    public function dataload($request){
        $user = Auth::user();


        $data['phscripts'] = DB::table('Phscript')->where('my_company_id', $user->my_company_id)->where('id',$request->project_id)->first();


        $data['logs']=DB::table('Phscript_log')->where('my_company_id', $user->my_company_id)->where('project_id',$request->project_id)->where(function ($query) use($request){
            if($request->operators>0){
                $query->where('user_id',$request->operators);
            }
$query->whereBetween('created_at',[date('Y-m-d',strtotime($request->start_date)),date('Y-m-d',strtotime($request->end_date))]);


        })->get();
        $data['project_fields']=DB::table('Phscript_fields')->where('project_id',$request->project_id)->get();

        $otvet_fields=DB::table('Phscript_data_log_field')->where('project_id',$request->project_id)->get();
        $data_f=[];


        foreach($otvet_fields as $otvfld){

            $data_f[$otvfld->log_id][$otvfld->field_id]=$otvfld->value;


        }
        $data['otvfld']=$data_f;
        $data['title']='Данные';
        $data['ii']=$request->project_id;
        $data['stat_start_date']=$user->start_date;
        $data['stat_end_date']=$user->end_date;

        $data['operators']=DB::table('users')->where('my_company_id',$user->my_company_id)->get();



        return view('phscript.tabledata', $data)->render();







    }

    public function read_data($id){

        $user = Auth::user();
        $data['phscripts'] = DB::table('Phscript')->where('my_company_id', $user->my_company_id)->where('id',$id)->first();
        $data['logs']=DB::table('Phscript_log')->where('my_company_id', $user->my_company_id)->where('project_id',$id)->paginate(100);
$data['project_fields']=DB::table('Phscript_fields')->where('project_id',$id)->get();

$otvet_fields=DB::table('Phscript_data_log_field')->where('project_id',$id)->get();
$data_f=[];


foreach($otvet_fields as $otvfld){

    $data_f[$otvfld->log_id][$otvfld->field_id]=$otvfld->value;


}
$data['otvfld']=$data_f;
$data['title']='Данные';
$data['ii']=$id;
$data['stat_start_date']=$user->start_date;
$data['stat_end_date']=$user->end_date;

        $data['operators']=DB::table('users')->where('my_company_id',$user->my_company_id)->get();



        return view('phscript.read_data', $data);



    }


    public function catalog()
    {
        $user = Auth::user();
        $data['phscripts'] = DB::table('Phscript')->where('my_company_id', $user->my_company_id)->get();

        $data['ii'] = 0;
        return view('phscript.catalog', $data);
    }

    function build_tree($cats, $parent_id, $data)
    {


        if (isset($cats[$parent_id])) {
            foreach ($cats[$parent_id] as $cat) {
                $data[$parent_id][] = $cat;
                $data = $this->build_tree($cats, $cat->sc_id, $data);

            }
        }
        return $data;
    }

    public function phscript_get_data($id)
    {
        $Phscript_datas = DB::table('Phscript_data')->where('project_id', $id)->get();

        $data_table = [];
        $data_table2 = [];
        $i = 0;
        $cats = [];

        $data_dist = [];
        foreach ($Phscript_datas as $phscript_data) {
            $phscript_data->text = $this->xreplase_field($phscript_data->text);

            $data_table[$phscript_data->parent_id][] = $phscript_data;


            $i++;
        }

        $i = 0;

        foreach ($Phscript_datas as $phscript_data) {
            $data_table2[$phscript_data->sc_id] = $phscript_data;


            $i++;
        }


        $data['ph_field'] = [];
        $data['ph_field_html'] = '';
        $phfields = DB::table('Phscript_fields')->where('project_id', $id)->get();
        foreach ($phfields as $fiels) {
            $data['ph_field'][$fiels->id] = '';
            $data['ph_field_html'] .= '';


        }

        $data['parent'] = $data_table;
        $data['osn'] = $data_table2;

        $Phscript_datas = Phscript_data::where('project_id', $id)->get();

        foreach ($Phscript_datas as $phscript_data) {
            $data_tablfe[$phscript_data->parent_id] [] = $phscript_data;
            $data_all[$phscript_data->sc_id]['amount'] = 0;

        }

        foreach ($Phscript_datas as $pg) {
            $i = 0;
            $data_tablenew[$pg->sc_id]['amount'] = $this->output($data_tablfe, $pg->sc_id, $i);
            /*  if($pg->sc_id=='dcfc1207-bfdd-4758-b8a1-9b300d7d935a'){
                 dd($data_tablenew[$pg->sc_id]['amount']);
              }*/

        }
        $data['dis'] = $data_tablenew;
        return $data;
    }

    public function output($data_table, $id, $i)
    {



        $k = 1;
        if (isset($data_table[$id])) {
            for ($z = 0; $z < count($data_table[$id]); $z++) {

           if (!isset($data_table[$data_table[$id][$z]->sc_id])) {

                     $k = 0;
            }


            } $i++;
            if ($k == 1) {

                for ($z = 0; $z <count($data_table[$id]); $z++) {

                    $i = $this->output($data_table, $data_table[$id][$z]->sc_id, $i);


                }
            }


        }


        return $i;

    }

    public function readscript($ii)
    {

     //  return $this->phscript_get_data($ii);
        $Phscript_datas = DB::table('Phscript_data')->where('project_id', $ii)->get();

        $data_table = [];
        $i = 0;
        foreach ($Phscript_datas as $phscript_data) {
            /*`(`id`, `sc_id`, `is_goal`, `text`, `title`, `cid`, `cid_id`, `parent_id`, `tip`, `tipblock`, `x`, `y`, `children`, `text_label`, `tip_label`, `project_id`)*/
            $data_table[$phscript_data->parent_id][$i] = collect();
            $data_table[$phscript_data->parent_id][$i]->id = $phscript_data->id;
            $data_table[$phscript_data->parent_id][$i]->sc_id = $phscript_data->sc_id;
            $data_table[$phscript_data->parent_id][$i]->is_goal = $phscript_data->is_goal;
            $data_table[$phscript_data->parent_id][$i]->text = $this->xreplase_field($phscript_data->text);
            $data_table[$phscript_data->parent_id][$i]->title = $phscript_data->title;
            $data_table[$phscript_data->parent_id][$i]->cid = $phscript_data->cid;
            $data_table[$phscript_data->parent_id][$i]->cid_id = $phscript_data->cid_id;
            $data_table[$phscript_data->parent_id][$i]->parent_id = $phscript_data->parent_id;
            $data_table[$phscript_data->parent_id][$i]->tip = $phscript_data->tip;
            $data_table[$phscript_data->parent_id][$i]->tipblock = $phscript_data->tipblock;
            $data_table[$phscript_data->parent_id][$i]->x = $phscript_data->x;
            $data_table[$phscript_data->parent_id][$i]->y = $phscript_data->y;
            $data_table[$phscript_data->parent_id][$i]->children = $phscript_data->children;
            $data_table[$phscript_data->parent_id][$i]->text_label = $phscript_data->text_label;
            $data_table[$phscript_data->parent_id][$i]->tip_label = $phscript_data->tip_label;
            $data_table[$phscript_data->parent_id][$i]->project_id = $phscript_data->project_id;

            /*   $data_table[$phscript_data->parent_id][$i]['id'] = $phscript_data->sc_id;
               $data_table[$phscript_data->parent_id][$i]['parent_id'] = $phscript_data->parent_id;
               $data_table[$phscript_data->parent_id][$i]['tip'] = $phscript_data->parent_id;
               $data_table[$phscript_data->parent_id][$i]['text_label'] = $phscript_data->text_label;
               $data_table[$phscript_data->parent_id][$i]['tip_label'] = $phscript_data->tip_label;
               $data_table[$phscript_data->parent_id][$i]['x'] = $phscript_data->x;
               $data_table[$phscript_data->parent_id][$i]['y'] = $phscript_data->y;
               $data_table[$phscript_data->parent_id][$i]['text'] = $phscript_data->text;
               $data_table[$phscript_data->parent_id][$i]['title'] = $phscript_data->title;
               $data_table[$phscript_data->parent_id][$i]['is_goal'] = $phscript_data->is_goal;
               $data_table[$phscript_data->parent_id][$i]['tipblock'] = $phscript_data->tipblock;*/
            $i++;
        }


        $data['ii'] = $ii;
        $data['script'] = $data_table;
        return view('phscript.readscript', $data);
    }

    public function xreplase_field($str)
    {

        preg_match_all('#<hs class="js_field js_non_editable" data-id="(.*?)" data-tip="(.*?)">(.*?)</hs>#is', $str, $matches);
// если этот <div class=Page> один на странице

        $statr_str = [];

        for ($i = 0; $i < count($matches); $i++) {

            $stsstr = $matches[$i];
            for ($i1 = 0; $i1 < count($stsstr); $i1++) {
                if ($i == 0) {
                    $statr_str[$i1]['start_stroka'] = $stsstr[$i1];
                }
                if ($i == 1) {
                    $statr_str[$i1]['data_id'] = $stsstr[$i1];
                }
                if ($i == 2) {
                    $statr_str[$i1]['data_tip'] = $stsstr[$i1];
                }
                if ($i == 3) {
                    $statr_str[$i1]['data_name'] = $stsstr[$i1];
                }
            }

        };
        for ($z = 0; $z < count($statr_str); $z++) {
            if ($statr_str[$z]['data_tip'] == 0) {
                $field = '<input type="text" class="js_script_field" name="' . $statr_str[$z]['data_id'] . '" placeholder="' . $statr_str[$z]['data_name'] . '" >';
            }
            if ($statr_str[$z]['data_tip'] == 1) {
                $field = '<textarea  class="js_script_field" name="' . $statr_str[$z]['data_id'] . '" placeholder="' . $statr_str[$z]['data_name'] . '" ></textarea>';
            }
            if ($statr_str[$z]['data_tip'] == 2) {
                $field = '<input type="checkbox"  class="js_script_field_checkbox" name="' . $statr_str[$z]['data_id'] . '"  >' . $statr_str[$z]['data_name'] . '';
            }
            if ($statr_str[$z]['data_tip'] == 3) {
                $field = '<input type="date"  class="js_script_field_data" name="' . $statr_str[$z]['data_id'] . '"  >' . $statr_str[$z]['data_name'] . '';
            }
            $str = str_replace($statr_str[$z]['start_stroka'], $field, $str);


        }


        return $str;


    }


    public function create_project(Request $request)
    {
        $user = Auth::user();
        $id = DB::table('Phscript')->insertGetId([
            'name' => $request->name,
            'my_company_id' => $user->my_company_id,
        ]);
        /* `Phscript_data`(`id`, `sc_id`, `is_goal`, `text`, `title`, `cid`, `cid_id`, `parent_id`, `tip`, `tipblock`, `x`, `y`, `children`, `text_label`, `tip_label`, `project_id`)*/
        DB::table('Phscript_data')->insert([
            'sc_id' => 'opened',
            'is_goal' => 0,
            'text' => 'Текст оператора',
            'title' => '',
            'title' => '',
            'parent_id' => 0,
            'x' => 0,
            'y' => 0,
            'project_id' => $id,

        ]);
        return $id;

    }

    public function index()
    {
        $data['data_tables'] = [];
        $Phscript_datas = DB::table('Phscript_data')->where('id', 0)->get();
        $data['Phscript_datas'] = $Phscript_datas;
        return view('phscript.create', $data);
    }

    public function update($ii)
    {
        $Phscript_datas = DB::table('Phscript_data')->where('project_id', $ii)->get();

        $data_table = [];
        foreach ($Phscript_datas as $phscript_data) {

            $data_table[$phscript_data->sc_id]['id'] = $phscript_data->sc_id;
            $data_table[$phscript_data->sc_id]['parent_id'] = $phscript_data->parent_id;
            $data_table[$phscript_data->sc_id]['tip'] = $phscript_data->parent_id;
            $data_table[$phscript_data->sc_id]['text_label'] = $phscript_data->text_label;
            $data_table[$phscript_data->sc_id]['tip_label'] = $phscript_data->tip_label;
            $data_table[$phscript_data->sc_id]['x'] = $phscript_data->x;
            $data_table[$phscript_data->sc_id]['y'] = $phscript_data->y;
            $data_table[$phscript_data->sc_id]['text'] = $phscript_data->text;
            $data_table[$phscript_data->sc_id]['title'] = $phscript_data->title;
            $data_table[$phscript_data->sc_id]['is_goal'] = $phscript_data->is_goal;
            $data_table[$phscript_data->sc_id]['tipblock'] = $phscript_data->tipblock;

        }
        $data['data_tables'] = $data_table;
        $data['ii'] = $ii;
        $data['Phscript_datas'] = $Phscript_datas;
        return view('phscript.create', $data);
    }


    public function get_array()
    {


    }

    public function safe_project($project_id, Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $val) {

            if ($data[$key]['tipblock'] == 0) {
                $insert['tipblock'] = 0;
                $insert['sc_id'] = $key;
                $insert['is_goal'] = $data[$key]['is_goal'];
                $insert['text'] = $data[$key]['text'];;
                $insert['title'] = $data[$key]['title'];;
                $insert['parent_id'] = $data[$key]['parent_id'];;
                $insert['x'] = $data[$key]['xy']['left'];;
                $insert['y'] = $data[$key]['xy']['top'];;
                $insert['tip'] = 0;;
                $prov = DB::table('Phscript_data')->where('project_id', $project_id)->where('sc_id', $key)->first();
                if ($prov) {

                    $insert['project_id'] = $project_id;
                    DB::table('Phscript_data')->where('id', $prov->id)->update($insert);

                } else {
                    $insert['project_id'] = $project_id;
                    DB::table('Phscript_data')->insert($insert);
                }

            }


        }

        foreach ($data as $key => $val) {

            if ($data[$key]['tipblock'] == 1) {

                DB::table('Phscript_data')->where('project_id', $project_id)->where('sc_id', $data[$key]['parent2'])->update([
                    'tip_label' => $data[$key]['tip'],
                    'text_label' => $data[$key]['text'],

                ]);
            }
        }


    }


    public function ajax($tip_zapros, Request $request)
    {

        switch ($tip_zapros) {
            case 'get_fields':
                return $this->get_fields($request->project_id);
                break;
            case 'create_field':
                return $this->create_field($request);
                break;
            case 'save_log':
                return $this->save_log($request);
                break;
            case 'open_info':
                return $this->open_info($request->id);
                break;
            case 'dataload':
                return $this->dataload($request);
                break;
        }


    }


    public function open_info($id){

        $proj=DB::table('Phscript_log')->where('id',$id)->first();

        $user=DB::table('users')->where('id',$proj->user_id)->first();

        $datas=DB::table('Phscript_data_log')->where('project_log_id',$id)->orderby('step','ASC')->get();
        $text='<div class="row">Сотрудник: '.$user->name.'</div>';
        foreach ($datas as $data){

            $text.='<div class="well"><p><span>'.$data->vopros.'</span></p></div>';
            $text.='<div class="well" style="text-align: right;font-weight: bold"><p><span>'.$data->otvet.'</span></p></div>';


        }


return $text;

    }
public function save_log($request){
$user=Auth::user();

    /* log:dlog,
field:ph_field,
project_id:{{$ii}},*/
    /*INSERT INTO `Phscript_log`(`id`, `time`, `result`, `end_step`, `project_id`, `my_company_id`, `user_id`, `created_at`, `updated_at`, `timer`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10])*/
    $Phscript_log=DB::table('Phscript_log')->insertGetId([
        'time'=>$request->time,
        'result'=>$request->result,
        'end_step'=>'',
        'project_id'=>$request->project_id,
        'my_company_id'=>$user->my_company_id,
        'user_id'=>$user->id,
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
        'progress'=>$request->progress,
        'step'=>$request->step,



    ]);

$is_goal=0;

 $first_vopros=DB::table('Phscript_data')->where('project_id',$request->project_id)->where('parent_id','0')->first();
 $all_datasss=DB::table('Phscript_data')->where('project_id',$request->project_id)->get();
 $aldat=[];



 foreach ($all_datasss as $all_data){
     $aldat[$all_data->sc_id]=$all_data;
 }

  $data=$request->log;
        for($i=0;$i<count($data);$i++){

            if($i==0){
                $vopros=$first_vopros->title.$first_vopros->text;
                $otvet=$aldat[$data[$i]['id']]->text_label;
                $pred="opened";
            }
            if($i>0){
                $vopros=$aldat[$data[$i-1]['id']]->title.$aldat[$data[$i-1]['id']]->text;
                $otvet=$aldat[$data[$i]['id']]->text_label;
                $pred=$aldat[$data[$i]['id']]->parent_id;
            }
$nootvet=0;$nootvet_txt='';
$no=$request->nootvet;

            if ($request->result == 2) {


                if (isset($no['nootvet'][$pred])) {
                    $nootvet = 1;
                    $nootvet_txt = $no['nootvet'][$pred];
                }


            };

            if($aldat[$data[$i]['id']]->is_goal>0){$is_goal++;}

           DB::table('Phscript_data_log')->insert([
               'key'=>$data[$i]['id'],
               'value'=>$data[$i]['value'],
               'step'=>$i,
               'vopros'=>$this->xreplase_field_final($vopros,$request->field),
               'otvet'=>$otvet,
               'project_id'=>$request->project_id,
               'my_company_id'=>$user->my_company_id,
               'project_log_id'=>$Phscript_log,
               'is_goal'=>$aldat[$data[$i]['id']]->is_goal,
               'nootvet'=>$nootvet,
               'nootvet_text'=>$nootvet_txt,
               'pred'=>$pred,  'created_at'=>date('Y-m-d H:i:s'),
               'user_id'=>$user->id,
           ]) ;


        }

    if($request->result==2){


        if( isset( $no['nootvet'][$data[count($data)-1]['id']])  )     {
            $nootvet=1;$nootvet_txt=$no['nootvet'][$data[count($data)-1]['id']];
        }


    } ;


    DB::table('Phscript_data_log')->insert([
        'key'=>'',
        'value'=>'',
        'step'=>count($data),
        'vopros'=>$this->xreplase_field_final($aldat[$data[count($data)-1]['id']]->title.$aldat[$data[count($data)-1]['id']]->text,$request->field) ,
        'otvet'=>'',
        'project_id'=>$request->project_id,
        'my_company_id'=>$user->my_company_id,
        'project_log_id'=>$Phscript_log,
        'nootvet'=>$nootvet,
        'user_id'=>$user->id,
        'nootvet_text'=>$nootvet_txt,'pred'=>$data[count($data)-1]['id'],  'created_at'=>date('Y-m-d H:i:s'),
    ]) ;



    DB::table('Phscript_log')->where('id',$Phscript_log)->update(['end_step'=>$data[count($data)-1]['id'],'is_goal'=>$is_goal]);


   foreach ($request->field as $key=>$val){

     DB::table('Phscript_data_log_field')->insert([
         'project_id'=>$request->project_id,
         'my_company_id'=>$user->my_company_id,
         'log_id'=>$Phscript_log,
         'field_id'=>$key,
         'value'=>$val,
         'created_at'=>date('Y-m-d H:i:s'),
         'updated_at'=>date('Y-m-d H:i:s'),
     ]);

   }
   /*INSERT INTO `Phscript_data_log_field`(`id`, `project_id`, `log_id`, `field_id`, `value`, `my_company_id`, `created_at`, `updated_at`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])*/



        return $request;



}

    public function get_fields($project_id)
    {


        $fields = DB::table('Phscript_fields')->where('project_id', $project_id)->get();
        $text = '';
        foreach ($fields as $field) {
            $text .= '<div class="col-md-3 mt-10"><button  class="btn btn-info select_field" data-id="' . $field->id . '"  data-tip="' . $field->tip . '" data-name="' . $field->name . '">' . $field->name . '</button></div>';


        }

        return $text;

    }

    public function create_field($request)
    {
        $user = Auth::user();

        /*id`, `name`, `tip`, `my_company_id`, `project_id`, `created_at`,*/
        $fields = DB::table('Phscript_fields')->insertGetId([
            'name' => $request->field_name,
            'tip' => $request->field_tip,
            'my_company_id' => $user->my_company_id,
            'project_id' => $request->project_id,


        ]);


        return '<hs class="js_field js_non_editable" data-id="' . $fields . '" data-tip="' . $request->field_tip . '" data-mce-selected="1" contenteditable="false" >' . $request->field_name . '</hs>';

    }
    public function xreplase_field_final($str,$data)
    {

        preg_match_all('#<hs class="js_field js_non_editable" data-id="(.*?)" data-tip="(.*?)">(.*?)</hs>#is', $str, $matches);
// если этот <div class=Page> один на странице

        $statr_str = [];

        for ($i = 0; $i < count($matches); $i++) {

            $stsstr = $matches[$i];
            for ($i1 = 0; $i1 < count($stsstr); $i1++) {
                if ($i == 0) {
                    $statr_str[$i1]['start_stroka'] = $stsstr[$i1];
                }
                if ($i == 1) {
                    $statr_str[$i1]['data_id'] = $stsstr[$i1];
                }
                if ($i == 2) {
                    $statr_str[$i1]['data_tip'] = $stsstr[$i1];
                }
                if ($i == 3) {
                    $statr_str[$i1]['data_name'] = $stsstr[$i1];
                }
            }

        };
        for ($z = 0; $z < count($statr_str); $z++) {
            if ($statr_str[$z]['data_tip'] == 0) {
                $field = '<input type="text" class="js_script_field" name="' . $statr_str[$z]['data_id'] . '" placeholder="' . $statr_str[$z]['data_name'] . '" >';
            }
            if ($statr_str[$z]['data_tip'] == 1) {
                $field = '<textarea  class="js_script_field" name="' . $statr_str[$z]['data_id'] . '" placeholder="' . $statr_str[$z]['data_name'] . '" ></textarea>';
            }
            if ($statr_str[$z]['data_tip'] == 2) {
                $field = '<input type="checkbox"  class="js_script_field_checkbox" name="' . $statr_str[$z]['data_id'] . '"  >' . $statr_str[$z]['data_name'] . '';
            }
            if ($statr_str[$z]['data_tip'] == 3) {
                $field = '<input type="date"  class="js_script_field_data" name="' . $statr_str[$z]['data_id'] . '"  >' . $statr_str[$z]['data_name'] . '';
            }

            if(isset($data[$statr_str[$z]['data_id']])) {
                $field= $data[$statr_str[$z]['data_id']];
                if($statr_str[$z]['data_tip']==2){
                    if($data[$statr_str[$z]['data_id']]==1){
                        $field=' <span style="color:green">'.$statr_str[$z]['data_name'].' -> ДА<span>' ;
                    }else{
                        $field=' <span style="color:red">'.$statr_str[$z]['data_name'].' -> НЕТ<span>' ;
                    }

                }
                $str = str_replace($statr_str[$z]['start_stroka'], $field, $str);
            }

        }


        return $str;


    }

}
