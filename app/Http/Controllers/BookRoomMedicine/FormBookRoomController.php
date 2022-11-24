<?php

namespace App\Http\Controllers\BookRoomMedicine;

use App\Casts\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\DepartmentBookRoom;
use App\Models\DepartmentPurposeBookRoom;
use App\Models\DepartmentRoom;
use Carbon\Carbon;
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'attendees' => 'required|integer|min:3|max:200',
            'set_room.status' => 'required|boolean'
        ]);
        $attendees = $validated['attendees'];

        if ($validated['set_room']['status'] === true) {
            $start_date = Carbon::create($validated['start_date'])->subMinute(30);
            $roomsThoseMeetAttendeeRequirement = DepartmentRoom::query()
                ->where('minimum_attendees', '<=', $attendees)
                ->where('maximum_attendees', '>=', $attendees)
                ->where('can_set_table', 1)
                ->get();
        } else {
            $start_date = Carbon::create($validated['start_date']);
            $roomsThoseMeetAttendeeRequirement = DepartmentRoom::query()
                ->where('minimum_attendees', '<=', $attendees)
                ->where('maximum_attendees', '>=', $attendees)
                ->get();
        }

        $end_date = Carbon::create($validated['end_date']);

        $unavailableRooms = DepartmentBookRoom::query()
            ->overlap($start_date, $end_date)
            ->whereIn('meeting_room_id', $roomsThoseMeetAttendeeRequirement->pluck('id'))
            ->whereIn('status', (new BookingStatus())->getOccupiedRawStatuses())
            ->get();

        $result = [];
        foreach ($roomsThoseMeetAttendeeRequirement as $room) {
            $tmp = [];
            $tmp['room'] = $room;
            $tmp['id'] = $room->id;
            if ($unavailableRooms->pluck('meeting_room_id')->contains($room->id)) {
                foreach ($unavailableRooms as $unavailable) {
                    if ($unavailable->meeting_room_id == $room->id) {
                        $tmp['available'] = false;
                        $tmp['status'] = $room->name_th . ' ไม่สามารถจองได้ เนื่องจากถูกจองแล้วในช่วง ' . $unavailable->start_date->format('d-m-Y') . ' ถึง ' . $unavailable->end_date->format('d-m-Y');
                    }
                }
            } elseif ($room->status_id == 2) {
                $tmp['available'] = false;
                $tmp['status'] = $room->name_th . ' ไม่สามารถจองได้ เนื่องจากอยูาระหว่างปรับปรุง';
            } else {
                $tmp['available'] = true;
                $tmp['status'] = $room->name_th;
            }
            $result[] = $tmp;
        }

        $col = collect($result);
        $sort = $col->sortBy('available');
        $resultComplete = $sort->values()->all();
        $purposes = DepartmentPurposeBookRoom::query()->get();
        return [
            'start_date' => $start_date,
            'result' => $resultComplete,
            'purposes' => $purposes
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'attendees' => 'required|integer|min:3|max:200',
            'set_room.status' => 'required|boolean',
            'set_room.type_table' => 'required|string', //exits
            'set_room.number_group' => 'required|numeric',
            'set_room.each_group' => 'required|numeric',
            'meeting_room_id' => 'required|exists:department_rooms,id',
            'topic' => 'required',
            'description' => 'nullable',
            'purpose_id' => 'required|exists:department_purpose_book_rooms,id',
            'equipment.computer' => 'nullable|numeric',
            'equipment.lcdprojector' => 'nullable|numeric',
            'equipment.visualizer' => 'nullable|numeric',
            'equipment.sound' => 'nullable|numeric',
            'equipment.other' => 'nullable|string',
            'equipment.notebook' => 'required|boolean',
            'food.status' => 'required|boolean',
            'food.lunch' => 'nullable|numeric',
            'food.snack' => 'nullable|numeric',
            'food.drink' => 'nullable|numeric',
            'food.note' => 'nullable|string',
        ]);

        $validated['requester_id'] = $request->user()->id;
        $validated['unit_level'] = 0;
        $validated['unit_id'] = $request->user()->unit_id;

        DepartmentBookRoom::query()->create($validated);
        return $validated;
    }
}
