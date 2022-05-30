<?php

namespace App\Providers;

use App\Infrastructure\LaravelMultiDispatcher;
use App\Infrastructure\MultiDispatcher;
use App\Services\Sms\Sms;
use App\Services\Sms\SmsLog;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Sms::class, function (Application $app) {
//            if($app->runningUnitTests()){
//
//            }
            return new SmsLog();
        });
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);

//        $this->app->bind(Sms::class, function (Application $app) {
//            return new SmsLog();
//        });


        $this->app->bind(MultiDispatcher::class, LaravelMultiDispatcher::class);
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
