<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\LunchController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::post('/create-day', [DayController::class, 'createDay']);
        Route::patch('/update-day', [DayController::class, 'updateDay']);
        Route::delete('/delete-day', [DayController::class, 'deleteDay']);

        Route::post('/create-lunch', [LunchController::class, 'createLunch']);
        Route::patch('/update-lunch', [LunchController::class, 'updateLunch']);
        Route::delete('/delete-lunch', [LunchController::class, 'deleteLunch']);
    });
});
