<?php

use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('cron-run', [CronController::class, 'manual_run'])->name('cron.run.manually');
Route::get('cron/{key}', [CronController::class, 'index']);
Route::get('/logs', [LogController::class, 'showLog'])->name('logs.show')->middleware(['auth', 'verified']);
// Telegram
Route::any('env-editor', function () {
    return redirect('/');
})->where('anything', '.*');
Route::any('env-editor/key', function () {
    return redirect('/');
})->where('anything', '.*');
Route::post('subscribe/store', [HomeController::class, 'subscribeStore'])->name('subscribe.store');
Route::group(['prefix' => localeRoutePrefix(), 'middleware' => 'isInstalled'], function () {
    Route::get('/health', function () {
        return response()->json('OK');
    });
    Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('check.landing.page');
    Route::get('language/{lang}', [HomeController::class, 'changeLanguage'])->name('lang');
    Route::get('cache-clear', [HomeController::class, 'cacheClear'])->name('cache.clear');
    Route::get('page/{link}', [HomeController::class, 'page']);

    Route::get('blogs', [HomeController::class, 'blogs'])->name('all.blog');
    Route::get('/filter-blogs', [HomeController::class, 'filterBlogs'])->name('filter.blogs');
    Route::get('blogs/details/{slug}', [HomeController::class, 'blogsDetails'])->name('blog.details');
});
require __DIR__.'/auth.php';
