<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register API subscription tier middleware
        $middleware->alias([
            'subscription.tier' => \App\Http\Middleware\CheckSubscriptionTier::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        // Downgrade expired paid users daily at midnight
        $schedule->command('users:downgrade-expired')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
