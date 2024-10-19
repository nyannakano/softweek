<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);

    Route::get('/payment-success', [SubscriptionController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment-failure', [SubscriptionController::class, 'paymentFailure'])->name('payment.failure');
    Route::get('/payment-pending', [SubscriptionController::class, 'paymentPending'])->name('payment.pending');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/admin', [PageController::class, 'admin'])->name('admin');
        Route::get('/admin/subscriptions', [SubscriptionController::class, 'getSubscriptionsAsAdmin'])->name('admin.subscriptions');
        Route::post('admin/confirm-payment/{id}', [SubscriptionController::class, 'confirmPayment'])->name('admin.confirm-payment');
        Route::get('/admin/coupons', [CouponController::class, 'getCouponsAsAdmin'])->name('admin.coupons');
        Route::get('/admin/register-coupon', [CouponController::class, 'registerCoupon'])->name('admin.register-coupon');
        Route::get('/admin/workshops', [PageController::class, 'workshops'])->name('admin.workshops');

        Route::get('/admin/get-subscriptions/{id}', [SubscriptionController::class, 'getSubscriptionsByEventId'])->name('admin.get-subscriptions');

        Route::get('/admin/create-workshop', [EventController::class, 'createWorkshop'])->name('admin.register-workshop');
        Route::post('/create-event', [EventController::class, 'createEvent'])->name('create-workshop');
        Route::patch('/update-event', [EventController::class, 'updateEvent'])->name('update-workshop');
        Route::delete('/delete-event', [EventController::class, 'deleteEvent'])->name('delete-workshop');

        Route::post('/create-coupon', [CouponController::class, 'createCoupon'])->name('create-coupon');
    });
});

Route::post('/webhook', [SubscriptionController::class, 'webhook']);

require __DIR__.'/auth.php';
