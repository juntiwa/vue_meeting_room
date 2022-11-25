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
                ->where('can_set_table', 1) //เฉพาะห้องที่สามารถเปลี่ยนแปลงรูปแบบโต๊ะได้เท่านั้น
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

        //query เพิ่มเติมกรณีห้องประชุมรวม ไม่สามารถจองได้
        $meetingRooms = DepartmentRoom::query()->get();
        $unavailableSharedRooms = DepartmentBookRoom::query()
            ->overlap($start_date, $end_date)
            ->whereIn('meeting_room_id', $meetingRooms->pluck('id'))
            ->whereIn('status', (new BookingStatus())->getOccupiedRawStatuses())
            ->get();

        $result = [];
        foreach ($roomsThoseMeetAttendeeRequirement as $room) {
            $tmp = [];
            $tmp['room'] = $room;
            $tmp['id'] = $room->id;
            if ($unavailableRooms->pluck('meeting_room_id')->contains($room->id)) {
                //มีการของห้องในตาราง department_book_rooms แล้วทำให้จองไม่ได้
                foreach ($unavailableRooms as $unavailable) {
                    if ($unavailable->meeting_room_id == $room->id) {
                        $tmp['available'] = false;
                        $tmp['status'] = $room->name_th . ' ไม่สามารถจองได้ เนื่องจากถูกจองแล้วในช่วง ' . $unavailable->start_date->format('d-m-Y H:i:s') . ' ถึง ' . $unavailable->end_date->format('d-m-Y H:i:s');
                    }
                }
            } elseif ($room->status_id == 2) {
                //สถานะห้องอยู่ระหว่างปรับปรุง ทำให้จองไม่ได้
                $tmp['available'] = false;
                $tmp['status'] = $room->name_th . ' ไม่สามารถจองได้ เนื่องจากอยู่ระหว่างปรับปรุง';
            } else {
                $tmp['available'] = true;
                $tmp['status'] = $room->name_th;

                /*
                 * เอาไว้ตรงนี้เพราะ เป็นห้องที่สามารถจองได้ตามเงื่อนไขจากด้านบนทั้งหมด แต่ไม่สามารถจองได้เพราะ เป็นห้องรวมที่มีการใช้งานห้องอื่น ๆ
                 * และเอาไว้ด้านล่าง $tmp['available'] = true; เพราะถ้าเอาไว้ด้านบน $tmp['available'] จะถูก set เป็น true ทั้งหมด
                 */
                foreach ($unavailableSharedRooms as $unavailableShared) {
                    if ($unavailableShared->meeting_room_id == 10) {
                        if ($room->id == 14 || $room->id == 15) {
                            $tmp['available'] = false;
                            $tmp['status'] = $room->name_th . ' ไม่สามารถจองได้ เนื่องจากห้องประพาฬ ยงใจยุทธ ถูกจองแล้วช่วง ' . $unavailableShared->start_date->format('d-m-Y H:i:s') . ' ถึง ' . $unavailableShared->end_date->format('d-m-Y H:i:s');
                        }
                    }
                    if ($unavailableShared->meeting_room_id == 11) {
                        if ($room->id == 13 || $room->id == 14) {
                            $tmp['available'] = false;
                            $tmp['status'] = $room->name_th . ' ไม่สามารถจองได้ เนื่องจากห้องศฤงคไพบูลย์ 1 ถูกจองแล้วช่วง ' . $unavailableShared->start_date->format('d-m-Y H:i:s') . ' ถึง ' . $unavailableShared->end_date->format('d-m-Y H:i:s');
                        }
                    }
                    if ($unavailableShared->meeting_room_id == 12) {
                        if ($room->id == 13 || $room->id == 14 || $room->id == 15) {
                            $tmp['available'] = false;
                            $tmp['status'] = $room->name_th . ' ไม่สามารถจองได้ เนื่องจากห้องศฤงคไพบูลย์ 2 ถูกจองแล้วช่วง ' . $unavailableShared->start_date->format('d-m-Y H:i:s') . ' ถึง ' . $unavailableShared->end_date->format('d-m-Y H:i:s');
                        }
                    }
                    if ($unavailableShared->meeting_room_id == 13) {
                        if ($room->id == 11 || $room->id == 12 || $room->id == 14 || $room->id == 15) {
                            $tmp['available'] = false;
                            $tmp['status'] = $room->name_th . ' ไม่สามารถจองได้ เนื่องจากห้องศฤงคไพบูลย์ 1 และ 2 ถูกจองแล้วช่วง ' . $unavailableShared->start_date->format('d-m-Y H:i:s') . ' ถึง ' . $unavailableShared->end_date->format('d-m-Y H:i:s');
                        }
                    }
                    if ($unavailableShared->meeting_room_id == 14) {
                        if ($room->id == 10 || $room->id == 11 || $room->id == 12 || $room->id == 13 || $room->id == 15) {
                            $tmp['available'] = false;
                            $tmp['status'] = $room->name_th . ' ไม่สามารถจองได้ เนื่องจากห้องศฤงคไพบูลย์ 1 ศฤงคไพบูลย์ 2 และ ประพาฬ ยงใจยุทธ ถูกจองแล้วช่วง ' . $unavailableShared->start_date->format('d-m-Y H:i:s') . ' ถึง ' . $unavailableShared->end_date->format('d-m-Y H:i:s');
                        }
                    }
                    if ($unavailableShared->meeting_room_id == 15) {
                        if ($room->id == 10 || $room->id == 12 || $room->id == 13 || $room->id == 14) {
                            $tmp['available'] = false;
                            $tmp['status'] = $room->name_th . ' ไม่สามารถจองได้ เนื่องจากห้องศฤงคไพบูลย์ 2 และ ประพาฬ ยงใจยุทธ ถูกจองแล้วช่วง ' . $unavailableShared->start_date->format('d-m-Y H:i:s') . ' ถึง ' . $unavailableShared->end_date->format('d-m-Y H:i:s');
                        }
                    }
                }
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
            'set_room.type_table' => 'nullable|string', //exits
            'set_room.number_group' => 'nullable|numeric',
            'set_room.each_group' => 'nullable|numeric',
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
