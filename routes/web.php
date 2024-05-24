<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->name('user.')->group(function(){
    Route::middleware(['guest:web'])->group(function () {
        Route::view('/register','dashboard.user.register')->name('register');
        Route::view('/login','dashboard.user.login')->name('login');
        Route::post('/create',[UserController::class,'create'])->name('create');
        Route::post('/dologin',[UserController::class,'dologin'])->name('dologin');
    });
    Route::middleware(['auth:web'])->group(function(){
        Route::view('/home','dashboard.user.home')->name('home');
        Route::post('/logout',[UserController::class,'logout'])->name('logout');

    });
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware(['guest:admin'])->group(function () {
        Route::view('/login','dashboard.admin.login')->name('login');
        Route::post('/dologin',[AdminController::class,'dologin'])->name('dologin');
    });
    Route::middleware(['auth:admin'])->group(function(){
        Route::view('/home','dashboard.admin.home')->name('home');
        Route::post('/logout',[AdminController::class,'logout'])->name('logout');

    });
});
