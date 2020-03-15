<?php

namespace App\Http\Controllers;
use App\Models\MetricaCurrent;
use App\Field_tip;
use App\Http\Controllers\Api\WidgetApiController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Models\Servies\BlackListNeirosIds;
use App\Models\WidgetName;
use App\Models\Widgets\WidgetVkUsers;
use App\Project;
use App\Project_field;
use App\Project_log;
use App\Projects_tag;
use App\Sites;
use App\Stage;
use App\User;
use App\Widgets;
use App\Widgets_phone;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;
use Datatables;
class ProjectController extends Controller
{

public  function  add_ajax_lead_promocod($request){


    $widget= \App\Widgets::where('my_company_id', auth()->user()->my_company_id)->where('sites_id',  auth()->user()->site)->where('tip', 0)->first();
    $getallwid = Project::where('widget_id', $widget->id)->count();
    $getallwid++;
    $WidgetApiController=new WidgetApiController();

    $MetricaCurrent=new MetricaCurrent();
    $MetricaCurrent->setTable('metrica_'.$widget->my_company_id);

    $metrika = $MetricaCurrent->where('promocod', $request->promokod)->orderby('id', 'desc')->first();
    if($metrika){
        $neiros_visit=$metrika->neiros_visit;

    }else{
        $neiros_visit=0;
    }
    $data_w['fio']=$request->fio;
    $projectId = $WidgetApiController->create_lead([
        'name' =>  'Промокод № ' . $getallwid,
        'stage_id' =>0,
        'user_id' => $widget->user_id,
        'summ' => $request->summ,
        'comment' => 'Промокод',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'fio' =>$request->fio,
        'phone' =>$request->phone,
        'email' =>$request->email,
        'company' => '',
        'promocod'=>$request->promokod,
        'widget_id' => $widget->id,
        'sub_widget' =>'promocod',
        'my_company_id' => $widget->my_company_id,
        'neiros_visit' => $neiros_visit,
        'vst' => 0,
        'pgs' => 0,
        'url' => '',
        'site_id' => $widget->sites_id,
        'week' => date("W", time()),
        'hour' => date("H", time())
    ], $data_w);


}
    static function get_role($tip, $number)
    {
        $user = Auth::user();

        $role = $user->getroles->where('modul', $number)->first();
/*
        if (($tip == 'read') && ($role->read == 0)) {
            return abort(404);
        }
        if (($tip == 'create') && ($role->create == 0)) {
            return abort(404);
        }
        if (($tip == 'edit') && ($role->edit == 0)) {
            return abort(404);
        }
        if (($tip == 'delete') && ($role->delete == 0)) {
            return abort(404);
        }*/


    }


    public function get_region($id)
    {

        $res = DB::table('metrika_current_region')->where('neiros_visit', $id)->first();
        if ($res) {
            return $text = $res->region;
        } else {
            return '';
        }


    }

    public function get_utm($id)
    {


        /* `metrika_current_utm`(`id`, `met_cur_id`, `utm`, `valur`)*/
        $res = DB::table('metrika_current_utm')->where('hash', $id)->get();


        $text = '<table class="table table-bordered">';
        foreach ($res as $re) {


            $text .= '<tr>
<td>' . $re->utm . '</td>
<td>' . $re->valur . '</td>
</tr>';

        }
        $text .= '</table>';
    }



public function get_client_info($id){
  $project=Project:: find($id);
    $metrika_last=DB::table('metrica_visits')->where('neiros_visit',$project->neiros_visit)->orderby('id','desc')->first();
    $vidget_social=null;
    if(!is_null($project->widgets_client_id)){

        $vidget_social=$project->get_chat_users()->first(); ;


    }
/*'<h4>Сделка №'.$project->client_project_id.'</h4>';*/
$table="
<table class=\"table\">
<tr>
<td>Дата</td>
<td class=\"right-td\">".date('H:i d.m.Y',strtotime($project->created_at))."</td>
 </tr>
";
if($project){

       $info=$this->get_metrika($project);
    if(!is_null($info)) {
        if(!is_null($info->neiros_visit)){
        $key = '';
        if (($info->src == 'yandex.ru') || ($info->src == 'referral yandex.ru')) {

            $key = $this->get_metrikakey($info->neiros_visit);
        }
        $dop=0;$lead_url='';$visit='';$amount_page='';
        if(!is_null($project->neiros_url_vst)){

            $get_lead_url=DB::table('metrica_visits')->where('id',$project->neiros_url_vst)->first();
          if($get_lead_url){
              $dop=1;
              $lead_url=$get_lead_url->url;
              $visit=$get_lead_url->vst;
              $amount_page=DB::table('metrica_visits')->where('vst',$get_lead_url->vst)->where('neiros_visit',$project->neiros_visit)->count();

          }



        }

        $table .= '
<tr>
<td>Источник</td>
<td class="right-td">' . $info->typ . ' ' . $info->src . '</td>


</tr>
<tr>
<td>Визит №</td>
<td class="right-td">'.$visit. '</td>
</tr>
<tr>
<td>Просмотрено страниц</td>
<td class="right-td">'.$amount_page. '</td>
</tr>



<tr>
<td>Страница входа</td>';

$url_1 = explode('?', $info->ep);
if(iconv_strlen($url_1[0]) > 24){
 $table .= '<td class="right-td"><span class="url-page">...'.substr(explode('?', $info->ep)[0], -24).'<a target="_blank" href="'.explode('?', $info->ep)[0].'" class="hidden-url-link">'.explode('?', $info->ep)[0].'</a></span></td>';
}
else{
	$table .= '<td class="right-td"><span class="url-page"><a target="_blank" href="'.explode('?', $info->ep)[0].'" class="">'.explode('?', $info->ep)[0].'</a></span></td>';
	}



$table .= '</tr>
<tr>
<td>Страница заявки</td>';

$url_2 = explode('?', $info->ep);
if(iconv_strlen($url_2[0]) > 24){
 $table .= '<td class="right-td"><span class="url-page">...'.substr(explode('?', $lead_url)[0], -24).'<a target="_blank" href="'.explode('?', $lead_url)[0].'" class="hidden-url-link">'.explode('?', $lead_url)[0].'</a></span></td>';
}
else{
	$table .= '<td class="right-td"><span class="url-page"><a target="_blank" href="'.explode('?', $lead_url)[0].'" >'.explode('?', $lead_url)[0].'</a></td>';
	}
 
 
 $table .='</tr>
<tr>
<td>Ключ</td>';


if($key != ''){
	if(iconv_strlen($key) > 24){
		$table .='<td class="right-td">' . $key . '<span class="key-page">...'.substr($key, -24).'<span class="hidden-key-block">'.$key.'</span></span></td>';
		}
	else {
		$table .='<td class="right-td">' . $key . '</td>';
		}	
	}

$table .='</tr>
<tr>
<td>Регион</td>
<td class="right-td">' . $this->get_region($info->neiros_visit) . '</td>
</tr>
';

    }


    }


}
if($project->amo_id>0){
    $table.='
<tr>
<td>AmoCRM</td>
<td class="right-td">'.$project->amo_id.' </td>


</tr>
 
';


}
    if($project->bt24_id>0){
        $table.='
<tr>
<td>Bitrix24</td>
<td class="right-td">'.$project->bt24_id.' </td>


</tr>
 
';


    }
  $table.='</table>';
if($project->ncl_id>0) {




    $all_leads = Project::where('site_id',$project->site_id)->where('ncl_id',$project->ncl_id)

        ->with('get_widget_info')->get();

}else{
        $all_leads = Project::where('id', $project->id)
            ->with('get_widget_info')->get();
    }
\Artisan::call('view:clear');



    $info1 = $this->get_compact_lead($all_leads, $project->id);
    array_sort($info);

    $info = $info1['content'];
    $dat = $info1['date'];
    $dat = array_unique($dat);
    krsort($dat);

$ban=0;
$get_ban=BlackListNeirosIds::where('neiros_visit',$project->neiros_visit)->first();
if($get_ban){
    $ban=1;
}
return view('projects.modal.client_info',compact('project','metrika_last','table','all_leads','info','dat','vidget_social','ban'))->render();
}



public function get_compact_lead($all_leads,$project_id){
$data_out=[];$daty=[];
$i=0;
foreach ($all_leads as $item){
    $daty[]=date('Y-m-d',strtotime($item->created_at))
    ;

    $w=Widgets::with('get_name')->find($item->get_widget_info->id);


    $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['name']=$w->get_name->name.' '.$item->phone.' '.$item->id .' '.$item->neiros_visit ;///$item->get_widget_info->name ;
    $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['type']=$item->get_widget_info->tip;
    $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['time']=date('H:i',strtotime($item->created_at));

if($item->get_widget_info->tip==2){
    $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['content2']='<br>'.$this->get_audio($item->uniqueid);



}else{

    if(($item->sub_widget=='callback')||($item->sub_widget=='callback_later')||($item->sub_widget=='callback_form')||($item->sub_widget=='form_callback')){

        if(is_null($item->callback_client)){
        $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['content2']='<br>'.$this->get_audio_callback($item->call_back_random_id);}else{
            $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['content2']='<br>'.$this->get_audio_callback_new($item->call_back_random_id,$item->callback_client);
        }

    }else{

            $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['content2']='<br>'.$item->comment;


    }

}

        $i++;
}

$info_log=Project_log::where('project_id',$project_id)->get();$i=0;
foreach ($info_log as $item){



    $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['name']='История изменений';
    $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['type']=0;
    $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['time']=date('H:i',strtotime($item->created_at));
    $data_out[date('Y-m-d',strtotime($item->created_at))][$i]['content']=$item->info;

    $daty[]=date('Y-m-d',strtotime($item->created_at));$i++;
}
$dar['date']=$daty;
$dar['content']=$data_out;
return $dar;

}


