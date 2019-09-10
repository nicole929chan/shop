<?php

namespace App\Providers;

use App\Plan\Card;
use App\Plan\Plan;
use App\Plan\Redeem;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Plan::class, function ($app) {
            return new Plan($app->auth->user(), new Card(new ImageManager()), new Redeem());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
