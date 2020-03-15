<?php

namespace App\Console\Commands;
use App\Http\Controllers\GoogleUploadController;
use App\Http\Controllers\Reports\SmsReportsController;
use DB;
use Illuminate\Console\Command;
use Log;

class SendToGoogleDisk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendaudiotogoogle';

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
        $go=new GoogleUploadController();
        $go->upload_file_from_server();
    }
}
