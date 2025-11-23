<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        \App\Models\Ticket::observe(\App\Observers\TicketObserver::class);

        // Configure Socialite providers
        $this->configureSocialiteProviders();
    }

    protected function configureSocialiteProviders(): void
    {
        $socialite = $this->app->make(\Laravel\Socialite\Contracts\Factory::class);

        // Microsoft provider configuration
        $socialite->extend('microsoft', function ($app) use ($socialite) {
            $config = config('services.microsoft');
            return $socialite->buildProvider(\SocialiteProviders\Microsoft\Provider::class, $config);
        });
    }
}
