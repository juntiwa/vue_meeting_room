<?php

namespace App\Http\Controllers;

use App\Models\DepartmentBookRoom;
use App\Models\DepartmentRoom;
use Carbon\Carbon;
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
        $rooms = DepartmentRoom::query()->get();
        $bookings = DepartmentBookRoom::query()
//        ->where('requester_id',$request->user()->id)
            ->get()
            ->transform(function ($booking) use ($request) {
                return [
                    'creat_at' => $booking->creat_at,
//                'can_cancel' => auth()->user()->can('cancel', $booking),
                    'can_cancel' => $request->user()->can('cancel', $booking),
                    'user_id' => $booking->requester_id,
                    'set_room' => $booking->set_room,
                    'set_room_text' => $booking->set_room_text,
                    'medicineroom_text' => $booking->medicineroom_text,
                    'meeting_room_id' => $booking->meeting_room_id,
                    'duration_text' => $booking->duration_text,
                    'attendee_text' => $booking->attendee_text,
                    'topic_text' => $booking->topic_text,
                    'description_text' => $booking->description_text,
                    'status_locale' => $booking->status_locale,
                    'purpose_text' => $booking->purpose_text,
                    'equipment_text' => $booking->equipment_text,
                    'food_text' => $booking->food_text,
                    'user_full_name' => $booking->user_data->full_name,
                    'user_tel' => $booking->user_data->tel,
                    'unit_name' => $booking->user_data->unit->name_th,
                ];
            });
        return Inertia::render('Dashboard', [
            'message' => $message,
            'can' => [
                "booked_room_instead_case" => $request->user()->can('booked_room_instead_case'),
                "booked_room_case" => $request->user()->can('booked_room_case'),
            ],
            'bookings' => $bookings,
            'rooms' => $rooms
        ]);
    }
}
