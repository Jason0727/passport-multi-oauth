<?php

namespace App\Providers;

use App\Listeners\RevokeAccessToken;
use App\Listeners\RevokeRefreshToken;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Passport\Events\AccessTokenCreated;
use Laravel\Passport\Events\RefreshTokenCreated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // 监听清除旧 Access Token
        AccessTokenCreated::class => [
            RevokeAccessToken::class
        ],
        // 监听清除旧 Fresh Token(此处好像没必要单独写，写在上面清除Access Token 方法中即可)
        RefreshTokenCreated::class => [
            // RevokeRefreshToken::class
        ]
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
