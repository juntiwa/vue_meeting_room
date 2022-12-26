<?php

namespace App\Models;

use App\Casts\BookingStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentBookRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'attendees',
        'set_room',
        'meeting_room_id',
        'topic',
        'description',
        'purpose_id',
        'equipment',
        'food',
        'requester_id',
        'unit_level',
        'unit_id',
        'status',
        'reason',
        'approver_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => BookingStatus::class,
        'equipment' => AsArrayObject::class,
        'set_room' => AsArrayObject::class,
        'food' => AsArrayObject::class,
    ];

    public function scopeOverlap($query, $start, $end)
    {
        logger($start);
        $start = $start->addMinute();
        $query->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start);
    }

    //for table
    public function createAt(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->thaidate('d/m/y'),
        );

    }

    public function dateFormat(): Attribute
    {
        return Attribute::make(
        //  get: fn() => $this->start_date->thaidate('j F Y'),
            get: fn() => $this->start_date->thaidate('d/m/Y'),
        );
    }

    public function time(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->start_date->format('H:i') . ' ถึง ' . $this->end_date->format('H:i'),
        );
    }

    // for modal
    public function users()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitInner::class, 'unit_id', 'id');
    }

    public function userData(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->users,
        );
    }

    public function medicineroom()
    {
        return $this->belongsTo(DepartmentRoom::class, 'meeting_room_id');
    }

    public function purpose()
    {
        return $this->belongsTo(DepartmentPurposeBookRoom::class, 'purpose_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function approverName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->approver?->full_name
        );
    }

    public function setRoomText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $setRoom = $this->set_room;
                if (!$setRoom['status']) {
                    return $setRoom['status'];
                } else {
                    if ($setRoom['type_table'] === 'groups') {
                        return $setRoom['type_table'] . ' จำนวน ' . $setRoom['number_group'] . ' กลุ่ม กลุ่มละ ' . $setRoom['number_group'];
                    }
                    return $setRoom['type_table'];
                }
            }
        );
    }

    public function equipmentText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $equipment = $this->equipment;
                if ($equipment['sound'] === "0" && $equipment['computer'] === "0" && !$equipment['notebook']
                    && $equipment['visualizer'] === "0" && $equipment['lcdprojector'] === "0" && !$equipment['other']) {
                    $data = false;
                } else {
                    $data = null;
                    if ($equipment['sound'] !== "0") {
                        if ($data != null) {
                            $data = $data . ', ';
                        }
                        $data = 'ระบบเสียง ' . $equipment['sound'] . "\n";
                    }
                    if ($equipment['computer'] !== "0") {
                        if ($data != null) {
                            $data = $data . ', ';
                        }
                        $data = $data . 'คอมพิวเตอร์ ' . $equipment['computer'] . "\n";
                    }
                    if ($equipment['notebook']) {
                        if ($data != null) {
                            $data = $data . ', ';
                        }
                        $data = $data . 'นำ notebook มาเอง' . "\n";
                    }
                    if ($equipment['visualizer'] !== "0") {
                        if ($data != null) {
                            $data = $data . ', ';
                        }
                        $data = $data . 'visualizer ' . $equipment['visualizer'] . "\n";
                    }
                    if ($equipment['lcdprojector'] !== "0") {
                        if ($data != null) {
                            $data = $data . ', ';
                        }
                        $data = $data . 'projector ' . $equipment['lcdprojector'] . "\n";
                    }
                    if ($equipment['other'] !== null) {
                        if ($data != null) {
                            $data = $data . ', ';
                        }
                        $data = $data . 'อื่น ๆ ' . $equipment['other'] . "\n";
                    }

                }
                return $data;
            }
        );
    }

    public function foodText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $food = $this->food;
                if (!$food['status']) {
                    return $food['status'];
                } else {
                    $data = null;
                    if ($food['lunch'] !== "0") {
                        if ($data != null) {
                            $data = $data . ', ';
                        }
                        $data = 'อาหารกลางวัน ' . $food['lunch'] . "\n";
                    }
                    if ($food['snack'] !== "0") {
                        if ($data != null) {
                            $data = $data . ', ';
                        }
                        $data = $data . 'อาหารว่าง ' . $food['snack'] . "\n";
                    }
                    if ($food['drink'] !== "0") {
                        if ($data != null) {
                            $data = $data . ', ';
                        }
                        $data = $data . 'เครื่องดื่ม ' . $food['drink'] . "\n";
                    }
                    if ($food['note'] !== null) {
                        if ($data != null) {
                            $data = $data . ', ';
                        }
                        $data = $data . 'หมายเหตุ : ' . $food['note'] . "\n";
                    }
                    return $data;
                }
            }
        );
    }

    public function statusLocale(): Attribute
    {
        return Attribute::make(
            get: fn() => (new BookingStatus)->getStatusLocale($this->attributes['status']),
        );
    }

    public function occupiedRawStatuses(): Attribute
    {
        return Attribute::make(
            get: fn() => collect(['booked', 'corrected']),
        );
    }

    public function occupiedRawStatusesCancel(): Attribute
    {
        return Attribute::make(
            get: fn() => collect(['booked', 'corrected', 'approved']),
        );
    }

    public function occupiedRawStatusesEdit(): Attribute
    {
        return Attribute::make(
            get: fn() => collect(['booked', 'approved', 'corrected']),
        );
    }

    public function statusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $status = (new BookingStatus)->getStatusLocale($this->attributes['status']);
                if ($status === 'รออนุมัติ') {
                    return '';
                } else {
                    $data = ' โดย ' . $this->approverName;
                    if ($this->reason !== null) {
                        $data = $data . ' เพราะ ' . $this->reason;
                    }
                    return $data;
                }
            },
        );
    }

    public function descriptionText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $description = $this->description;
                if (!$description) {
                    return ' ';
                }

                return '<br/>  รายละเอียดการประชุม : ' . $description;
            }
        );
    }

    public function dataPopup(): Attribute
    {
        return Attribute::make(
            get: function () {
                $data = '<h1 class="text-3xl font-medium"> ข้อมูลเพิ่มเติม </h1>'
                    . '<div class="text-right"> บันทึกข้อมูลเมื่อ ' . $this->created_at->thaidate('j F Y')
                    . '<br/><br/> โดย ' . $this->users->full_name
                    . '<br/>' . $this->users->unit->name_th
                    . '<br/> ติดต่อโทร ' . $this->users->tel
                    . '</div>'
                    . '<div class="text-left p-3 line-height"> <div class="flex gap-2">';

                if ($this->status_locale === 'รออนุมัติ') {
                    $data = $data . ' <p class="text-amber-500"> ' . $this->status_locale . '</p>';
                }
                if ($this->status_locale === 'อนุมัติ') {
                    $data = $data . ' <p class="text-teal-600"> ' . $this->status_locale . '</p>' . $this->status_text;
                }
                if ($this->status_locale === 'ถูกแก้ไข') {
                    $data = $data . ' <p class="text-violet-600"> ' . $this->status_locale . '</p>' . $this->status_text;
                }
                if ($this->status_locale === 'ถูกยกเลิก') {
                    $data = $data . ' <p class="text-rose-600"> ' . $this->status_locale . '</p>' . $this->status_text;
                }

                $data = $data . '</div> <br/> หัวข้อการประชุม : ' . $this->topic
                    . '<br/> วันเดือนปี : ' . $this->start_date->thaidate('วันl ที่ j F Y') . ' เวลา ' . $this->start_date->format('H:i น.') . ' ถึง ' . $this->end_date->format('H:i น.')
                    . '<br/> ห้องประชุม : ' . $this->medicineroom->name_th . ' ผู้เข้าร่วมจำนวน : ' . $this->attendees . ' คน '
                    . $this->description_text
                    . '<br/> วัตถุประสงค์การใช้งาน : ' . $this->purpose->name_th . '</div>'
                    . '<div class="text-left p-3 line-height"> ';

                if ($this->set_room_text || $this->equipment_text || $this->food_text) {
                    $data = $data . ' อื่น ๆ ';
                }

                if ($this->set_room_text) {
                    $data = $data . '<br/> จัดห้องแบบ : ' . $this->set_room_text;
                }

                if ($this->equipment_text) {
                    $data = $data . '<br/> อุปกรณ์ : ' . $this->equipment_text;
                }

                if ($this->food_text) {
                    $data = $data . '<br/> อาหาร, เครื่องดื่ม : ' . $this->food_text ;
                }
                $data = $data . '</div>';
                return $data;
            }
        );
    }

}
