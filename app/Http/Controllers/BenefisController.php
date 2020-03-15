<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\WidgetApiController;
use App\Models\Benefis\EduConnect;
use App\Models\MetricaCurrent;
use App\Project;
use App\Stage;
use App\Widgets;
use Illuminate\Http\Request;
use DB;
class BenefisController extends Controller
{
    public function index()
    {


        $this->reload_neiros_visit();

        $connects = EduConnect::with('contract')->where('neiros_visit', '>', 0)->where('parent_id', 0) ->where('neiros_project_id', 0)
        ->orderby('id','desc')->get();
        $amount_connect = 0;
        $amount_project = 0;

        $my_stage[0] = 88;
        $my_stage[1] = 89;
        $my_stage[2] = 90;



        foreach ($connects as $connect) {


            if (count($connect->contract) > 0) {

                foreach ($connect->contract as $item) {


                    $prov_contract = Project::where('neiros_visit', $connect->neiros_visit)->where('my_company_id',40)->where('benefis_contract_id', $item->id)->first();
                    if (!$prov_contract) {


                        $project_without_contract = Project::where('neiros_visit', $connect->neiros_visit)->where('my_company_id',40)->where('benefis_connect_id', 0)->first();
                        /*Если есть сделка без коннракта*/


                        if ($project_without_contract) {

                            $connect->neiros_project_id = 1;

                            $project_without_contract->benefis_connect_id = $connect->id;
                            $project_without_contract->benefis_contract_id = $item->id;
                            $project_without_contract->summ = $item->summ;
                            $project_without_contract->stage_id = 113;
                            $project_without_contract->save();


                        } else {
                            /*если нет свободной сделки*/
                            $connect->neiros_project_id = 1;
                            $data['summ'] = $item->payd;
                            $data['fio'] = $connect->name;
                            $data['phone'] = $connect->phone;
                            $data['email'] = $connect->email;
                            $data['my_company_id'] = 40;
                            $data['benefis_connect_id'] = $connect->id;
                            $data['benefis_contract_id'] = $item->id;
                            $data['reports_date'] = $item->created_at;
                            $data['created_at'] = $item->created_at;
                            $data['updated_at'] = $item->created_at;
                            $data['neiros_visit'] = $connect->neiros_visit;
                            $data['user_id'] = $connect->neiros_visit;
                            $data['stage_id'] = 113;
                            $projectId = $this->create_lead_ben($data, 'dded5890b53396b3357335bf18af6159_42');

                            $connect->neiros_project_id = 1;
                        }


                    }

                }


            } else {
                $prov_contract = Project::where('neiros_visit', $connect->neiros_visit)->where('my_company_id',40)->first();
                if ($prov_contract) {

                    $connect->neiros_project_id = 1;

                    $prov_contract->benefis_connect_id = $connect->id;

                    if (isset($my_stage[$connect->type])) {
                        $prov_contract->stage_id = 113;
                    }


                    $prov_contract->save();


                }
            }


            /*`benefis_connect_id` INT NULL DEFAULT '0' AFTER `ncl_id`, ADD `benefis_contract_id`*/
            /* $connect->neiros_project_id=$project->id;
             $connect->save();
             $project->benefis_connect_id=$connect->id;
             $project->save();*/

            $connect->save();
        }

        dd($amount_project);
    }


    public function create_lead_ben($data, $key)
    {

        $site = DB::table('sites')->where('hash', $key)->first();
        if (!$site) {
            Log::info('Error site');
            return '1';
        }

        $widget = Widgets::where('sites_id', $site->id)->where('tip', 3)->where('status', 1)->first();
        if (!$widget) {
            Log::info('Error widget');
            return 'error02';

        }







        $WidgetApiController = new WidgetApiController();
        $getallwid = Project::where('widget_id',$widget->id)->count();
        $getallwid++;
        $projectId = $WidgetApiController->create_lead([
            'name' => 'Заявка с форм № ' . $getallwid,
            'stage_id' => $data['stage_id'],
            'user_id' => 12,
            'summ' => $data['summ'],
            'phone' => $data['phone'],
            'comment' => $widget->name,
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
            'benefis_connect_id' => $data['benefis_connect_id'],
            'benefis_contract_id' => $data['benefis_contract_id'],
            'reports_date' => $data['reports_date'],
            'fio' => $data['fio'],
            'company' => '',
            'widget_id' => $widget->id,
            'sub_widget' => 'benefis',
            'my_company_id' => $widget->my_company_id,
            'neiros_visit' => $data['neiros_visit'],
            'vst' => 0,
            'pgs' => 0,
            'url' => '',
            'site_id' => $widget->sites_id,
            'week' => date("W", strtotime($data['updated_at'])),
            'hour' => date("H", strtotime($data['updated_at']))
        ], $data);;
        return $projectId;
    }

    function reload_neiros_visit()
    {

        $connects = \DB::connection('benefis')->table('edu_connects')->where('neiros_project_id', 0)->where('neiros_visit', '>', 0)->get();

        foreach ($connects as $connect) {

            if ($connect->parent_id > 0) {


                $ben_connect = EduConnect::find($connect->parent_id);
                if ($ben_connect) {

                    if ($ben_connect->neiros_visit == 0) {
                        $ben_connect->neiros_visit = $connect->neiros_visit;
                        $ben_connect->save();
                    }


                }

            }


        }


    }


}
