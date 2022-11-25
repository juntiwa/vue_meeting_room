<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookRoomMedicine\FormBookRoomController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use function Termwind\render;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   //  return view('welcome');
   return Inertia::render('Dashboard');
})->name('dashboard')->middleware(['auth']);

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'create')->name('login')->middleware(['guest']);
    Route::post('/login', 'store')->name('loginStore')->middleware(['guest']);
    Route::delete('/login', 'destroy')->name('loginDestroy')->middleware(['auth']);
});

Route::controller(RegisterController::class)->group(function(){
    Route::get('/register', 'create')->name('register')->middleware(['guest']);
    Route::post('/register', 'store')->name('registerStore')->middleware(['guest']);
});

Route::controller(FormBookRoomController::class)->group(function(){
    Route::get('/formBookRoom','create')->name('formBookRoom')->middleware(['auth']);
    Route::post('/checkCondition','checkCondition')->name('formBookRoomCheckCondition')->middleware(['auth']);
    Route::post('/formBookRoom','store')->name('formBookRoomStore')->middleware(['auth']);
});
