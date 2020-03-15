<?php

namespace App\Events;

use App\Http\Controllers\Api\GaCallController;
use App\Http\Controllers\LeadPayController;
use App\Http\Controllers\MetrikaController;
use App\Models\MetricaCurrent;
use App\Models\NeirosClientId;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Project;
use Log;

class ProjectEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
    public function projectCreated(Project $project)

    {    Log::useFiles(base_path() . '/storage/logs/toproject.log', 'info');

        Log::info("Category Created: ".$project );
        Log::info("Category Created: ".$project->id );
        Log::info("WID 3: ".$project->id );




        if($project->client_project_id==1){
            $pr=Project::where('site_id',$project->site_id)->max('client_project_id');
            $new_max=$pr+1;
            $project->client_project_id=$new_max;
            $project->save();
        }


        $Metrika=new MetrikaController();
        $Metrika->send_to_metrika($project);

        $ga=new GaCallController();
        $ga->form_lead($project->id,0);



    }
    public function projectUpdated(Project $project)

    {    Log::useFiles(base_path() . '/storage/logs/toproject_updated.log', 'info');
        info('обновим сумму от битрикса');

    $pr=Project::find($project->id);
        try {
            if($pr){
        if($pr->summ>0) {

            $MetricaCurrent = new MetricaCurrent();
        $find=$MetricaCurrent->setTable('metrica_' . $pr->my_company_id)->where('typ','payment')->where('project_id', $project->id)->first();

            if($find){info('метрика найдена');
                $find->summ=$pr->summ;
                $find->lead=1;
                $find->save();

            }else{
                LeadPayController::createPayment($pr);


            }
            /*  $MetricaCurrent = new MetricaCurrent();


              $MetricaCurrent->setTable('metrica_' . $project->my_company_id)->where('project_id', $project->id)
                  ->update(['summ'=>$project->summ,'lead'=>1

                  ]);*/

        }
        }
        }catch (\Exception $e){
info($e);

        }


    }
}
