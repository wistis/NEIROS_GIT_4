<?php

namespace App\Console\Commands;
use App\Http\Controllers\Reports\SmsReportsController;
use DB;
use Illuminate\Console\Command;
use Log;

class SendSmsReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:smsreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
      try {
          $newo = new SmsReportsController();
          $newo->prov_sms();
      }catch (\Exception $e){
          info($e);
      }
    }
}
