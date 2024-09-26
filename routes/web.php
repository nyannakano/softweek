<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PageController::class, 'index']);

Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);

    Route::get('/payment-success', [SubscriptionController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment-failure', [SubscriptionController::class, 'paymentFailure'])->name('payment.failure');
    Route::get('/payment-pending', [SubscriptionController::class, 'paymentPending'])->name('payment.pending');
});

Route::post('/webhook', [SubscriptionController::class, 'webhook']);

require __DIR__.'/auth.php';
