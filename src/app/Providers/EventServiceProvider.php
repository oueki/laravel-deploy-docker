<?php

namespace App\Providers;

use App\Events\BookCreated;
use App\Events\BookUpdatePrice;
use App\Listeners\SendNotifyAfterCreateBook;
use App\Listeners\SendPriceChangeNotify;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BookCreated::class => [
            SendNotifyAfterCreateBook::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            BookUpdatePrice::class,
            [SendPriceChangeNotify::class, 'handle']
        );

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
