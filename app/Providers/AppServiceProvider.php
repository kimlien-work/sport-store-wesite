<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use App\Listeners\SyncCartOnLogin;
use App\Events\OrderPlaced;
use App\Listeners\SendOrderConfirmation;
use App\Events\OrderStatusChanged;
use App\Listeners\SendOrderStatusNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            SyncCartOnLogin::class,
        ],
        OrderPlaced::class => [
            SendOrderConfirmation::class,
        ],
        OrderStatusChanged::class => [
            SendOrderStatusNotification::class,
        ],
    ];

    public function boot()
    {
        //
    }
}