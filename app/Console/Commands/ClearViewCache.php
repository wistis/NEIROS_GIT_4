<?php

namespace App\Console\Commands;

use App\Http\Controllers\AdminTMController;
use DB;
use App\Models\Admin_template_messages;
use Illuminate\Console\Command;

class ClearViewCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:clearcache';

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


        \Artisan::call('view:clear');
    }
}
