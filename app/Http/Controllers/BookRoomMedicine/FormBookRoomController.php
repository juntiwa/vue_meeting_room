<?php

namespace App\Http\Controllers\BookRoomMedicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormBookRoomController extends Controller
{
    public function index()
    {
        return Inertia::render('BookRoomMedicine/FormBookRoom');
    }
}