    public function get_metrika($project_id)
    {

        $MetricaCurrent=new MetricaCurrent();


         $prov_1 = $MetricaCurrent->setTable('metrica_'.$project_id->my_company_id)->where('project_id', $project_id->id)->first();


        if (!$prov_1) {
            $MetricaCurrent=new MetricaCurrent();

            $prov_1 =$MetricaCurrent->setTable('metrica_'.$project_id->my_company_id)->where('neiros_visit', $project_id->neiros_visit)->where('visit', $project_id->vst)->orderby('id','desc')->first();
            if ($prov_1) {

                return $prov_1;
            }


        }

        $MetricaCurrent=new MetricaCurrent();

          $prov_1 = $MetricaCurrent->setTable('metrica_'.$project_id->my_company_id)->where('neiros_visit', $project_id->neiros_visit)->orderby('id','desc')->first();

        if ($prov_1) {

            return $prov_1;
        }
        return null;;
    }

    public function get_metrika_first($project_id)
    { $MetricaCurrent=new MetricaCurrent();

        $prov_1 = $MetricaCurrent->setTable('metrica_'.$project_id->my_company_id)->where('project_id', $project_id->id)->first();
        if ($prov_1) {

        } else {
            $MetricaCurrent=new MetricaCurrent();
            $prov_1 = $MetricaCurrent->setTable('metrica_'.$project_id->my_company_id)->where('hash', $project_id->client_hash)->where('visit', $project_id->vst)->first();
            if ($prov_1) {

                return $prov_1;
            }


        }
       /* $prov_1 = DB::table('metrika_first')->where('hash', $project_id->client_hash)->first();*/

       /* if ($prov_1) {

            return $prov_1;
        }*/
        return null;;
    }

