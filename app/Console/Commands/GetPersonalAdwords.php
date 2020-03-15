<?php

namespace App\Console\Commands;

use App\Http\Controllers\AdwordsController;
use App\Widgets;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\DirectController;
use Illuminate\Support\Facades\Log;
use LaravelGoogleAds\Services\AuthorizationService;
use LaravelGoogleAds\Services\AdWordsService;
class GetPersonalAdwords extends Command
{   protected $authorizationService;
    protected $adWordsService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getpersonaladwords {audioid}';

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
    public function __construct(AdWordsService $adWordsService,AuthorizationService $authorizationService)
    {
        $this->adWordsService = $adWordsService;
        $this->authorizationService = $authorizationService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $id = $this->argument('audioid');

        $adw=new AdwordsController($this->adWordsService, $this->authorizationService);
        $widgets=Widgets::where('tip',20) ->with('w20')->where('status',1)->where('id',$id)->first();

        $adw->getCompany('',$widgets->w20);









    }
}
