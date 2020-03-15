<?php

namespace App\Http\Controllers;
use App\Jobs\AmoCrmWebhook;
use App\Widgets;
use DB;
use Log;
use Auth;
use App\Models\AmoWebhook;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\WidgetApiController;
use \AmoCRM\Client;
use App\Project;
class AmoCrmApiController extends Controller
{

    public function data_to_project($lead_info,$contact_info,$widget_crm,$is_amo=null){
$data['name']=$lead_info[0]['name'];
$data['summ']=$lead_info[0]['price'];
$data['amo_id']=$lead_info[0]['id'];
$data['amo_client_id']=$lead_info[0]['main_contact_id'];
$data['stage_id']=$this->get_status($lead_info[0]['status_id'],$widget_crm);
$widget=Widgets::find($widget_crm->widget_id);
if(!is_null($is_amo)){
    $data['widget_id']=$widget->id;

}

if(count($contact_info)>0){


$data['fio']=$contact_info[0]['name'];
    $field=$contact_info[0]['custom_fields'];
    for ($i = 0; $i < count($field); $i++) {
        if ($field[$i]['code'] == 'PHONE') {
            if(isset($field[$i]['values'][0])){
            $data['phone'] = $field[$i]['values'][0]['value'];}
        }
        if ($field[$i]['code'] == 'EMAIL') {
            if(isset($field[$i]['values'][0])){
                $data['email'] = $field[$i]['values'][0]['value'];}
        }

    }
}

 /*$data['user_id']=$widget->user_id;*/
/* $data['created_at']=date('Y-m-d H:i:s');
 $data['updated_at']=date('Y-m-d H:i:s');*/


 /*$data['vst']=0;
 $data['pgs']=0;
 $data['url']='';

 $data['week']= date("W", time());
 $data['hour']=date("H", time());*/
return $data;
    }
public function webhookreload($amo){

$r='no';

 $request=$amo->data;


 $amos=AmoWebhook::find($amo->id);
    $user_server=$request['account']['subdomain'].'.amocrm.ru';

    $widget_crm=DB::table('widgets_amocrm')->where('server1',$user_server)->first();
    if(!$widget_crm){
        return '';
    }




    $amo = new  Client($widget_crm->server1, $widget_crm->login, $widget_crm->password);




    if (isset($request['leads']['add'])){
        $add_lead=  $request['leads']['add'];
        for($i=0;$i<count($add_lead);$i++){


            $lead_info=$amo->lead->apiList([
                'id' => $add_lead[$i]['id'],
            ]);
            $contact_info=$amo->contact->apiList([
                'id' => $lead_info[0]['id'],
            ]);



            $project=Project::where('amo_id',$lead_info[0]['id'])->first();
            if($project){



                $data_to_insert=$this->data_to_project($lead_info,$contact_info,$widget_crm);

                Project::where('id', $project->id)->update($data_to_insert);
                $amos->data_lead_1=$project;

                $r='update amo_id'.$project->id;


            }else{
                $project1=Project::where('amo_client_id',$lead_info[0]['main_contact_id'])->first();
                if($project1){
                    $r='created main_contact_id'.$project->id;
                    $project=$project1->replicate();

                    $project->save();
                    $pr=Project::where('site_id',$project->site_id)->max('client_project_id');
                    $new_max=$pr+1;
                    $project->client_project_id=$new_max;
                    $project->reports_date=date('Y-m-d');
                    $project->comment="Создано Амо";
                    $project->save();
                    $data_to_insert=$this->data_to_project($lead_info,$contact_info,$widget_crm,1);

                    Project::where('id', $project->id)->update($data_to_insert);
                    $amos->data_lead_1=$project;

                }


            }

        }


    }


    if (isset($request['leads']['update'])){
        $add_lead=  $request['leads']['update'];
        for($i=0;$i<count($add_lead);$i++){



            $lead_info=$amo->lead->apiList([
                'id' => $add_lead[$i]['id'],
            ]);
            $contact_info=$amo->contact->apiList([
                'id' => $lead_info[0]['id'],
            ]);
            $project=Project::where('amo_id',$lead_info[0]['id'])->first();
            if($project){


                $r='update amo_id'.$project->id;
                $data_to_insert=$this->data_to_project($lead_info,$contact_info,$widget_crm);

                Project::where('id', $project->id)->update($data_to_insert);
                $amos->data_lead_1=$project;




            }

        }


    }

    if (isset($request['leads']['status'])){
        $add_lead=  $request['leads']['status'];
        for($i=0;$i<count($add_lead);$i++){



            $lead_info=$amo->lead->apiList([
                'id' => $add_lead[$i]['id'],
            ]);
            $contact_info=$amo->contact->apiList([
                'id' => $lead_info[0]['id'],
            ]);

            $project=Project::where('amo_id',$lead_info[0]['id'])->first();
            if($project){  $r='update amo_id'.$project->id;
                $amos->data_lead_1=$project;
                $stage=$this->get_status($lead_info[$i]['status_id'],$widget_crm);
                Project::where('id', $project->id)->update([ 'stage_id'=>$stage]);



            }

        }


    }

    $amos->status=1;
    $amos->r=$r;
    $amos->save();

}

