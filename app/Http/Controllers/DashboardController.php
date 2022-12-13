<?php

namespace App\Http\Controllers;

use App\Models\DepartmentBookRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $message = session('message');
        /*if (!$message){
            return Inertia::render('Dashboard');
        }*/
        $user = request()->user();
        $bookings = DepartmentBookRoom::query()
//        ->where('requester_id',$request->user()->id)
            ->get()
            ->transform(function ($booking) use ($request) {
                return [
                    'start_date' => $booking->start_date->format('M j Y - H:i'),
                    'end_date' => $booking->end_date->format('M j Y - H:i'),
//                'can_cancel' => auth()->user()->can('cancel', $booking),
                    'can_cancel' => $request->user()->can('cancel', $booking),
                    'user_id' => $booking->requester_id,
                    'set_room' => $booking->set_room,
                    'set_room_text' => $booking->set_room_text,
                    'medicineroom_text' => $booking->medicineroom_text,
                    'duration_text' => $booking->duration_text,
                    'attendee_text' => $booking->attendee_text,
                    'topic_text' => $booking->topic_text,
                    'description_text' => $booking->description_text,
                    'purpose_text' => $booking->purpose_text,
                    'equipment_text' => $booking->equipment_text,
                    'food_text' => $booking->food_text,
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
    }
}
