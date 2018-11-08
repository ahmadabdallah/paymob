<?php

namespace Ahmadabdallah\PayMob;

use Illuminate\Support\ServiceProvider;

class PaymobServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            // Config file.
            __DIR__ . '/config/paymob.php' => config_path('paymob.php'),
        ]);

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // PayMob Facade.
        $this->app->singleton('paymob', function () {
            return new PayMob();
        });
    }
}