<?php

namespace App\Http\Controllers;

use App\Client;
use App\Clients_contacts;
use App\Project;
use Auth;
use DB;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function addfield($data)
    {
        $user = Auth::user();
        $client_name = '';
        $client = $data->client_id;
        $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('id', $data->tema_id)->first();

        $client_name = $tema->name;
        $data['error'] = 0;

        $inputvalue = $data->value;
        if ($data->adinfo == 'PHONE') {
            $inputvalue = $this->parsephone($data->value);
        }


        $prov_client = $this->search_client('val', $inputvalue, $data->adinfo, $user->my_company_id);
        if (!$prov_client) {
            /*если данных нет*/
            if ($client == 0) {
                $client = Client::insertGetId([
                    'fio' => $client_name,
                    'company' => '',
                    'my_company_id' => $user->my_company_id,

                ]);
                Clients_contacts::insert([

                    'val' => $data->value,
                    'keytip' => $data->adinfo,
                    'my_company_id' => $user->my_company_id,
                    'client_id' => $client,

                ]);

            } else {
                $client_info = Client::find($client);

                if ($client_info->fio != '') {
                    $client_name = $client_info->fio;
                }

                Clients_contacts::insert([

                    'val' => $data->value,
                    'keytip' => $data->adinfo,
                    'my_company_id' => $user->my_company_id,
                    'client_id' => $client,

                ]);

            }

            DB::table('chat_tema')->where('id', $data->tema_id)->update(['client_id' => $client, 'name' => $client_name]);


        } else {
            $client_info =   Client::find($prov_client->client_id); ;
            $client=$prov_client->client_id;


            if ($client == 0) {
                $client_name=$client_info->fio;
                Clients_contacts::insert([

                    'val' => $data->value,
                    'keytip' => $data->adinfo,
                    'my_company_id' => $user->my_company_id,
                    'client_id' =>  $prov_client->client_id,

                ]);

            }else{

if($client==$data->client_id){
if($client_info->fio!=''){
    $client_name=$client_info->fio;
    }




}








            }






            DB::table('chat_tema')->where('id', $data->tema_id)->update(['client_id' => $client, 'name' => $client_name]);
        }


    }


    /*adinfo	PHONE
    client_id	9
    value	79533089999*/
    public function createClientFromLead($projectID)
    {
        $client = 0;
        $p_Y = 0;
        $e_Y = 0;
        $project = Project::find($projectID);

        $email = $project->email;
        $phone = $this->parsephone($project->phone);

        if ($phone != '') {
            $prov_client = $this->search_client('val', $phone, 'PHONE', $project->my_company_id);
            if ($prov_client) {
                $client = $prov_client->client_id;
                $p_Y = 1;
            }

        }


        if ($email != '') {
            $prov_client = $this->search_client('val', $email, 'EMAIL', $project->my_company_id);
            if ($prov_client) {
                $client = $prov_client->client_id;
                $e_Y = 1;
            }

        }


        if ($client == 0) {
            $client = Client::insertGetId([
                'fio' => $project->fio,
                'company' => $project->company,
                'my_company_id' => $project->my_company_id,

            ]);
            if ($email != '') {

                Clients_contacts::insert([

                    'val' => $email,
                    'keytip' => 'EMAIL',
                    'my_company_id' => $project->my_company_id,
                    'client_id' => $client,

                ]);
            }
            if ($phone != '') {

                Clients_contacts::insert([

                    'val' => $phone,
                    'keytip' => 'PHONE',
                    'my_company_id' => $project->my_company_id,
                    'client_id' => $client,

                ]);
            }
        } else {

            if ($email != '') {
                if ($e_Y == 0) {
                    Clients_contacts::insert([

                        'val' => $email,
                        'keytip' => 'EMAIL',
                        'my_company_id' => $project->my_company_id,
                        'client_id' => $client,

                    ]);
                }
            }
            if ($phone != '') {
                if ($p_Y == 0) {
                    $client = Clients_contacts::insert([

                        'val' => $phone,
                        'keytip' => 'PHONE',
                        'my_company_id' => $project->my_company_id,
                        'client_id' => $client,

                    ]);
                }
            }


        }
        Project::where('id', $project->id)->update(['client_id' => $client]);
    }

    public function search_client($pole, $val, $tip, $my_company_id)
    {

        $search = Clients_contacts::where('my_company_id', $my_company_id)
            ->where($pole, $val)->first();


        return $search;
    }

    public function parsephone($phones)
    {
        $phone = trim($phones, '');
        $phone = trim($phone, '+');
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);
        $phone = str_replace("(", "", $phone);
        $phone = str_replace(")", "", $phone);
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);
        $phone = str_replace("(", "", $phone);
        $phone = str_replace(")", "", $phone);
        $new_s = preg_replace('/^8/', '7', $phone);
        return $new_s;
    }

    public function create()
    {
        $user = Auth::user();





        $partners = collect();


        $data['client_field'] = ProjectController::get_edit_field($partners, 1);

        $data['clients_contacts']=[];

        $data['clients_contacts_tip']=DB::table('clients_contacts_tip')->pluck('name','keytip')->toArray();
        return view('clients.edit', $data);

    }


    public function add_ajax(Request $request)
    {
        $user = Auth::user();
        $project_tag = Client::firstOrNew([
            'fio' => $request->t_fio,
            'email' => $request->t_email,
            'phone' => $request->t_phone,
            'company_id' => $request->taskId,
            'my_company_id' => $user->my_company_id

        ]);
        $project_tag->save();
        return $project_tag->id;

    }

    public function add_ajax_2(Request $request)
    {
        $user = Auth::user();
        $company_id = 0;


        $client = Client::insertGetId([
            'fio' => $request->fio,
            'phone' => $request->phone,
            'email' => $request->email,
            'company' => $request->company,
            'my_company_id' => $user->my_company_id

        ]);
        Project::where('client_id', $client)->update([

            'fio' => $request->fio,
            'phone' => $request->phone,
            'email' => $request->email,
            'company_id' => $company_id,
            'company' => $request->company,
            'my_company_id' => $user->my_company_id

        ]);

        $datafield = $request->datafield;
        $clientAndCompany['client_id'] = $client;
        $projectId = 0;
        ProjectController:: add_datafield($datafield, $clientAndCompany, $projectId);


    }

    static function addclient($tags_array)
    {
        $user = Auth::user();


        $project_tag = Client::firstOrNew([
            'fio' => $tags_array['fio'],
            'email' => $tags_array['email'],
            'phone' => $tags_array['phone'],
            'company_id' => 0,
            'my_company_id' => $user->my_company_id]);
        $project_tag->save();
        $data['client_id'] = $project_tag->id;


        return $data;
    }

    public function get_all()
    {
        $user = Auth::user();
        ProjectController::get_role('read', 2);
        $data['clients'] = Client::where('my_company_id', $user->my_company_id)->get();
        $data['user'] = $user;


        return view('clients.list', $data);


    }

    public function edit_view($id)
    {
        $user = Auth::user();

        $data = Client::where('my_company_id', $user->my_company_id)->findOrFail($id);


        $data->company = $data->company;

        $partners = collect();
        $partners->client_id = $id;

        $data['client_field'] = ProjectController::get_edit_field($partners, 1);

        $data['clients_contacts']=DB::table('clients_contacts')->where('client_id',$data->id)->get();

        $data['clients_contacts_tip']=DB::table('clients_contacts_tip')->pluck('name','keytip')->toArray();
        return view('clients.edit', $data);


    }

    static function client_edit_safe($request){
        $user=Auth::user();
        if($request->projectId>0) {
            $client = Client::where('my_company_id', $user->my_company_id)->where('id', $request->projectId)->first();
            $client->fio = $request->fio;
            $client->company = $request->company;
            $client->save();


//РЕДАКТИРУЕМ КОНТАКТЫ
            for ($i = 0; $i < count($request->edit_val); $i++) {

                DB::table('clients_contacts')->where('my_company_id', $user->my_company_id)->where('id', $request->edit_id[$i])->update([

                    'val' => $request->edit_val[$i]

                ]);
            }

        }else{

           $client=Client::insertGetId([
               'fio'=>$request->fio,
               'my_company_id'=>$user->my_company_id,
               'company'=>$request->company,

           ]);
            $client=Client::find($client);


        }
        for($i=0;$i<count($request->add_val);$i++){

            DB::table('clients_contacts')->where('my_company_id',$user->my_company_id)->where('id',$request->edit_id[$i])->insert([

                'val'=>$request->add_val[$i],
                'keytip'=>$request->add_keytip[$i],
                'my_company_id'=>$user->my_company_id,
                'client_id'=>$client->id,


            ])  ;
        }


        return $request;
/*
 * add_keytip	[…]
0	SEX
add_val	[…]
0	Мужской
 *
 * projectId	34
fio	Виктор Кравцов
company	null
edit_val	[…]
0	wistis@yandex.com
1	wistis@yandex.ru2
2	31.05.1988
edit_id	[…]
0	29
1	50
2	51*/
    }
    public function edit_post(Request $request)
    {
        $user = Auth::user();
        /*      contactId:contactId,
        company_id:company_id,
        fio:fio,
        phone:phone,
        email:email,
        company:company*/
        $client = Client::where('my_company_id', $user->my_company_id)->findOrFail($request->contactId);
        $company_id = $request->company_id;


        Client::where('id', $client->id)->update([
            'fio' => $request->fio,
            'phone' => $request->phone,
            'email' => $request->email,
            'company' => $request->company,
            'my_company_id' => $user->my_company_id

        ]);
        Project::where('client_id', $client->id)->update([

            'fio' => $request->fio,
            'phone' => $request->phone,
            'email' => $request->email,
            'company_id' => $company_id,
            'company' => $request->company,
            'my_company_id' => $user->my_company_id

        ]);
        /*\DB::connection('asterisk')->table('sippeers')->insert([
            'name' => 3105,
            'defaultuser' => 3105,
            'secret' => 'agres3105@',
            'context' => 'from-local',
            'host' => 'dynamic',
            'nat' => 'force_rport,comedia',
            'type' => 'friend',
            'qualify' => 'yes',
            'call-limit' => '1',
            'dtmfmode' => 'rfc2833',
            'transport' => 'udp',


        ]);*/
        $datafield = $request->datafield;
        $clientAndCompany['client_id'] = $client->id;
        $projectId = 0;
        ProjectController:: add_datafield($datafield, $clientAndCompany, $projectId);

    }

    public function destroy($id)
    {
        ProjectController::get_role('delete', 2);
        Client::where('id', $id)->delete();
    }
}