    public function webhook(Request $request){
        $user_server=$request['account']['subdomain'].'.amocrm.ru';

        $widget_crm=DB::table('widgets_amocrm')->where('server1',$user_server)->first();
        if(!$widget_crm){
            return '';
        }

$AmoWebhook=new AmoWebhook();

        if (isset($request['leads']['add'])){
            $AmoWebhook->type='Add';

        }
        if (isset($request['leads']['update'])){
            $AmoWebhook->type='update';

        }

        if (isset($request['leads']['status'])){
            $AmoWebhook->type='status';

        }
        $AmoWebhook->status=0;
        $AmoWebhook->data=$request->all();
        $AmoWebhook->save();
        AmoCrmWebhook::dispatch($AmoWebhook)->onQueue('amowebhook');

    }


    public function start_prov($projectId=null){
  ;
     $lead=Project::findOrFail($projectId);
$widget=DB::table('widgets')->where('tip',17)->where('my_company_id',$lead->my_company_id)->where('status',1)->where('sites_id',$lead->site_id)->first();
if($widget){

    $widget_crm=DB::table('widgets_amocrm')->where('widget_id',$widget->id)->first();

$this->index($lead,$widget,$widget_crm,$projectId);


}

    }


    public function index($lead=null,$widget=null,$widget_crm=null,$projectId)
    {
        $amo = new  Client($widget_crm->server1, $widget_crm->login, $widget_crm->password);

        // SUBDOMAIN может принимать как часть перед .amocrm.ru,
        // так и домен целиком например test.amocrm.ru или test.amocrm.com

        // Получение экземпляра модели для работы с аккаунтом
        $account = $amo->account;;

        /* $lead_info=$amo->note->apiList([
             'query' => 3425959,
         ]);
 dd($lead_info);*/
        // Добавление и обновление сделок
        // Метод позволяет добавлять сделки по одному или пакетно,
        // а также обновлять данные по уже существующим сделкам.

        $new_lead = $amo->lead;
        $new_lead->debug(false);
        $new_lead['name'] = NULL;
        $new_lead['price'] = 0;

        if ($widget_crm->status_id > 0) {
            $new_lead['status_id'] = $widget_crm->status_id;

        }

        //$new_lead['tags'] = ['Neiros' ,'Neiros #'.$lead->id ];
      try {
          $lead_id = $new_lead->apiAdd();

      }catch (\Exception $e){

            $error_mess='AmoCrm :'.$e->getMessage();
return ''; 
      }
        $contact = [];
        if ($lead->phone != '') {
            $contact = $amo->contact->apiList([
                'query' => $lead->phone, 'limit_rows' => 1,
            ]);
            if (!$contact) {

                if ($lead->email != '') {
                    $contact = $amo->contact->apiList([
                        'query' => $lead->email, 'limit_rows' => 1,
                    ]);

                }


            }
        }
        $mm = $amo->lead->apiList([
            'id' => $lead_id,
        ]);
        Log::info('Add Neiros Lead');
        Log::info($mm);
        $status_id = $mm[0]['status_id'];
        $stage = $this->get_status($status_id, $widget_crm);

        Project::where('id', $projectId)->update(['amo_id' => $lead_id, 'stage_id' => $stage]);


        if (count($contact) == 0) {

            $contact = $amo->contact;
            $contact->debug(true); // Режим отладки

            if ($lead->fio != '') {
                $contact['name'] = $lead->fio;
            } else {
                $contact['name'] = $lead->name;
            }


            // $contact['request_id'] = '123456789';
           // $contact['responsible_user_id'] = 697344;
           // $contact['tags'] = ['Neiros'];;

if($widget_crm->user_amo_id>0){
            $contact['responsible_user_id'] = $widget_crm->user_amo_id;}
            if ($lead->phone != '') {
                $contact->addCustomField($widget_crm->id_phone, [
                    [$lead->phone, 'WORK'],
                ]);

            }
            if ($lead->email != '') {
                $contact->addCustomField($widget_crm->id_email, [
                    [$lead->email, 'WORK'],
                ]);

            }


            $contact_id = $contact->apiAdd();;
        } else {
            $contact_id = $contact[0]['id'];
        }


        $contactex = $amo->contact;

        if (is_array($contact[0]['linked_leads_id'])) {
            $contactex['linked_leads_id'] = array_merge($contact[0]['linked_leads_id'], [$lead_id]);
        } else {
            $contactex['linked_leads_id'] = [$lead_id];
        }


        $contactex->apiUpdate($contact_id, 'now');
        if (strlen($lead->comment) > 2){
            $task = $amo->note;
        $task->debug(false); // Режим отладки
        $task['element_id'] = $lead_id;
        $task['element_type'] = 2;
        //$task['date_create'] = '-2 DAYS';
        $task['note_type'] = 4;
        $task['text'] = $lead->comment;

      //  $id = $task->apiAdd();
    }




        // Обновление сделок
      /*  $lead = $amo->lead;
        $lead->debug(true);
        $lead['name'] = 'Тестовая сделка 3';

        $lead->apiUpdate((int)$id, 'now');*/

    }

