<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;

Route::middleware('api')->group(function () {
    Route::get('/projects', [CalendarController::class, 'index']);
});




