<?php

namespace App\Http\Controllers\BookedRoomMedicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormBookedRoomInsteadController extends Controller
{
    public function create()
    {
        return Inertia::render('BookedRoomMedicine/FormBookedRoomInstead');
    }
}
