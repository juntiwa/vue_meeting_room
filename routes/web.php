<?php

use Illuminate\Support\Facades\Route;

//Auth::logout();

Route::controller(\App\Http\Controllers\DashboardController::class)->middleware(['auth'])->group(function () {
    Route::get('/', 'index')->name('dashboard');
});

Route::controller(\App\Http\Controllers\Auth\LoginController::class)->group(function () {
    Route::get('/login', 'create')->name('login')->middleware(['guest']);
    Route::post('/login', 'store')->name('loginStore')->middleware(['guest']);
    Route::delete('/login', 'destroy')->name('loginDestroy')->middleware(['auth']);
});

Route::controller(\App\Http\Controllers\Auth\RegisterController::class)->middleware(['guest'])->group(function () {
    Route::get('/register', 'create')->name('register');
    Route::post('/register', 'store')->name('registerStore');
});

Route::controller(\App\Http\Controllers\BookedRoomMedicine\FormBookedRoomController::class)->middleware(['auth'])->group(function () {
    Route::get('/formBookRoom', 'create')->name('formBookedRoom');
    Route::post('/checkCondition', 'checkCondition')->name('formBookedRoomCheckCondition');
    Route::post('/formBookRoom', 'store')->name('formBookedRoomStore');
    Route::put('/formBookRoom', 'update')->name('formBookedRoomUpdate');
});

Route::controller(\App\Http\Controllers\BookedRoomMedicine\FormBookedRoomInsteadController::class)->middleware(['auth'])->group(function () {
    Route::get('/formBookRoomInstead', 'create')->name('formBookRoomInstead');
    Route::post('/checkConditionInstead', 'checkCondition')->name('formBookRoomInsteadCheckCondition');
    Route::post('/formBookRoomInstead', 'store')->name('formBookRoomInsteadStore');
});

Route::controller(\App\Http\Controllers\BookedRoomMedicine\ListBookedRoomController::class)->middleware(['auth'])->group(function () {
    Route::get('/listBookedRoom', 'index')->name('listBooked');
});

Route::controller(\App\Http\Controllers\RequestEquipment\RequestEquipmentController::class)->middleware(['auth'])->group(function () {
    Route::get('/listRequestEquipment', 'index')->name('listRequestEquipment');
    Route::get('/formRequestEquipment', 'create')->name('formRequestEquipment');
    Route::post('/formRequestEquipment', 'store')->name('formRequestEquipmentStore');
});
