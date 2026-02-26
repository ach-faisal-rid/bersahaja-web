<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\DoaController;
use App\Http\Controllers\Api\V1\HadistController;
use App\Http\Controllers\Api\V1\TataCaraController;
use App\Http\Controllers\Api\V1\GerakanShalatController;
use App\Http\Controllers\Api\V1\BacaanController;
use App\Http\Controllers\Api\V1\WuduController;
use App\Http\Controllers\Api\V1\HijriEventController;
use App\Http\Controllers\Api\V1\FavoritController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\PinnedDayController;

Route::prefix('v1')->group(function () {
    // Public Authentication Routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

    // Public Read-Only Routes
    Route::get('/doas', [DoaController::class, 'index']);
    Route::get('/doas/{doa}', [DoaController::class, 'show']);
    Route::get('/doas/tags/{tag}', [DoaController::class, 'byTag']);

    Route::get('/hadists', [HadistController::class, 'index']);
    Route::get('/hadists/{hadist}', [HadistController::class, 'show']);

    Route::get('/tata-cara', [TataCaraController::class, 'index']);
    Route::get('/tata-cara/{tataCara}', [TataCaraController::class, 'show']);

    Route::get('/gerakan-shalat', [GerakanShalatController::class, 'index']);
    Route::get('/gerakan-shalat/{gerakanShalat}', [GerakanShalatController::class, 'show']);

    Route::get('/bacaan', [BacaanController::class, 'index']);
    Route::get('/bacaan/{bacaan}', [BacaanController::class, 'show']);

    Route::get('/wudu', [WuduController::class, 'index']);
    Route::get('/wudu/{wudu}', [WuduController::class, 'show']);

    Route::get('/hijri/events', [HijriEventController::class, 'events']);
    Route::get('/hijri/calendar', [HijriEventController::class, 'calendar']);

    // Protected Routes (Requires Authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // Auth Management
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        Route::get('/auth/me', [AuthController::class, 'me']);

        // User Profile
        Route::get('/user/profile', [UserController::class, 'show']);
        Route::put('/user/profile', [UserController::class, 'update']);
        Route::delete('/user/profile', [UserController::class, 'destroy']);

        // Favorit Management
        Route::get('/favorit', [FavoritController::class, 'index']);
        Route::post('/favorit', [FavoritController::class, 'store']);
        Route::delete('/favorit/{favorit}', [FavoritController::class, 'destroy']);

        // Pinned Days (Hijri Calendar)
        Route::get('/hijri/pinned-days', [PinnedDayController::class, 'index']);
        Route::post('/hijri/pinned-days', [PinnedDayController::class, 'store']);
        Route::delete('/hijri/pinned-days/{pinnedDay}', [PinnedDayController::class, 'destroy']);
    });
});
