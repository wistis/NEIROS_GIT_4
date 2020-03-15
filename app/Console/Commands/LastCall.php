<?php

namespace App\Console\Commands;

use App\Http\Controllers\ApiController;
use Google\Protobuf\Api;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Log;

class LastCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:lastcall';

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
        $DirectController=new ApiController();
        $prods=DB::table('widget_callback_later')->where('time_to_call','<',time())->where('status',0)->get();
        foreach ($prods as $prod){
            DB::table('widget_callback_later')->where('id',$prod->id)->update(['status'=>1]);
            $DirectController->callback_later($prod);


        }












    }
}
