<?php

namespace App\Console\Commands;

use App\Http\Controllers\AdwordsController;
use App\Http\Controllers\IndexController;
use App\Widgets;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\DirectController;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
class GetAdwordsReports extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getadwordsreport';

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
    public function __construct( )
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

        $widgets=Widgets::where('tip',20) ->with('w20')->where('status',1)->get();

        foreach ($widgets as $item){

            $process = new Process('/opt/php72/bin/php artisan command:getpersonaladwords ' . $item->id . ' >adwords_reports_download.txt', $_ENV['ARTISAN_PATH']);
            $m = $process->start();

        }






    }
}
