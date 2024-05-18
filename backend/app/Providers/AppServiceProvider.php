<?php

namespace App\Providers;

use App\Exceptions\ExceptionTypes;
use App\Services\ErrorCheckService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(['App\Services\UserService','App\middleware\Http\Middleware\UserMiddleware'])
        ->needs('App\Services\ErrorCheckService')
        ->give(function () {
            return new ErrorCheckService(ExceptionTypes::UserException);
        });


       $this->app->when('App\Services\ImagesService')
        ->needs('App\Services\ErrorCheckService')
        ->give(function () {
            return new ErrorCheckService(ExceptionTypes::ImageException);
        });

        $this->app->when(['App\Services\EstateService','App\middleware\Http\Middleware\EstateMiddleware'])
        ->needs('App\Services\ErrorCheckService')
        ->give(function () {
            return new ErrorCheckService(ExceptionTypes::EstateException);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
