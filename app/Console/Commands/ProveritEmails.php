<?php

namespace App\Console\Commands;
use Log;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\ImapController;


class ProveritEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:proveritemails';

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
        $ImapController=new ImapController();
 $getwidgets=DB::table('widgets')->where('tip',9)->where('status',1)->get();
 foreach ($getwidgets as $widget){
     Log::info('start_wid'.$widget->id);
     $widget_email=DB::table('widgets_email')->where('widget_id',$widget->id)->first();
     Log::info('start_wid dall' );
if($widget_email){
try {
    Log::info('start_wid start mail .'.time() );
    $ImapController->index($widget,$widget_email);
    Log::info('start_wid end mail .'.time() );
}catch (\Exception $e){
  
}
}



 }
        Log::info('start_wid end off .'.time() );



    }
}
