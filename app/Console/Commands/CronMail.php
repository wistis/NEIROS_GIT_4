<?php

namespace App\Console\Commands;

use App\Http\Controllers\AdminTMController;
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
    protected $signature = 'command:cronmail';

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


     $AdminTMController = new AdminTMController();

        $Atm = Admin_template_messages::where('tip', 1)->first();

        if ( date('H')==$Atm->time) {

            $users = DB::table('users')->where('test_period', 1)->get();
            foreach ($users as $user) {


           return     $AdminTMController->send_mail($user, 1, $Atm);
            }

        }
    }
}