    public function get_all_ids($ids)
    {
        $this->get_role('read', 0);

        $user = Auth::user();


        $data['project_vid'] = $user->project_vid;
        $data['user'] = $user;
        $data['managers'] = User::all()->where('my_company_id', $user->my_company_id);
        $data['stages'] = Stage::orderby('sort', 'asc')->where('my_company_id', $user->my_company_id)->get();
        $k = count($data['stages']);
        if ($k == 0) {
            $k = 12;
        }
        $data['stages_amount'] = floor(12 / $k);
        $data['user'] = $user;

        $data['audio'] = '';/*ln -s  /var/spool/asterisk/monitor/ /var/www/html/audio*/
        http://82.146.43.227/audio/2018/06/08/is_viewed

        if ($user->project_vid == 0) {
            $data['projects'] = Project::orderby('id', 'desc')->where('my_company_id', $user->my_company_id)->get();
            return view('projects.list', $data);


        } else {


            $data['projects'] = Project::orderby('id', 'desc')->where('my_company_id', $user->my_company_id)
                ->whereIn('id', explode(',', $ids))
                ->paginate(20);


            $data['start_date'] = $user->start_date;
            $data['end_date'] = $user->end_date;


            return view('projects.list_table', $data);
        }

    }
/*datatable*/
    public function project2()
    { $this->get_role('read', 0);

        $user = Auth::user();
        Project::where('my_company_id', $user->my_company_id)->update(['is_viewed'=>1]);

        $data['project_vid'] = $user->project_vid;
        $data['user'] = $user;
        $data['managers'] = User::all()->where('my_company_id', $user->my_company_id);
        $data['stages'] = Stage::orderby('sort', 'asc')->where('my_company_id', $user->my_company_id)->get();
        $k = count($data['stages']);
        if ($k == 0) {
            $k = 12;
        }
        $data['stages_amount'] = floor(12 / $k);
        $data['user'] = $user;

        $data['audio'] = '';/*ln -s  /var/spool/asterisk/monitor/ /var/www/html/audio*/
        http://82.146.43.227/audio/2018/06/08/


        $start_date = date('2017-01-01 00.00.00');;
        $end_date = date('2050-01-01 23:59:59');;

        if (strlen($user->start_date) < 2) {
            $start_date = date('2017-01-01 00.00.00');
        } else {
            $start_date = date('Y-m-d 00.00.01', strtotime($user->start_date));

        }

        if (strlen($user->end_date) < 2) {
            $end_date = date('2050-01-01 23:59:59');
        } else {
            $end_date = date('Y-m-d 23:59:59', strtotime($user->end_date));
        }

        $data['start_date'] = $user->start_date;
        $data['end_date'] = $user->end_date;
        $ClientController = new ClientController();
        $data['clients'] = $ClientController->get_all();
        $data['widget_promocod']= \App\Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 0)->first();
dd( $data['widget_promocod']);
        return view('projects.list_table_new',$data);


    }
    public function anyData(){



$rek=request()->all();
$rec_arr=explode('-',$rek['order'][0]['dir']);
        $user=Auth::user();
        $info= DB::table('projects')
            ->join('widgets','widgets.id','=','projects.widget_id')
            ->join('widget_names as widget_names1','widget_names1.widget_id','=','widgets.tip')
            ->leftjoin('stages','stages.id','=','projects.stage_id')

            ->where('projects.my_company_id',$user->my_company_id)
            ->where('projects.site_id',$user->site)


            ->select('projects.phone as projects_phone'
                ,'projects.name as projects_name'
                ,'projects.email as projects_email'
                ,'projects.id as projects_id'
                ,'projects.client_project_id as client_project_id'
                ,'projects.created_at as projects_created_at'
                ,'projects.fio as projects_fio'
                ,'projects.vst as projects_vst'
                ,'projects.pgs as projects_pgs'
                ,'projects.url as projects_url'
                ,'projects.amo_client_id as projects_amo'
                ,'projects.bt24_id as projects_bt24'


                 ,'widgets.tip as widgets_tip'
                ,'stages.name as stages_name'
                ,'stages.color as stages_color'
                ,'widget_names1.name as widgets_name'






            )->orderby($rec_arr[0],$rec_arr[1]);



        return Datatables::queryBuilder($info) ->filterColumn('projects_id', function($query, $keyword) {
           // $sql = "CONCAT(users.first_name,'-',users.last_name)  like ?";
            $query->where('projects.id','LIKE' ,  '%'.$keyword.'%');
        })->
            filterColumn('projects_created_at', function($query, $keyword) {
$f=explode('|',$keyword);

                $query->wherebetween('projects.created_at' ,[
                    date('Y-m-d 00:00:00',strtotime($f[0].' 00:00:00')),
                    date('Y-m-d 23:59:59',strtotime($f[1].' 23:59:59'))

                ]);
            })->
        filterColumn('projects_phone', function($query, $keyword) {
            $f=explode('|',$keyword);

            $query->where('projects.phone' ,$keyword);
        })->
        filterColumn('projects_fio', function($query, $keyword) {


            $query->where('projects.fio' ,'LIKE','%'.$keyword.'%');
        })->
        filterColumn('widgets_name', function($query, $keyword) {

            $query->orwhere('projects.name' ,'LIKE','%'.$keyword.'%')->orwhere('projects.phone','LIKE','%'.$keyword.'%');
        })->
        filterColumn('projects_email', function($query, $keyword) {

            $query->orwhere('projects.email' ,'LIKE','%'.$keyword.'%')->orwhere('projects.phone','LIKE','%'.$keyword.'%');
        })->
        filterColumn('stages_name', function($query, $keyword) {
            $stages=Stage::where('my_company_id',auth()->user()->my_company_id)->where('name','LIKE','%'.$keyword.'%')->pluck('id');
            if($keyword=='Незазобраное'){
                $stages=[0];
            }
            $query->wherein('projects.stage_id' ,$stages) ;
        })->make(true);

    }
