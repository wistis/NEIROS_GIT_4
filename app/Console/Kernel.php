<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         Commands\ProveritEmails::class,
         Commands\GetCallDuration::class,
         Commands\GetMetrikaKey::class,
         Commands\Socketio::class,
         Commands\Provdirectotchet::class,
         Commands\DeletDemo::class,
         Commands\LastCall::class,
         Commands\GetPersonalDirect::class,
         Commands\CronMail::class,
         Commands\GetCurs::class,
         Commands\RouteControll::class,
         Commands\GetAdwordsReports::class,
         Commands\GetPersonalAdwords::class,
         Commands\SendSmsReport::class,
         Commands\ClearViewCache::class,

         Commands\Texttobase::class,
         Commands\ListCall::class,
         Commands\GetDirectCompany::class,
         Commands\SendToGoogleDisk::class,
         Commands\ReprovBot::class,
         Commands\GetRecords::class,
         Commands\ProvdirectotchetCorrect::class,
         Commands\GetPersonalDirectCorrect::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('monitor:check-uptime')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
