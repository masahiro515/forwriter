<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\GoogleCalendarSyncController; // ← 追加

Route::middleware('api')->group(function () {
    Route::get('/projects', [CalendarController::class, 'index']);

    // Route::middleware('auth:sanctum')->group(function () {

    // });
});

// Route::middleware(['auth:sanctum'])->post('/sync-google-calendar', [GoogleCalendarSyncController::class, 'sync']);