/*datatable*/
    public function get_all()
    {
        $this->get_role('read', 0);

        $user = Auth::user();
        Project::where('my_company_id', $user->my_company_id)->update(['is_viewed'=>1]);

        $data['project_vid'] = $user->project_vid;
        $data['user'] = $user;
        $data['managers'] = User::all()->where('my_company_id', $user->my_company_id);
        $data['stages'] = Stage::orderby('sort', 'asc')->where('my_company_id', $user->my_company_id)->get();
        $k = count($data['stages']);
        if ($k == 0) {
            $k = 12;
        }
        $data['stages_amount'] = floor(12 / $k);
        $data['user'] = $user;

        $data['audio'] = '';/*ln -s  /var/spool/asterisk/monitor/ /var/www/html/audio*/
        http://82.146.43.227/audio/2018/06/08/


        $start_date = date('2017-01-01 00.00.00');;
        $end_date = date('2050-01-01 23:59:59');;

        if (strlen($user->start_date) < 2) {
            $start_date = date('2017-01-01 00.00.00');
        } else {
            $start_date = date('Y-m-d 00.00.01', strtotime($user->start_date));

        }

        if (strlen($user->end_date) < 2) {
            $end_date = date('2050-01-01 23:59:59');
        } else {
            $end_date = date('Y-m-d 23:59:59', strtotime($user->end_date));
        }

        $data['start_date'] = $user->start_date;
        $data['end_date'] = $user->end_date;
        $ClientController = new ClientController();
        //$data['clients'] = $ClientController->get_all();

        if ($user->project_vid == 0) {
            $data['projects'] = Project::orderby('created_at','asc')->where('my_company_id', $user->my_company_id)->where('site_id', $user->sites)->get();
            return view('projects.list', $data);


        } else {


         /*   $data['projects'] = DB::table('projects')->orderby('projects.id', 'desc')
                ->join('widgets', 'widgets.id', '=', 'projects.widget_id')
                ->where('projects.my_company_id', $user->my_company_id)
                ->whereBetween('projects.created_at', [$start_date, $end_date])
                ->select('projects.*', 'widgets.tip as widgetstip')
                ->paginate(20);*/


            $gettsites = DB::table('sites')->where('my_company_id', $user->my_company_id)->get();

            $widgets=Widgets::where('my_company_id',$user->my_company_id)->get();

            $data['widgets']=[];
            foreach ($widgets as $widget) {
                $data['widgets'][$widget->id]= $widget->tip;
            }
/*widgetstip*/ /*   ->join('widgets', 'widgets.id', '=', 'projects.widget_id')*/
            if (count($gettsites) == 1) {
                $data['projects'] = DB::table('projects')

                    ->where('my_company_id', $user->my_company_id)->where('site_id', $user->sites)
                    ->whereBetween('projects.created_at', [$start_date, $end_date])
                    ->orderby('projects.id', 'desc')
                    ->paginate(20);

            } else {

                if ($user->site == 0) {
                    $data['projects'] = DB::table('projects')->where('site_id', $user->sites)
                        ->where('my_company_id', $user->my_company_id)
                        ->whereBetween('created_at', [$start_date, $end_date])
                         ->orderby('id', 'desc')
                        ->paginate(20);

                } else {

                    $data['projects'] = DB::table('projects')->where('site_id', $user->sites)

                        ->where('my_company_id', $user->my_company_id)->where('site_id', $user->site)
                        ->whereBetween('created_at', [$start_date, $end_date])
                        ->orderby('id', 'desc')
                        ->paginate(20);

                }
            }
            $data['widget_promocod']= \App\Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 0)->first();
            return view('projects.list_table_new',$data);

        }
    }

    public function get_metrikakey($hash)
    {

        $user = Auth::user();

        $text = '';
        $get_key = DB::table('metrika_keywords_import')->where('my_company_id', $user->my_company_id)->where('hash', $hash)->first();
        if ($get_key) {
            $text .= '<span style="color:green">' . $get_key->keyword . '</span><br>' . $get_key->SearchEngine . '<hr>';
        }

        $get_muid = DB::table('metrika_uid')->where('hash', $hash)->first();
        if ($get_muid) {
            /*$get_muid->_ym_uid*/
            $get_muid = DB::table('metrika_uid')->where('hash', $hash)->first();
            if ($get_muid) {
                $get_key = DB::table('metrika_keywords_import')->where('my_company_id', $user->my_company_id)->where('ids', $get_muid->_ym_uid)->first();

                if ($get_key) {
                    $text .= '<span style="color:green">' . $get_key->keyword . '</span><br>' . $get_key->SearchEngine;
                }
            }

        }

        return $text;


    }

    public function get_email($id)
    {
        $email = DB::table('widgets_email_input')->where('project_id', $id)->first();
        if ($email) {
            return '<a href="#" onclick="open_email(' . $email->id . ');return false;">' . $email->subject . '</a>';
        } else {
            return '';
        }
    }

    public function get_email_modal(Request $request)
    {


        $email = DB::table('widgets_email_input')->where('id', $request->id)->first();
        if ($email) {
            $data = $email;
            $data->error = 0;
            return json_encode($data);
        } else {
            $data = collect();
            $data->error = 1;
            return json_encode($data);;
        }


    }
    public function get_audio_callback_new($id,$AB)
    {

        $numbers = Widgets_phone::pluck('input')->toArray();

        $status_call['CANCEL'] = 'Вызов отменен';
        $status_call['ANSWER'] = 'Отвечено';
        $status_call['NO ANSWER'] = 'Без ответа. Пропущенный вызов.';
        $status_call['NO ANSWER'] = 'Без ответа. Пропущенный вызов';
        $status_call['ANSWERED'] = 'Отвечено';
        $status_call['NOANSWER'] = 'Без ответа. Пропущенный вызов';
        $status_call['CONGESTION'] = 'Канал перегружен';
        $status_call['CHANUNAVAIL'] = 'Канал недоступен';
        $status_call['BUSY'] = 'Занято';
        $atatus_succesno = ['BUSY', 'CHANUNAVAIL', 'CONGESTION', 'NOANSWER', 'NO ANSWER'];
        $status='';

        if ($AB == 'A') {
            //Звоним клиенту
            $audio_client = DB::connection('asterisk')->table('callback_calls')->where('callback_id', $id)->where('shoulder', $AB)->orderby('id', 'desc')->first();;
            if (!$audio_client) {
                return 'ошибка';
            }
            $status.='Клиент - ('. $status_call[$audio_client->disposition].') ,';

            $audio_managet = DB::connection('asterisk')->table('callback_calls')->where('callback_id', $id)->where('shoulder', 'B')->orderby('id', 'desc')->first();;
            if (!$audio_managet) {

                return 'Клиент-' . $status_call[$audio_client->disposition];
            }

            $status.='Менеджер - ('. $status_call[$audio_managet->disposition].') ';
            $rec_file = '';
            if(isset($audio_managet)) {
                if ($audio_managet->record_file != '') {
                    $rec_file = $audio_managet->record_file;
                }
            }
            if(isset($audio_client)) {
                if ($audio_client->record_file != '') {
                    $rec_file = $audio_client->record_file;
                }
            }
            if ($rec_file != '') {
                return '<audio controls>
 <source src="http://82.146.43.227/records/' . date('Y', strtotime($audio_client->calldate)) . '/' . date('m', strtotime($audio_client->calldate)) . '/' . date('d', strtotime($audio_client->calldate)) . '/' . $audio_client->record_file . '.mp3" type="audio/mp3" >

                        
                    </audio>'.$status;
            }
return $status;
        }






        if ($AB == 'B') {
            //Звоним менеджеру

            $status='';

            $audio_managet = DB::connection('asterisk')->table('callback_calls')->where('callback_id', $id)->where('shoulder', 'A')->orderby('id', 'desc')->first();;

            if (!$audio_managet) {
                return 'ошибка';
            }
            $status.='Менеджер - ('. $status_call[$audio_managet->disposition].') ,';
            $audio_client = DB::connection('asterisk')->table('callback_calls')->where('callback_id', $id)->where('shoulder', 'B')->orderby('id', 'desc')->first();;
            if (!$audio_client) {

                return 'Менеджер-' . $status_call[$audio_managet->disposition];
            }

            $status.='Клиент - ('. $status_call[$audio_client->disposition].') ';

            $rec_file = '';
            if(isset($audio_managet)) {
                if ($audio_managet->record_file != '') {
                    $rec_file = $audio_managet->record_file;
                }
            }
            if(isset($audio_client)) {
                if ($audio_client->record_file != '') {
                    $rec_file = $audio_client->record_file;
                }
            }
            if ($rec_file != '') {
                return '<audio controls>
 <source src="http://82.146.43.227/records/' . date('Y', strtotime($audio_managet->calldate)) . '/' . date('m', strtotime($audio_managet->calldate)) . '/' . date('d', strtotime($audio_managet->calldate)) . '/' . $rec_file. '.mp3" type="audio/mp3" >

                        
                    </audio>'.$status;
            }
return $status;
        }











return '';
    }
    public function get_audio_callback($id){

$numbers=Widgets_phone::pluck('input')->toArray();

        $status_call['CANCEL']='Вызов отменен';
        $status_call['ANSWER']='Отвечено';
        $status_call['NO ANSWER']='Без ответа. Пропущенный вызов.';
        $status_call['NO ANSWER']='Без ответа. Пропущенный вызов';
        $status_call['ANSWERED']='Отвечено';
        $status_call['NOANSWER']='Без ответа. Пропущенный вызов';
        $status_call['CONGESTION']='Канал перегружен';
        $status_call['CHANUNAVAIL']='Канал недоступен';
        $status_call['BUSY']='Занято';
        $atatus_succesno=['BUSY','CHANUNAVAIL','CONGESTION','NOANSWER','NO ANSWER'];
        $audio = DB::connection('asterisk')->table('callback_calls')->where('callback_id', $id)->where('shoulder','B')->orderby('id', 'desc')->first();;
        if ($audio) {
if(in_array($audio->aon,$numbers)){
    $cl='Оператор. ';
}else{   $cl='Клиент. ';

}
            if(isset($status_call[$audio->disposition])) {
                $inf=$cl.$status_call[$audio->disposition];
            }  else{
                $inf=$cl.''.$audio->disposition;
            }
            if(in_array($audio->disposition,$atatus_succesno)){
                return $inf  ;
            }else {

                return '<audio controls>
 <source src="http://82.146.43.227/records/' . date('Y', strtotime($audio->calldate)) . '/' . date('m', strtotime($audio->calldate)) . '/' . date('d', strtotime($audio->calldate)) . '/' . $audio->record_file . '.mp3" type="audio/mp3" >

                        
                    </audio>' . $inf  ;
            }
        }else{
            $audio = DB::connection('asterisk')->table('callback_calls')->where('callback_id', $id)->where('shoulder','A')->orderby('id', 'desc')->first();
            if($audio){
                if(in_array($audio->aon,$numbers)){
                    $cl='Оператор. ';
                }else{
                      $cl='Клиент. ';
                }


                if(isset($status_call[$audio->disposition])) {
                    return $cl.$status_call[$audio->disposition];
                }  else{
                    return $cl.$audio->disposition;
                }

            }else{
                return '';

            }
        }
        /*http://82.146.43.227/records/{{date('Y',strtotime($cal->calldate))}}/{{date('m',strtotime($cal->calldate))}}/{{date('d',strtotime($cal->calldate))}}/{{$cal->record_file}}.mp3*/
        return ' ';




    }

    public function get_audio_ajax($request){
        $ids_callback=$request->ids_callback;
        $ids_calltrack=$request->ids_calltrack;
        $data['callback']=[];
        $data['calltrack']=[];
        if(is_array($ids_callback)) {
            for ($i = 0; $i < count($ids_callback); $i++) {

                $data['callback'][$ids_callback[$i]] = $this->get_audio_callback($ids_callback[$i]);

            }




        }
        if(is_array($ids_calltrack)) {
            for ($i = 0; $i < count($ids_calltrack); $i++) {

                $data['calltrack'][$ids_calltrack[$i]] = $this->get_audio($ids_calltrack[$i]);

            }
        }
        return json_encode($data);

    }



    public function get_audio($id)
    {

        $status_call['CANCEL']='Вызов отменен';
        $status_call['ANSWER']='Отвечено';

        $status_call['NO ANSWER']='Без ответа. Пропущенный вызов';
        $status_call['ANSWERED']='Отвечено';
        $status_call['NOANSWER']='Без ответа. Пропущенный вызов';
        $status_call['CONGESTION']='Канал перегружен';
        $status_call['CHANUNAVAIL']='Канал недоступен';
        $status_call['BUSY']='Занято';

$atatus_succesno=['BUSY','CHANUNAVAIL','CONGESTION','NOANSWER','NO ANSWER'];
        $audio = DB::connection('asterisk')->table('calls')->where('uniqueid', $id)->orderby('id', 'desc')->first();   
        if ($audio) {
       if(isset($status_call[$audio->disposition])) {
           $inf=$status_call[$audio->disposition];
       }  else{
           $inf=''.$audio->disposition;
       }
if(in_array($audio->disposition,$atatus_succesno)){
    return $inf  ;
}else {
    return '<audio controls>
 <source src="http://82.146.43.227/records/' . date('Y', strtotime($audio->calldate)) . '/' . date('m', strtotime($audio->calldate)) . '/' . date('d', strtotime($audio->calldate)) . '/' . $audio->record_file . '.mp3" type="audio/mp3" >

                        
                    </audio>' . $inf  ;
}
        }
        /*http://82.146.43.227/records/{{date('Y',strtotime($cal->calldate))}}/{{date('m',strtotime($cal->calldate))}}/{{date('d',strtotime($cal->calldate))}}/{{$cal->record_file}}.mp3*/

    }

    public function project_vid(Request $request)
    {
        $user = Auth::user();
        DB::table('users')->where('id', $user->id)->update([
            'project_vid' => $request->project_vid
        ]);
    }

    public function get_one($id)
    {
        $user = Auth::user();
        $partners = Project::where('my_company_id', $user->my_company_id)->findOrFail($id);

        return $partners;

    }

    public function get_fromval($pole, $value)
    {
        $user = Auth::user();
        $partners = Project::where('projects.'.$pole, $value)
            ->join('widgets','widgets.id','=','projects.widget_id')
            ->join('widget_names as widget_names1','widget_names1.widget_id','=','widgets.tip')
            ->select(
                'projects.id',
                'projects.widget_id',
                'projects.email',
                'projects.fio',
                'widgets.tip as widgets_tip',
                'projects.phone',
                'projects.name',
                'projects.created_at',
                'projects.amo_client_id',
                'projects.bt24_id',
                'projects.stage_id',
                'widgets.tip as w_tip',
                'projects.widgets_client_id',
                'projects.amo_client_id as projects_amo'
                ,'projects.client_project_id as client_project_id'
                ,'projects.bt24_id as projects_bt24',
                'widget_names1.name as widget_name')
            ->orderby('projects.created_at','desc')->where('projects.my_company_id', $user->my_company_id)->where('projects.site_id', $user->site)->get();

        return $partners;

    }

    public function edit_post(Request $request)
    {


        $partner_id = 0;
        /*datatosend= {
        name:$('#name').val(),
      projectId:$('#projectId').val(),
    stage : $('#stage').val(),
    user : $('#user').val(),
    summ : $('#summ').val(),
    tags : $('#tags').val(),
    comment : $('#comment').val(),
    company : $('#company').val(),
    email : $('#email').val(),
    phone : $('#phone').val(),
    fio : $('#fio').val(),
      _token : $('[name=_token]').val(),*/

        $user = Auth::user();
        $project = Project::where('my_company_id', $user->my_company_id)->findOrFail($request->projectId);

        Project::where('id', $project->id)->update([
            'name' => $request->name,
            'stage_id' => $request->stage,
            'user_id' => $request->user,
            'summ' => $request->summ,
            'comment' => $request->comment,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'fio' => $request->fio,
            'company' => $request->company,
            'email' => $request->email,
            'phone' => $request->phone,
            'promocod' => $request->promocod,
            'promocodoff' => $request->promocodoff,
        ]);
        $tags_array = explode(',', $request->tags);
        Projects_tag::where('project_id', $request->projectId)->where('my_company_id', $user->my_company_id)->delete();
        TagsController::addtag($tags_array, $request->projectId);


        $info = [];
        $i = 0;
        $contizm = 0;
        if ($project->phone != $request->phone) {

            $info[$i]['project_id'] = $project->id;
            if($project->phone==''){
                $info[$i]['info'] = 'Смена Телефона на ' . $request->phone;
            }else{
                $info[$i]['info'] = 'Смена Телефона c ' . $project->phone . ' на ' . $request->phone;
            }

            $info[$i]['created_at'] = date("Y-m-d H:i:s", time());
            $info[$i]['user_id'] = $user->id;
            $i++;
            $contizm = 1;
        }
        if ($project->email != $request->email) {

            $info[$i]['project_id'] = $project->id;
            if($project->email==''){
                $info[$i]['info'] = 'Смена E-mail на ' . $request->email;

            }else{

                $info[$i]['info'] = 'Смена E-mail c ' . $project->email . ' на ' . $request->email;
            }

            $info[$i]['created_at'] = date("Y-m-d H:i:s", time());
            $info[$i]['user_id'] = $user->id;
            $i++;
            $contizm = 1;
        }
        if ($project->company != $request->company) {

            $info[$i]['project_id'] = $project->id;
            if($project->company==''){
                $info[$i]['info'] = 'Смена Компании  на ' . $request->company;
            }else{
                $info[$i]['info'] = 'Смена Компании c ' . $project->company . ' на ' . $request->company;
            }

            $info[$i]['created_at'] = date("Y-m-d H:i:s", time());
            $info[$i]['user_id'] = $user->id;
            $i++;
            $contizm = 1;
        }
        if ($project->fio != $request->fio) {

            $info[$i]['project_id'] = $project->id;
            if($project->fio==''){
                $info[$i]['info'] = 'Смена ФИО на ' . $request->fio;
            }else{
                $info[$i]['info'] = 'Смена ФИО c ' . $project->fio . ' на ' . $request->fio;
            }

            $info[$i]['created_at'] = date("Y-m-d H:i:s", time());
            $info[$i]['user_id'] = $user->id;
            $i++;
            $contizm = 1;
        }

        if ($contizm == 1) {


            $clientAndCompany = ClientController::updateclient([
                'fio' => $request->fio,
                'company' => $request->company,
                'email' => $request->email,
                'phone' => $request->phone,


            ], $project);
            Project::where('id', $project->id)->update($clientAndCompany);

        }


        if ($project->name != $request->name) {

            $info[$i]['project_id'] = $project->id;
            if($project->name==''){
                $info[$i]['info'] = 'Смена названия на ' . $request->name;
            }else{
                $info[$i]['info'] = 'Смена названия c ' . $project->name . ' на ' . $request->name;
            }

            $info[$i]['created_at'] = date("Y-m-d H:i:s", time());
            $info[$i]['user_id'] = $user->id;
            $info[$i]['my_company_id'] = $user->my_company_id;
            $i++;
        }
        if ($project->summ != $request->summ) {

            $info[$i]['project_id'] = $project->id;
            if(($project->summ=='')||($project->summ==0)){

                $info[$i]['info'] = 'Изменена сумма сделки на ' . $request->summ;
            }else{
                $info[$i]['info'] = 'Изменена сумма сделки c ' . $project->summ . ' на ' . $request->summ;
            }

            $info[$i]['created_at'] = date("Y-m-d H:i:s", time());
            $info[$i]['user_id'] = $user->id;
            $info[$i]['my_company_id'] = $user->my_company_id;
            $i++;
        }
        if ($project->comment != $request->comment) {

            $info[$i]['project_id'] = $project->id;
            if( $project->comment==''){

                $info[$i]['info'] = 'Измененописани сделки на ' . $request->comment;
            }else{
                $info[$i]['info'] = 'Измененописани сделки c ' . $project->comment . ' на ' . $request->comment;
            }


            $info[$i]['created_at'] = date("Y-m-d H:i:s", time());
            $info[$i]['user_id'] = $user->id;
            $info[$i]['my_company_id'] = $user->my_company_id;
            $i++;
        }


        if ($project->name != $request->name) {
            $stage_old = Stage::find($project->stage_id)->where('my_company_id', $user->my_company_id);
            $stage_new = Stage::find($request->stage)->where('my_company_id', $user->my_company_id);
            $info[$i]['project_id'] = $project->id;
            $info[$i]['info'] = 'Смена этапа c ' . $stage_old->name . ' на ' . $stage_new->name;
            $info[$i]['created_at'] = date("Y-m-d H:i:s", time());
            $info[$i]['user_id'] = $user->id;
            $info[$i]['my_company_id'] = $user->my_company_id;
            $i++;
        }


        Project_log::insert($info);


        $projectId = $request->projectId;


        Project_field::where('project_id', $projectId)->where('my_company_id', $user->my_company_id)->where('tip', 0)->delete();
        Project_field::where('project_id', $project->client_id)->where('my_company_id', $user->my_company_id)->where('tip', 1)->delete();
        $datafield = $request->datafield;

        $clientAndCompany['client_id'] = $project->client_id;
        $this->add_datafield($datafield, $clientAndCompany, $projectId);


        return $request->projectId;

    }

    static function add_datafield($datafield, $clientAndCompany, $projectId)
    {
        $user = Auth::user();

        for ($i = 0; $i < count($datafield); $i++) {
            $string = '';
            /*
              datafield[sif]['value']='';
        datafield[sif]['tip']=tip;
        datafield[sif]['field']=entry;
            */

            if (isset($datafield[$i]['tip'])) {
                $tip = $datafield[$i]['tip'];

                if (isset($datafield[$i]['value'])) {


                    if (($tip == 1) || ($tip == 3) || ($tip == 6) || ($tip == 8) || ($tip == 9)) {

                        $string = $datafield[$i]['value'];
                    }
                    if (($tip == 4) || ($tip == 5)) {

                        $string = serialize($datafield[$i]['value']);

                    }
                } else {
                    $string = '';
                }

                $prov_tip = Field_tip::find($datafield[$i]['field'])->where('my_company_id', $user->my_company_id);;

                if ($prov_tip->tip == 0) {
                    Project_field::where('project_id', $projectId)->where('my_company_id', $user->my_company_id)->where('tip', 0)->delete();
                    Project_field::insert([
                        'field_id' => $tip,
                        'field_tip_id' => $datafield[$i]['field'],
                        'project_id' => $projectId,
                        'val' => $string,
                        'my_company_id' => $user->my_company_id

                    ]);
                }

                if (($prov_tip->tip == 1) || ($prov_tip->tip == 2)) {
                    Project_field::where('project_id', $clientAndCompany['client_id'])->where('tip', $prov_tip->tip)->where('field_tip_id', $datafield[$i]['field'])->where('my_company_id', $user->my_company_id)->delete();
                    $k = DB::table('project_field')->insertgetid([
                        'field_id' => $tip,
                        'field_tip_id' => $datafield[$i]['field'],
                        'project_id' => $clientAndCompany['client_id'],
                        'val' => $string,
                        'tip' => 1,
                        'my_company_id' => $user->my_company_id

                    ]);


                }

            }


        }


    }

    public function add_post(Request $request)
    {


        $user = Auth::user();
        $partner_id = 0;
        /*
    tags : $('#tags').val(),
    comment : $('#comment').val(),
    company : $('#company').val(),
    email : $('#email').val(),
    phone : $('#phone').val(),
    fio : $('#fio').val(),*/
        $projectId = Project::insertGetId([
            'name' => $request->name,
            'stage_id' => $request->stage,
            'user_id' => $request->user,
            'summ' => $request->summ,
            'comment' => $request->comment,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'fio' => $request->fio,
            'company' => $request->company,
            'email' => $request->email,
            'phone' => $request->phone,
            'my_company_id' => $user->my_company_id,
            'promocod' => $request->promocod,
            'promocodoff' => $request->promocodoff
        ]);
        $tags_array = explode(',', $request->tags);
        TagsController::addtag($tags_array, $projectId);


        $clientAndCompany = ClientController::addclient([
            'fio' => $request->fio,
            'company' => $request->company,
            'email' => $request->email,
            'phone' => $request->phone,
            'my_company_id' => $user->my_company_id

        ]);

        Project::where('id', $projectId)->update($clientAndCompany);

        Project_log::insert(
            [
                'project_id' => $projectId,
                'info' => 'Создание сделки',
                'created_at' => date("Y-m-d H:i:s", time()),
                'user_id' => $user->id,
                'my_company_id' => $user->my_company_id
            ]
        );


        $datafield = $request->datafield;
        $this->add_datafield($datafield, $clientAndCompany, $projectId);


        return $projectId;

    }

    public function edit_view($id)
    {
        $this->get_role('edit', 0);
        $user = Auth::user();
        $partners = Project::where('my_company_id', $user->my_company_id)->findOrFail($id);
        $user = Auth::user();
        $data['user'] = $user;
        $data['managers'] = User::all()->where('my_company_id', $user->my_company_id);
        $data['stages'] = Stage::all()->where('my_company_id', $user->my_company_id);
        $data['stages'] = Stage::all()->where('my_company_id', $user->my_company_id);
        $data['project'] = $partners;


        $i = 0;


        $Projects_tag = Projects_tag::where('project_id', $partners->id)
            ->join('tags', 'tags.id', 'projects_tags.tag_id')->select('tags.name')->pluck('tags.name');
        $data['tags'] = implode(',', $Projects_tag->all());
        $data['logs'] = $this->get_log($id);

        $data['project_field'] = $this->get_edit_field($partners, 0);
        $data['client_field'] = $this->get_edit_field($partners, 1);
        $data['company_field'] = $this->get_edit_field($partners, 2);

        $data['widget_promocod']= \App\Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 0)->first();
        $data['widget_promocod_off']= \App\Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 15)->first();


        return view('projects.edit', $data);

    }

    public function add_view()
    {
        $this->get_role('create', 0);
        $user = Auth::user();
        $data['user'] = $user;
        $data['managers'] = User::all();
        $data['stages'] = Stage::all();
        $data['project_field'] = $this->get_new_field(0);
        $data['client_field'] = $this->get_new_field(1);
        $data['company_field'] = $this->get_new_field(2);
        $data['widget_promocod']= \App\Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 0)->first();
        $data['widget_promocod_off']= \App\Widgets::where('my_company_id', $user->my_company_id)->where('sites_id', $user->site)->where('tip', 15)->first();

        return view('projects.add', $data);

    }

    public function save_field(Request $request){

        $data_fields['projects_phone']='phone';
        $data_fields['projects_fio']='fio';
        $data_fields['projects_email']='email';
        $data_fields['projects_city']='city';
        $data_fields_text['projects_phone']='Телефона';
        $data_fields_text['projects_fio']='Фио';


        $user = Auth::user();
        /* project_id:ui.item.attr('data-id'),
              stage_id*/
        $project = Project::where('my_company_id', $user->my_company_id)->find($request->id);
        if (!$project) {
            return 1;
        }
        Project::where('my_company_id', $user->my_company_id)->where('id',$project->id)->update([
           $data_fields[$request->field]=>$request->input_val

        ]);

            $old_stage=$project->{$data_fields[$request->field]};
$text='';
if($old_stage==''){
  $text='Смена '.$data_fields_text[$request->field].' в сделке на "' . $request->input_val .'"';

}else{
 $text='Смена '.$data_fields_text[$request->field].' в сделке с "' . $old_stage . '" на "' . $request->input_val .'"';


}
        Project_log::insert(
            [
                'project_id' => $project->id,

                'info' =>$text ,
                'created_at' => date("Y-m-d H:i:s", time()),
                'user_id' => $user->id,
                'my_company_id' => $user->my_company_id
            ]
        );



    }



    /*id	13742
field	projects_fio
input_val	werwer*/

    public function updatestage(Request $request)
    {
        $user = Auth::user();
        /* project_id:ui.item.attr('data-id'),
              stage_id*/
        $project = Project::where('my_company_id', $user->my_company_id)->find($request->id);
        if (!$project) {
            return 1;
        }

        $old_stage = Stage::where('my_company_id', $user->my_company_id)->find($project->stage_id);

        if (!$old_stage) {
            $old_stage='Неразобранное';
        }else{
            $old_stage=$old_stage->name;
        }
        $new_stage = Stage::where('my_company_id', $user->my_company_id)->find($request->stage_id);
        if (!$new_stage) {
            return 3;
        }
        Project::where('id', $project->id)->update(['stage_id' => $new_stage->id]);


        Project_log::insert(
            [
                'project_id' => $project->id,
                'info' => 'Обновление этапа сделки с ' . $old_stage . ' на ' . $new_stage->name,
                'created_at' => date("Y-m-d H:i:s", time()),
                'user_id' => $user->id,
                'my_company_id' => $user->my_company_id
            ]
        );
        return 0;
    }

    public function get_log($id)
    {
        $logs = DB::table('project_logs')
            ->join('users', 'users.id', '=', 'project_logs.user_id')->
            where('project_logs.project_id', $id)->
            select('project_logs.*', 'users.name as username')->orderby('created_at', 'desc')->get();


        return $logs;
    }

    public function get_form_task(Request $request)
    {
        $user = Auth::user();
        $data['user'] = $user;
        $data['managers'] = User::all()->where('my_company_id', $user->my_company_id);;
        $data['todos'] = Task_todo::all()->where('my_company_id', $user->my_company_id);;
        $data['projects'] = Project::all()->where('my_company_id', $user->my_company_id);;
        $data['statuss'] = Task_status::all()->where('my_company_id', $user->my_company_id);;
        $data['number'] = $request->number;

        return view('projects.get_form_task', $data)->render();

    }

    public function get_form_client(Request $request)
    {

        $user = Auth::user();
        $data['user'] = $user;
        $data['managers'] = User::all()->where('my_company_id', $user->my_company_id);;
        $data['todos'] = Task_todo::all()->where('my_company_id', $user->my_company_id);;
        $data['projects'] = Project::all()->where('my_company_id', $user->my_company_id);;
        $data['statuss'] = Task_status::all()->where('my_company_id', $user->my_company_id);;
        $data['number'] = $request->number;

        return view('clients.get_form_clients', $data)->render();


    }


    public function get_new_field($tip)
    {
        $user = Auth::user();
        $fields = Field_tip::where('tip', $tip)->where('my_company_id', $user->my_company_id)->get();
        $fields_ids = Field_tip::all()->where('my_company_id', $user->my_company_id)->pluck('id');


        $data = '<input type="hidden"  id="idfields" value="' . implode(',', $fields_ids->toArray()) . '">';

        foreach ($fields as $field) {
            $datan['fil'] = $field;
            $data .= view('fields.' . $field->field_id, $datan);


        }

        return $data;


    }

    static function get_edit_field($partners, $tip)
    {
        $user = Auth::user();
        $fields = Field_tip::where('tip', $tip)->where('my_company_id', $user->my_company_id)->get();
        $fields_ids = Field_tip::all()->pluck('id');


        $data = '<input type="hidden"  id="idfields" value="' . implode(',', $fields_ids->toArray()) . '">';

        foreach ($fields as $field) {

            $datan['fil'] = $field;
            $datan['tec_param'] = '';

            if ($tip == 0) {
                $param = Project_field::where('project_id', $partners->id)->where('my_company_id', $user->my_company_id)->where('field_tip_id', $field->id)->first();
            }
            if ($tip == 1) {
                $param = Project_field::where('project_id', $partners->client_id)->where('my_company_id', $user->my_company_id)->where('field_tip_id', $field->id)->first();
            }
            if ($tip == 2) {
                $param = Project_field::where('project_id', $partners->client_id)->where('my_company_id', $user->my_company_id)->where('field_tip_id', $field->id)->first();
            }


            if (count($param) > 0) {
                $datan['tec_param'] = $param->val;
                if (($field->field_id == 4) || ($field->field_id == 5)) {
                    if (strlen($param->val) < 2) {
                        $datan['tec_param'] = [];
                    }
                }

            } else {
                if (($field->field_id == 4) || ($field->field_id == 5)) {

                    $datan['tec_param'] = [];

                }
            }

            $data .= view('fieldsedit.' . $field->field_id, $datan);


        }

        return $data;


    }

    public function get_stage($id)
    {
        $user = Auth::user();
        $stage_old = Stage::where('my_company_id', $user->my_company_id)->find($id);
        if ($stage_old) {
            return $stage_old->name;
        } else {
            return '';
        }

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
            'end_date' => $end_date,
            'start_date' => $start_date,


        ]);

    }


    public function update_ids(){

      exit();
        $site=Sites::all();
        foreach ($site as $item){
            $projects=Project::where('site_id',$item->id)->orderby('id','asc')->get();

foreach ($projects as $project){
    $gett_max=Project::where('site_id',$item->id)->max('client_project_id');
    $new_max=$gett_max+1;

    $project->client_project_id=$new_max;
    $project->save();
}


        }



    }

public function banclient(Request $request){



        $ban=BlackListNeirosIds::where('neiros_visit',$request->neiros_visit)->first();

        if($ban){

            BlackListNeirosIds::where('neiros_visit',$request->neiros_visit)->delete();

            return 0;
        }else{

            $bl=new BlackListNeirosIds();
            $bl->neiros_visit=$request->neiros_visit;
            $bl->save();
            return 1;
        }





}

}
