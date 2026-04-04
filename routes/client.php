<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Client\AccountsController;
use App\Http\Controllers\Client\AiWriterController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\ClientSettingController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\PostTemplateController;
use App\Http\Controllers\Client\TemplateController;
use App\Http\Controllers\Client\TicketController;
use App\Http\Controllers\Client\UserController;
use Illuminate\Support\Facades\Route;

Route::any('available-plans', fn () => redirect()->route('client.dashboard'))->name('available.plans');
Route::any('pending-subscription', fn () => redirect()->route('client.dashboard'))->name('pending.subscription');
Route::any('upgrade-plan/{id}', fn () => redirect()->route('client.dashboard'))->name('upgrade.plan');
Route::any('offline-claim', fn () => redirect()->route('client.dashboard'))->name('offline.claim');
Route::any('upgrade-plan/free', fn () => redirect()->route('client.dashboard'))->name('upgrade-plan.free');
Route::any('stripe-redirect', fn () => redirect()->route('client.dashboard'))->name('stripe.redirect');
Route::any('stripe-success', fn () => redirect()->route('client.dashboard'))->name('stripe.payment.success');
Route::any('paypal-redirect', fn () => redirect()->route('client.dashboard'))->name('paypal.redirect');
Route::any('paypal-success', fn () => redirect()->route('client.dashboard'))->name('paypal.payment.success');
Route::any('paddle-redirect', fn () => redirect()->route('client.dashboard'))->name('paddle.redirect');
Route::any('paddle-success', fn () => redirect()->route('client.dashboard'))->name('paddle.payment.success');
Route::any('razor_pay-redirect', fn () => redirect()->route('client.dashboard'))->name('razor.pay.redirect');
Route::any('client/razor_pay-success', fn () => redirect()->route('client.dashboard'))->name('razor.pay.payment.success');
Route::any('mercadopago-redirect', fn () => redirect()->route('client.dashboard'))->name('mercadopago.redirect');
Route::any('mercadopago-success', fn () => redirect()->route('client.dashboard'))->name('mercadopago.success');
Route::get('back-to-admin', [AuthenticatedSessionController::class, 'back_to_admin'])->name('back.to.admin');

