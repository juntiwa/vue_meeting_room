<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookRoomMedicine\FormBookRoomController;
use App\Models\DepartmentBookRoom;
use Illuminate\Support\Facades\Auth;
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
//Auth::logout();
Route::get('/', function (\Illuminate\Http\Request $request) {
    $message = session('message');
    /*if (!$message){
        return Inertia::render('Dashboard');
    }*/
    $user = $request->user();
    $bookings = DepartmentBookRoom::query()
//        ->where('requester_id',$request->user()->id)
        ->get()
        /*->transform(fn ($booking) => [
            'start_date' => $booking->start_date->format('M j Y - H:i'),
            'end_date' => $booking->end_date->format('M j Y - H:i'),
            'can_cancel' => $request->user()->can('cancel', $booking),
        ]);*/
        ->transform(function ($booking) use ($request) {
            return [
                'start_date' => $booking->start_date->format('M j Y - H:i'),
                'end_date' => $booking->end_date->format('M j Y - H:i'),
//                'can_cancel' => auth()->user()->can('cancel', $booking),
                'can_cancel' => $request->user()->can('cancel', $booking),
                'user_id' => $booking->requester_id,
                'set_room' => $booking->set_room,
                'set_room_text' => $booking->set_room_text,
                'duration_text' => $booking->duration_text,
            ];
        });
    return Inertia::render('Dashboard', [
        'message' => $message,
        'can' => [
            "booked_room_instead_case" => $request->user()->can('booked_room_instead_case'),
            "booked_room_case" => $request->user()->can('booked_room_case'),
        ],
        'bookings' => $bookings
    ]);
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
