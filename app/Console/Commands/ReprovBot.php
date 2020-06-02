<?php

namespace App\Console\Commands;

use App\Http\Controllers\AsteriskController;
use App\Models\SearchToCpc;
use App\Servies\SearchBot;
use App\Users_company;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\DirectController;
use Illuminate\Support\Facades\Log;

class ReprovBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deletebot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверка роутинга астера 1 час';

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

     $company=Users_company::get();
        foreach ($company as $item) {


            $bots = SearchToCpc::where('format', 'rf')->get();
            foreach ($bots as $bot) {
                try {
                    DB::connection('neiros_metrica')->table('metrica_' . $item->id)->where('bot', 0)
                        ->where('ep','LIKE',   '%'.$bot->name.'%')->update([
                            'typ' =>$bot->typ,
                            'src' =>$bot->src
                        ]);
                } catch (\Exception $e) {

                }
            }
}



        $company=Users_company::get();
        foreach ($company as $item) {
            try {


                 $bots =SearchBot::where('new',1)->get();;

                foreach ($bots as $itembot) {

                    DB::connection('neiros_metrica')->table('metrica_' . $item->id)->where('bot', 0)
                        ->where('uag', 'LIKE', '%' . $itembot->name . '%')->update([
                            'bot' => 1
                        ]);


                }

            }catch (\Exception $e){
print $item->id.',';
            }
        }

   $bots =SearchBot::where('new',1)->get();;
     foreach ($bots as $itembot) {

         $itembot->new=0;
         $itembot->save();
     }
    }
}
