<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;

Auth::routes();

//OAuth for google
Route::get('login/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'project','as' => 'project.'], function(){
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/store', [ProjectController::class, 'store'])->name('store');
    });
});
