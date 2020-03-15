<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\MetrikaController;
use Illuminate\Support\Facades\Log;

class GetMetrikaKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:metrikakey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получить ключи метрики';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $MetrikaController=new MetrikaController();

        $getwidgets=DB::table('widgets')->where('tip',10)->where('status',1)->get();
        foreach ($getwidgets as $widget){

            $widget_email=DB::table('widget_metrika')->where('widget_id',$widget->id)->first();


            if($widget_email){
                if(is_null($widget_email->last_upload)){
                    $user=DB::table('users')->where('id',$widget_email->user_id)->first();
                    $last_upload=$user->created_at;
                }else{

                }$last_upload=$widget_email->last_upload;
                $last_upload='2018-08-08';

                try {
                    $MetrikaController->widget_metrika_get_keywords2($widget,$widget_email,$last_upload);
                }catch (\Exception $e){
                    Log::info($e);
                }
            }


       // DB::table('widget_metrika')->where('id',$widget_email->id)->update(['last_upload'=>date('Y-m-d 00:00:00',time())]);
        }




    }
}
