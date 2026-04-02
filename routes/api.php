<?php

use App\Http\Controllers\Api\Client\AuthController;
use App\Http\Controllers\Api\Client\PostController;
use App\Http\Controllers\Api\Client\TeamController;
use App\Http\Controllers\Api\Client\TicketController;
use App\Http\Controllers\Api\Setting\CountryController;
use App\Http\Controllers\Api\Setting\CurrencyController;
use App\Http\Controllers\Api\Setting\DepartmentController;
use App\Http\Controllers\Api\Setting\TimezoneController;
use Illuminate\Support\Facades\Route;
use Pusher\Pusher;

Route::group(['prefix' => localeRoutePrefix().'/api'], function () {
    Route::middleware(['CheckApiKey'])->group(function () {

        Route::get('country/list', [CountryController::class, 'index']);
        Route::get('currency/list', [CurrencyController::class, 'index']);
        Route::get('department/list', [DepartmentController::class, 'index']);
        Route::get('timezone/list', [TimezoneController::class, 'index']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);

        Route::post('login', [AuthController::class, 'login']);
        Route::middleware('jwt.verify')->group(function () {

            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('profile', [AuthController::class, 'profile']);
            Route::post('profile-update', [AuthController::class, 'profileUpdate']);
            // ------------Whatsapp start----------//

            // Ticket api
            Route::get('ticket', [TicketController::class, 'index']);
            Route::post('ticket-store', [TicketController::class, 'createTicket']);
            Route::post('ticket-reply', [TicketController::class, 'replyTicket']);
            Route::get('ticket-reply-edit/{id}', [TicketController::class, 'replyEdit']);
            Route::post('ticket-reply-update/{id}', [TicketController::class, 'replyUpdateTicket']);
            // Team api
            Route::get('team', [TeamController::class, 'index']);
            Route::post('team-store', [TeamController::class, 'store']);
            Route::post('team-update/{id}', [TeamController::class, 'store']);

            // social post
            Route::get('posts', [PostController::class, 'index']);
            Route::post('posts/store', [PostController::class, 'store']);
        });
    });
});

Route::get('check-pusher', function () {
    $client_id  = 15;
    $app_key    = setting('pusher_app_key');
    $app_secret = setting('pusher_app_secret');
    $app_id     = setting('pusher_app_id');
    $cluster    = setting('pusher_app_cluster');
    $pusher     = new Pusher($app_key, $app_secret, $app_id, ['cluster' => $cluster]);

    $pusher->trigger("message-received-$client_id", 'App\Events\ReceiveUpcomingMessage', []);
});
