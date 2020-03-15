<?php

namespace App\Console\Commands;

use App\Models\DirectLog;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\DirectController;
use Illuminate\Support\Facades\Log;

class GetPersonalDirect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getpersonaldirect {audioid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверка почты каждые 15ми';

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
        $DirectController=new DirectController();
        $id = $this->argument('audioid');
        try {
            $wi_dir = DB::table('widget_direct')->
            join('widgets', 'widgets.id', '=', 'widget_direct.widget_id')
                ->where('widgets.status', 1)
                ->where('widget_direct.id', $id)
                ->select('widget_direct.id as wdid', 'widget_direct.my_company_id as myc', 'widget_direct.email as wemail', 'widget_direct.token as token','widgets.sites_id as site_id')->first();

$log=new DirectLog();
$log->name='Запуск импорта директа';
$log->my_company_id=$wi_dir->myc;
$log->save();
$log->parent_id=$log->id;
$log->save();
$parent=$log->id;


         $DirectController->get_companyotchet_new($wi_dir);
            $log=new DirectLog();
            $log->name='Конец импорта директа';
            $log->my_company_id=$wi_dir->myc;
          $log->parent_id=$parent;
            $log->save();
        }catch (\Exception $e){
            Log::info($e);
        }


        try {


            $log=new DirectLog();
            $log->name='Запуск обновления из файла';
            $log->my_company_id=$wi_dir->myc;
            $log->parent_id=$parent;
            $log->save();
            $DirectController->uploadfile($wi_dir->wdid);
            $log=new DirectLog();
            $log->parent_id=$parent;
            $log->name='Конец обновления из файла';
            $log->my_company_id=$wi_dir->myc;
            $log->save();
        }catch (\Exception $e){
            Log::info($e);
        }







    }
}
