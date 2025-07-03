<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [

            // Use when you want the default Laravel behavior
            // Register the ForceJsonResponse middleware globally
            // aka returns anykind of response, Defaults to HTML if we have View, if not then JSON
            // Sanctum: Handles authentication method (session vs token auth)
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

            // Use when you want to force JSON responses
            // ForceJsonResponse: Always returns JSON, never HTML (regardless of Accept header)
            // \App\Http\Middleware\ForceJsonResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
