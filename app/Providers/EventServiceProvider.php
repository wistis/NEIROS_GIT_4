<?php

namespace App\Providers;
use App\Project;
use Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
            'App\Listeners\ProjectListener',
        ],
        'project.created' => [

            'App\Events\ProjectEvent@projectCreated',

        ],
        'project.updated' => [

            'App\Events\ProjectEvent@projectUpdated',

        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
         
        //
    }
}
