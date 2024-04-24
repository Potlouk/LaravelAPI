<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
      //  $middleware->append('UserMiddleware', 'App\Http\Middleware\UserMiddleware');
       // $middleware->append('EstateMiddleware', 'App\Http\Middleware\EstateMiddleware');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (App\Exceptions\AppException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'code' => $exception->getErrorCode(),
                'data' => $exception->getData()
            ], $exception->getCode());
        });
    })->create();
