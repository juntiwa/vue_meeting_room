<?php

namespace App\Http\Controllers;

use App\Casts\BookingStatus;
use App\Models\DepartmentBookRoom;
use App\Models\DepartmentRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Phattarachai\LineNotify\Facade\Line;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $message = session('message');

        $bookings = DepartmentBookRoom::query()
            // ->where('requester_id',$request->user()->id)
            ->whereIn('status', [1, 3])
            ->orderBy('created_at', 'desc')
            ->get()
            ->transform(function ($booking) use ($request) {
                return [
                    //for table
                    'can_cancel' => $request->user()->can('cancel', $booking),
                    'can_edit' => $request->user()->can('edit', $booking),
                    'can_approved' => $request->user()->can('approved', $booking),
                    'can_disapproved' => $request->user()->can('disapproved', $booking),
                    'can_canceled' => $request->user()->can('canceled', $booking),

                    'meeting_room_id' => $booking->meeting_room_id,
                    'create_at' => $booking->create_at,
                    'data_all' => $booking,
                    'date_format' => $booking->date_format,
                    'time' => $booking->time,
                    'unit_name' => $booking->unit_text,
                    'equipment_text' => $booking->equipment_text,
                    'food_text' => $booking->food_text,
                    'set_room_text' => $booking->set_room_text,
                    'status_locale' => $booking->status_locale,
                    'status_text' => $booking->status_text,

                    //for popup
                    'data_popup' => $booking->data_popup,

                ];
            });

        $rooms = DepartmentRoom::query()
            ->whereIn('id', $bookings->pluck('meeting_room_id'))
            ->get()
            ->transform(function ($room) use ($request) {
                return [
                    'room_id' => $room->room_id,
                    'room_name' => $room->room_name,
                    'can_view_list_booked_room' => $request->user()->can('viewListBookedRoom', $room),
                ];
            });

        /**
         * แจ้งเตือนเมื่อ อีก 2 วัน ถึงวันทีใช้งาน
         * วันที่จองยังไม่ผ่านไป
         * สถานะ ได้แก่ ยังไม่อนุมัติ หรือ ถูกแก้ไข
         */
        $bookingsSendNotifies = DepartmentBookRoom::query()
            ->where('start_date', '>', Carbon::now()->format('Y-m-d H:m'))
            ->where('start_date', '<', Carbon::now()->addWeekdays(3)->format('Y-m-d H:m'))
            ->whereIn('status', (new BookingStatus())->getNotifyRawStatuses())
            ->count();

//        return $bookingsSendNotifies;
        if ($bookingsSendNotifies !== 0){
//            Line::send('มีข้อมูลจำนวน ' . $bookingsSendNotifies . ' รายการ รออนุมัติ');
        }

        return Inertia::render('Dashboard', [
            'message' => $message,
            'bookings' => $bookings,
            'rooms' => $rooms
        ]);
    }
}
