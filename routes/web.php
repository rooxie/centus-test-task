<?php

use Illuminate\Support\Facades\Route;

Route::post('/push-subscription', \App\Http\Controllers\PushSubscriptionController::class)
    ->middleware(['auth']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');
});
