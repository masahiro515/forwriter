<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\WorkTypeController;
use App\Http\Controllers\WorkSessionController;

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
        Route::get('/{id}/show', [ProjectController::class, 'show'])->name('show');
        Route::patch('/{id}/status', [ProjectController::class, 'updateStatus'])->name('updateStatus');
        Route::patch('/{id}/pay-date', [ProjectController::class, 'updatePayDate'])->name('updatePayDate');
        Route::patch('/{id}/salary', [ProjectController::class, 'updateSalary'])->name('updateSalary');
        Route::patch('/{id}/total-characters', [ProjectController::class, 'updateTotalCharacters'])->name('updateTotalCharacters');
        Route::get('/{id}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [ProjectController::class, 'destroy'])->name('delete');
        Route::get('/indexTable', [ProjectController::class, 'indexTable'])->name('indexTable');

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

    // Pickup
    Route::group(['prefix' => 'pickup','as' => 'pickup.'], function(){
        Route::post('/{id}/store', [PickupController::class, 'store'])->name('store');
        Route::delete('/{id}/delete', [PickupController::class, 'destroy'])->name('delete');
    });

    // Work type
    Route::group(['prefix' => 'workType','as' => 'workType.'], function(){
        Route::get('/create', [WorkTypeController::class, 'create'])->name('create');
        Route::post('/store', [WorkTypeController::class, 'store'])->name('store');
        Route::patch('/{id}/update', [WorkTypeController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [WorkTypeController::class, 'destroy'])->name('delete');
    });

    // Work Session
    Route::group(['prefix' => 'WorkSession','as' => 'WorkSession.'], function(){
        Route::post('/store', [WorkSessionController::class, 'store'])->name('store');
    });
});
