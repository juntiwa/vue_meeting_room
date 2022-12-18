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

        $bookings = DepartmentBookRoom::query()
//        ->where('requester_id',$request->user()->id)
            ->where('status',1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->transform(function ($booking) use ($request) {
                return [
                    //for table
                    'create_at' => $booking->create_at,
                    'data_all' => $booking,
                    'date' => $booking->date,
                    'time' => $booking->time,
                    'unit_name' => $booking->user_data->unit->name_th,

                    //for popup
                    'can_cancel' => $request->user()->can('cancel', $booking),
                    'create_at_text' => $booking->create_at_text,
                    'datetime_booked_text' => $booking->datetime_booked_text,
                    'medicineroom_text' => $booking->medicineroom_text,
                    'attendee_text' => $booking->attendee_text,
                    'set_room_text' => $booking->set_room_text,
                    'topic_text' => $booking->topic_text,
                    'description_text' => $booking->description_text,
                    'purpose_text' => $booking->purpose_text,
                    'requester_text' => $booking->requester_text,

                    //for secound
                    'equipment_text' => $booking->equipment_text,
                    'food_text' => $booking->food_text,

                    //for popup
                    'user_id' => $booking->requester_id,
                    'set_room' => $booking->set_room,
                    'meeting_room_id' => $booking->meeting_room_id,
                    'status_locale' => $booking->status_locale,

                    'user_full_name' => $booking->user_data->full_name,
                    'user_tel' => $booking->user_data->tel,

                ];
            });

        $rooms = DepartmentRoom::query()
            ->whereIn('id', $bookings->pluck('meeting_room_id'))
            ->get();
        return Inertia::render('Dashboard', [
            'message' => $message,
            'bookings' => $bookings,
            'rooms' => $rooms
        ]);
    }
}
