<?php

namespace App\Console\Commands;

use App\Http\Controllers\AdwordsController;
use App\Models\Servies\CurrencyCurs;
use App\Widgets;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\DirectController;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;
class GetDirectCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getdirectcompany';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
$widgets=Widgets::where('tip',11)->where('status',1)->get();
foreach ($widgets as $item){
 $wm = DB::table('widget_direct')->where('widget_id', $item->id) ->first();

    try {


    $direct=new DirectController();
    $direct->get_companys($wm->id);
    }catch (\Exception $e){
        info('GetDirectCompany');
        info($item->my_company_id);


    }

}





    }
}
