<?php

namespace TestApi\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'TestApi\Events\ExampleEvent' => [
            'TestApi\Listeners\ExampleListener',
        ],
    ];
}
