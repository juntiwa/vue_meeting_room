<?php

namespace App\Http\Controllers\BookRoomMedicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormBookRoomController extends Controller
{
    public function create()
    {
        return Inertia::render('BookRoomMedicine/FormBookRoom');
    }

    public function checkCondition(Request $request)
    {
        $validated = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
            'attendees' => 'required|integer|min:3|max:200',
            'set_table.status' => 'required|boolean'
        ]);
        $attendees = $validated['attendees'];

        return $validated;
    }
}
