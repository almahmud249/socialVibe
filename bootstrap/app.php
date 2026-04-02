<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'loginCheck'         => \App\Http\Middleware\LoginCheckMiddleware::class,
            'logoutCheck'        => \App\Http\Middleware\LogoutCheckMiddleware::class,
            'adminCheck'         => \App\Http\Middleware\IsAdminMiddleware::class,
            'PermissionCheck'    => \App\Http\Middleware\PermissionCheckerMiddleware::class,
            'isInstalled'        => \App\Http\Middleware\InstallCheckMiddleware::class,
            'jwt.verify'         => \App\Http\Middleware\JwtMiddleware::class,
            'CheckApiKey'        => \App\Http\Middleware\CheckApiKeyMiddleware::class,
            'XSS'                => \App\Http\Middleware\XssMiddleware::class,
            'whatsapp.connected' => \App\Http\Middleware\CheckWhatsAppConnection::class,
            'telegram.connected' => \App\Http\Middleware\CheckTelegramConnection::class,
            'subscriptionCheck'  => \App\Http\Middleware\SubscriptionMiddleware::class,
            'check.landing.page' => \App\Http\Middleware\CheckLandingPageStatus::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\XssMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
