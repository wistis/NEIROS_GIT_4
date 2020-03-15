<?php

namespace App\Console\Commands;

use App\Http\Controllers\AdwordsController;
use App\Models\Servies\CurrencyCurs;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\DirectController;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;
class GetCurs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getcurs';

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
        $setting=new CurrencyCurs();
        $data_json=file_get_contents('https://www.cbr-xml-daily.ru/daily_utf8.xml');
        $movies = new SimpleXMLElement($data_json);

        foreach ($movies->Valute as $key){

            if($key->CharCode=='USD'){
                $setting->curs=str_replace(",",".",$key->Value);

                $setting->date=date('Y-m-d');
            }

        }
        $setting->save();





    }
}
