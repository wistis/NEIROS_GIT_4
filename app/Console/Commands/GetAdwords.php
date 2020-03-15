<?php

namespace App\Console\Commands;

use App\Http\Controllers\AdwordsController;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\DirectController;
use Illuminate\Support\Facades\Log;

class GetAdwords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:provdirectotchet';

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
      /*  $DirectController=new AdwordsController();

        //   try {
        return    $DirectController->provotchet();*/
        /*    }catch (\Exception $e){
                Log::info($e);
            }*/








    }
}
