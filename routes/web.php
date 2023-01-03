<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookedRoomMedicine\FormBookedRoomController;
use App\Http\Controllers\BookedRoomMedicine\FormBookedRoomInsteadController;
use App\Http\Controllers\BookedRoomMedicine\ListBookedRoomController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

//Auth::logout();

Route::controller(DashboardController::class)->middleware(['auth'])->group(function(){
    Route::get('/','index')->name('dashboard');
});

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'create')->name('login')->middleware(['guest']);
    Route::post('/login', 'store')->name('loginStore')->middleware(['guest']);
    Route::delete('/login', 'destroy')->name('loginDestroy')->middleware(['auth']);
});

Route::controller(RegisterController::class)->middleware(['guest'])->group(function(){
    Route::get('/register', 'create')->name('register');
    Route::post('/register', 'store')->name('registerStore');
});

Route::controller(FormBookedRoomController::class)->middleware(['auth'])->group(function(){
    Route::get('/formBookRoom','create')->name('formBookedRoom');
    Route::post('/checkCondition','checkCondition')->name('formBookedRoomCheckCondition');
    Route::post('/formBookRoom','store')->name('formBookedRoomStore');
    Route::put('/formBookRoom','update')->name('formBookedRoomUpdate');
});

Route::controller(FormBookedRoomInsteadController::class)->middleware(['auth'])->group(function(){
   Route::get('/formBookRoomInstead', 'create')->name('formBookRoomInstead');
    Route::post('/checkConditionInstead','checkCondition')->name('formBookRoomInsteadCheckCondition');
    Route::post('/formBookRoomInstead','store')->name('formBookRoomInsteadStore');
});

Route::controller(ListBookedRoomController::class)->middleware(['auth'])->group(function(){
   Route::get('/listBookedRoom', 'index')->name('listBooked');
});
