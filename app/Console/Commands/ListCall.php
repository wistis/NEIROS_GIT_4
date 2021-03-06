<?php

namespace App\Console\Commands;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\GoogleUploadController;
use Google\Protobuf\Api;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Log;

class ListCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:listcall';

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
     //   $DirectController=new AjaxController();

       // $DirectController->generatecallback();
       // $DirectController->generatecalltrack();


        $ajax=new AjaxController();

        $ajax-> generatecallback();
        $ajax-> generatecalltrack();
        $go=new GoogleUploadController();
        $go->upload_file_from_server();
        $go->get_file();
        $go->set_permis(3);






    }
}
