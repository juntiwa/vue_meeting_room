<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookedRoomMedicine\FormBookedRoomController;
use App\Http\Controllers\BookedRoomMedicine\FormBookedRoomInsteadController;
use App\Http\Controllers\DashboardController;
use App\Models\DepartmentBookRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use function Termwind\render;

Route::controller(DashboardController::class)->group(function(){
    Route::get('/','index')->name('dashboard');
})->middleware(['auth']);

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'create')->name('login')->middleware(['guest']);
    Route::post('/login', 'store')->name('loginStore')->middleware(['guest']);
    Route::delete('/login', 'destroy')->name('loginDestroy')->middleware(['auth']);
});

Route::controller(RegisterController::class)->group(function(){
    Route::get('/register', 'create')->name('register');
    Route::post('/register', 'store')->name('registerStore');
})->middleware(['guest']);

Route::controller(FormBookedRoomController::class)->group(function(){
    Route::get('/formBookRoom','create')->name('formBookedRoom');
    Route::post('/checkCondition','checkCondition')->name('formBookedRoomCheckCondition');
    Route::post('/formBookRoom','store')->name('formBookedRoomStore');
})->middleware(['auth']);

Route::controller(FormBookedRoomInsteadController::class)->group(function(){
   Route::get('/formBookRoomInstead', 'create')->name('formBookRoomInstead');
})->middleware(['auth']);
