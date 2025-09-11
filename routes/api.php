<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LunchController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ApiMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(ApiMiddleware::class)->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::post('/login', [LoginController::class, 'login']);

    Route::post('/register', [LoginController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/get-events', [EventController::class, 'getEventsList']);
        Route::get('/get-event-configuration', [ConfigurationController::class, 'getEventConfiguration']);
        Route::get('/get-event-types', [EventController::class, 'getEventTypes']);

        Route::middleware(AdminMiddleware::class)->group(function () {
            Route::post('/create-day', [DayController::class, 'createDay']);
            Route::patch('/update-day', [DayController::class, 'updateDay']);
            Route::delete('/delete-day', [DayController::class, 'deleteDay']);

            Route::post('/create-lunch', [LunchController::class, 'createLunch']);
            Route::patch('/update-lunch', [LunchController::class, 'updateLunch']);
            Route::delete('/delete-lunch', [LunchController::class, 'deleteLunch']);
        });
    });
});

Route::post('/webhook', [SubscriptionController::class, 'webhook']);
