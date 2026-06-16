<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
        'contributor' => \App\Http\Middleware\EnsureContributor::class,
        'admin'       => \App\Http\Middleware\EnsureAdmin::class,
    ]);
     $middleware->redirectGuestsTo(function ($request) {
        if ($request->is('admin/*')) {
            return route('admin.login');
        }
        return route('login');
    });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
