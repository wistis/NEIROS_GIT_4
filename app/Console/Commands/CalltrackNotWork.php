<?php

namespace App\Console\Commands;

use App\Http\Controllers\AdminTMController;
use App\Http\Controllers\AsteriskController;
use App\Widgets;
use DB;
use App\Models\Admin_template_messages;
use Illuminate\Console\Command;

class CronMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:calltrackonof';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = ' ';

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


      $widgets=Widgets::where('tip',2)->get();
      foreach ($widgets as $widget){

          $Aster=new AsteriskController();
          $Aster->set_work_or_not_work($widget);


      }
    }
}