    public function fortest(){
     $data['server']='ecofitnesspb.amocrm.ru';
     $data['login']='swan_gen76@mail.ru';
     $data['password']='7dbbd3942f82533ef4185f6ea3169cb9c2cac567';

$this->get_connect($data);

    }

    public function get_connect($data){

try {
    $server=str_replace('http://','',$data['server']);
    $server=str_replace('https://','',$server);
    $amo = new  Client($server, $data['login'], $data['password']);

    // SUBDOMAIN может принимать как часть перед .amocrm.ru,
    // так и домен целиком например test.amocrm.ru или test.amocrm.com

    // Получение экземпляра модели для работы с аккаунтом
    $account = $amo->account;
    $info = $account->apiCurrent();
    $field = $info['custom_fields']['contacts'];
    $dat['id_phone'] = 0;
    $dat['id_email'] = 0;

    $statusis=$info['leads_statuses'];
    for ($i = 0; $i < count($field); $i++) {
        if ($field[$i]['code'] == 'PHONE') {
            $dat['id_phone'] = $field[$i]['id'];
        }
        if ($field[$i]['code'] == 'EMAIL') {
            $dat['id_email'] = $field[$i]['id'];
        }

    }

    for($k=0;$k<count($statusis);$k++){

   $prow_status=DB::table('widgets_amocrm_status')->where('my_company_id',Auth::user()->my_company_id)->where('widget_crm_id',$data['id'])->where('status_id',$statusis[$k]['id'])->first();
   if(!$prow_status){

       DB::table('widgets_amocrm_status')->insert([
           'my_company_id'=>Auth::user()->my_company_id,
           'widget_crm_id'=>$data['id'],
           'status_id'=>$statusis[$k]['id'],
           'status_name'=>$statusis[$k]['name'],
       ]);

   }


    }
$usersamo=$info['users'];

    for($ks=0;$ks<count($usersamo);$ks++){

        $prow_status=DB::table('widgets_amocrm_users')->where('my_company_id',Auth::user()->my_company_id)->where('widget_crm_id',$data['id'])->where('user_id',$usersamo[$ks]['id'])->first();
        if(!$prow_status){

            DB::table('widgets_amocrm_users')->insert([
                'my_company_id'=>Auth::user()->my_company_id,
                'widget_crm_id'=>$data['id'],
                'user_id'=>$usersamo[$ks]['id'],
                'name'=>$usersamo[$ks]['name'],
            ]);

        }


    }

    DB::table('widgets_amocrm')->where('id', $data['id'])->update($dat);
}catch (\Exception $e){
    return 44;
}

    return 2;
    }



public function get_status($amo_status,$widget_crm){
    $stage=0;

    $stage_db=DB::table('widgets_amocrm_status')->where('my_company_id',$widget_crm->my_company_id)->where('widget_crm_id',$widget_crm->id)->where('status_id',$amo_status)->first();
    if($stage_db){
        $stage=$stage_db->stages_id;
    }

        return $stage;

}
}
