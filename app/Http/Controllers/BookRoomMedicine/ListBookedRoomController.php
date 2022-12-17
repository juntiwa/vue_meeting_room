<?php

namespace App\Http\Controllers\BookRoomMedicine;

use App\Http\Controllers\Controller;
use App\Models\DepartmentBookRoom;
use App\Models\DepartmentRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListBookedRoomController extends Controller
{
    public function index(request $request)
    {
        $bookings = DepartmentBookRoom::query()
//        ->where('requester_id',$request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->transform(function ($booking) use ($request) {
                return [
                    'update_at' => $booking->update_at,
//                'can_cancel' => auth()->user()->can('cancel', $booking),
                    'can_cancel' => $request->user()->can('cancel', $booking),
                    'user_id' => $booking->requester_id,
                    'set_room' => $booking->set_room,
                    'set_room_text' => $booking->set_room_text,
                    'medicineroom_text' => $booking->medicineroom_text,
                    'meeting_room_id' => $booking->meeting_room_id,
                    'date_booked_text' => $booking->date_booked_text,
                    'time_booked_text' => $booking->time_booked_text,
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

        $rooms = DepartmentRoom::query()
            ->whereIn('id', $bookings->pluck('meeting_room_id'))
            ->get();
        return Inertia::render('BookedRoomMedicine/ListBookedRoom', [
            'can' => [
                "booked_room_instead_case" => $request->user()->can('booked_room_instead_case'),
                "booked_room_case" => $request->user()->can('booked_room_case'),
            ],
            'bookings' => $bookings,
            'rooms' => $rooms
        ]);
    }
}
