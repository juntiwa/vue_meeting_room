<?php

namespace App\Http\Controllers\BookRoomMedicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListBookedRoomController extends Controller
{
    public function index()
    {
        return Inertia::render('BookedRoomMedicine/ListBookedRoom');
    }
}
