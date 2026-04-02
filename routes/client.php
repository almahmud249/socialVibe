<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Client\AccountsController;
use App\Http\Controllers\Client\AiWriterController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\ClientSettingController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\PostTemplateController;
use App\Http\Controllers\Client\SubscriptionController;
use App\Http\Controllers\Client\TeamController;
use App\Http\Controllers\Client\TemplateController;
use App\Http\Controllers\Client\TicketController;
use App\Http\Controllers\Client\UserController;
use Illuminate\Support\Facades\Route;

Route::get('available-plans', [SubscriptionController::class, 'availablePlans'])->name('available.plans');
Route::get('pending-subscription', [SubscriptionController::class, 'pendingSubscription'])->name('pending.subscription');
Route::get('upgrade-plan/{id}', [SubscriptionController::class, 'upgradePlan'])->name('upgrade.plan');
Route::post('offline-claim', [SubscriptionController::class, 'offlineClaim'])->name('offline.claim');
Route::post('upgrade-plan/free', [SubscriptionController::class, 'upgradeFreePlan'])->name('upgrade-plan.free');
Route::post('stripe-redirect', [SubscriptionController::class, 'stripeRedirect'])->name('stripe.redirect');
Route::get('stripe-success', [SubscriptionController::class, 'stripeSuccess'])->name('stripe.payment.success');
Route::post('paypal-redirect', [SubscriptionController::class, 'paypalRedirect'])->name('paypal.redirect');
Route::get('paypal-success', [SubscriptionController::class, 'paypalSuccess'])->name('paypal.payment.success');
Route::post('paddle-redirect', [SubscriptionController::class, 'paddleRedirect'])->name('paddle.redirect');
Route::match(['get', 'post'], 'paddle-success', [SubscriptionController::class, 'paddleSuccess'])->name('paddle.payment.success');
Route::post('razor_pay-redirect', [SubscriptionController::class, 'razorPayRedirect'])->name('razor.pay.redirect');
Route::match(['post', 'get'], 'client/razor_pay-success', [SubscriptionController::class, 'razorPaySuccess'])->name('razor.pay.payment.success');
Route::post('mercadopago-redirect', [SubscriptionController::class, 'mercadopagoRedirect'])->name('mercadopago.redirect');
Route::match(['post', 'get'], 'mercadopago-success', [SubscriptionController::class, 'mercadopagoSuccess']);
Route::get('back-to-admin', [AuthenticatedSessionController::class, 'back_to_admin'])->name('back.to.admin');

Route::group(['prefix' => localeRoutePrefix().'/client', 'middleware' => 'subscriptionCheck'], function () {
    // Subscription Routes
    Route::get('my-subscription', [SubscriptionController::class, 'mySubscription'])->name('my.subscription');
    // Dashboard Routes
    Route::get('dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    // General Settings Routes
    Route::get('general-settings', [ClientSettingController::class, 'generalSettings'])->name('general.settings');
    Route::post('general-settings/{id}', [ClientSettingController::class, 'updateGeneralSettings'])->name('general.settings.update');
    Route::get('api', [ClientSettingController::class, 'api'])->name('settings.api');
    Route::post('api', [ClientSettingController::class, 'update_api'])->name('settings.api.update');
    Route::post('ai_reply/status-update', [ClientSettingController::class, 'AIReplyStatus'])->name('setting.ai-reply.status-update');
    // Billing Routes
    Route::get('billing/details', [ClientSettingController::class, 'billingDetails'])->name('billing.details');
    Route::post('billing/details/store/{id}', [ClientSettingController::class, 'storeBillingDetails'])->name('billing.details.store');
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
    // team route
    Route::get('team-list', [TeamController::class, 'index'])->name('team.index');
    Route::get('team/create', [TeamController::class, 'create'])->name('team.create');
    Route::post('team/store', [TeamController::class, 'store'])->name('team.store');
    Route::get('team/edit/{id}', [TeamController::class, 'edit'])->name('team.edit');
    Route::put('team/update/{id}', [TeamController::class, 'update'])->name('team.update');

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
    Route::delete('stop-recurring/{id}', [SubscriptionController::class, 'stopRecurring'])->name('stop.recurring');
    Route::delete('enable-recurring/{id}', [SubscriptionController::class, 'enableRecurring'])->name('enable.recurring');
    Route::delete('cancel-subscription/{id}', [SubscriptionController::class, 'cancelSubscription'])->name('cancel.subscription');

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
