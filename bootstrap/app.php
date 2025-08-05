<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; // Import the middleware

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register global middleware here
        // $middleware->append(SomeMiddleware::class);

        // Register route middleware
        $middleware->alias([
            'admin' => AdminMiddleware::class, // Register the 'admin' middleware
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
