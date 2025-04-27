<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;

Auth::routes();

//OAuth for google
Route::get('login/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');

    //Project
    Route::group(['prefix' => 'project','as' => 'project.'], function(){
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/store', [ProjectController::class, 'store'])->name('store');
    });

    // Category
    Route::group(['prefix' => 'category','as' => 'category.'], function(){
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::patch('/{id}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [CategoryController::class, 'destroy'])->name('delete');
    });

    // Client
    Route::group(['prefix' => 'client','as' => 'client.'], function(){
        Route::get('/create', [ClientController::class, 'create'])->name('create');
        Route::post('/store', [ClientController::class, 'store'])->name('store');
        Route::patch('/{id}/update', [ClientController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [ClientController::class, 'destroy'])->name('delete');
    });
});