Route::group(['prefix' => localeRoutePrefix().'/client', 'middleware' => 'subscriptionCheck'], function () {
    Route::any('my-subscription', fn () => redirect()->route('client.dashboard'))->name('my.subscription');
    // Dashboard Routes
    Route::get('dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    // General Settings Routes
    Route::get('general-settings', [ClientSettingController::class, 'generalSettings'])->name('general.settings');
    Route::post('general-settings/{id}', [ClientSettingController::class, 'updateGeneralSettings'])->name('general.settings.update');
    Route::get('api', [ClientSettingController::class, 'api'])->name('settings.api');
    Route::post('api', [ClientSettingController::class, 'update_api'])->name('settings.api.update');
    Route::post('ai_reply/status-update', [ClientSettingController::class, 'AIReplyStatus'])->name('setting.ai-reply.status-update');
    Route::any('billing/details', fn () => redirect()->route('client.dashboard'))->name('billing.details');
    Route::any('billing/details/store/{id}', fn () => redirect()->route('client.dashboard'))->name('billing.details.store');
    // Profile Routes
    Route::get('profile', [ClientDashboardController::class, 'profile'])->name('profile.index');
    Route::patch('update', [ClientDashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::get('password-change', [ClientDashboardController::class, 'passwordChange'])->name('profile.password-change');
    Route::post('password-update', [ClientDashboardController::class, 'passwordUpdate'])->name('profile.password-update');
    // tickets route
    Route::resource('tickets', TicketController::class)->except(['edit', 'destroy']);
    Route::get('ticket/update/{id}', [TicketController::class, 'update'])->name('ticket.update');
    Route::post('ticket-reply', [TicketController::class, 'reply'])->name('ticket.reply');
    Route::get('ticket-reply-edit/{id}', [TicketController::class, 'replyEdit'])->name('ticket.reply.edit');
    Route::post('ticket-reply-update/{id}', [TicketController::class, 'replyUpdate'])->name('ticket.reply.update');
    Route::delete('ticket-reply-delete/{id}', [TicketController::class, 'replyDelete'])->name('ticket.reply.delete');
    Route::any('team-list', fn () => redirect()->route('client.dashboard'))->name('team.index');
    Route::any('team/create', fn () => redirect()->route('client.dashboard'))->name('team.create');
    Route::any('team/store', fn () => redirect()->route('client.dashboard'))->name('team.store');
    Route::any('team/edit/{id}', fn () => redirect()->route('client.dashboard'))->name('team.edit');
    Route::any('team/update/{id}', fn () => redirect()->route('client.dashboard'))->name('team.update');

    // AI writer
    Route::get('ai-writer', [AiWriterController::class, 'index'])->name('ai.writer');
    Route::post('ai-writer', [AiWriterController::class, 'saveAiSetting'])->name('ai.writer');
    Route::get('ai-writer-setting', [ClientSettingController::class, 'aiWriterSetting'])->name('ai_writer.setting');
    Route::post('generated-ai-content', [AiWriterController::class, 'generateContent'])->name('ai.content');

    // AI Template
    Route::get('templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::post('template/store', [TemplateController::class, 'store'])->name('template.store');
    Route::delete('template/delete/{id}', [TemplateController::class, 'delete'])->name('template.delete');
    Route::get('template/edit/{id}', [TemplateController::class, 'edit'])->name('template.edit');
    Route::post('template/update/{id}', [TemplateController::class, 'update'])->name('template.update');

    // user route
    Route::get('users/verified/{verify}', [UserController::class, 'instructorVerified'])->name('users.verified');
    Route::get('users/ban/{id}', [UserController::class, 'instructorBan'])->name('users.ban');
    Route::post('user-status', [UserController::class, 'statusChange'])->name('users.status');
    Route::delete('users/delete/{id}', [UserController::class, 'instructorDelete'])->name('users.delete');

    Route::post('onesignal-subscription', [UserController::class, 'oneSignalSubscription'])->name('onesignal');
    Route::get('onesignal-notification', [UserController::class, 'oneSignalNotification'])->name('onesignal.notification');
    Route::any('stop-recurring/{id}', fn () => redirect()->route('client.dashboard'))->name('stop.recurring');
    Route::any('enable-recurring/{id}', fn () => redirect()->route('client.dashboard'))->name('enable.recurring');
    Route::any('cancel-subscription/{id}', fn () => redirect()->route('client.dashboard'))->name('cancel.subscription');

    Route::get('accounts/{plat_form}', [AccountsController::class, 'index'])->name('accounts.index');
    Route::get('accounts-create', [AccountsController::class, 'create'])->name('accounts.create');
    Route::delete('accounts-delete/{id}', [AccountsController::class, 'destroy'])->name('accounts.delete');
    Route::get('accounts-callback/{plat_form}', [AccountsController::class, 'callback'])->name('accounts.callback');

    Route::get('posts/{type}', [PostController::class, 'index'])->name('posts.index');
    Route::get('post/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::delete('posts/destroy/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('post/template', [PostTemplateController::class, 'index'])->name('post.template.index');
    Route::post('posts/template/store', [PostTemplateController::class, 'store'])->name('post.template.store');
    Route::get('posts/template/edit/{id}', [PostTemplateController::class, 'edit'])->name('post.template.edit');
    Route::post('posts/template/update/{id}', [PostTemplateController::class, 'update'])->name('post.template.update');
    Route::delete('posts/template/destroy/{id}', [PostTemplateController::class, 'delete'])->name('post.template.destroy');

    Route::get('calendar', [PostController::class, 'calendar'])->name('calendar');
});
Route::get('image', function (){

});
Route::get('chat-refresh', function () {
    \Illuminate\Support\Facades\Artisan::call('chat:refresh');

    return 'success';
})->name('chat.refresh');
