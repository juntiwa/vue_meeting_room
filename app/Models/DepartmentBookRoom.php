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
        $start = $start->addMinute();
        $query->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start);
    }

    //for table
    public function createAt(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->thaidate('j F Y'),
        );

    }

    public function date(): Attribute{
        return Attribute::make(
            get: fn() => $this->start_date->thaidate('j F Y'),
        );
    }

    public function time(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->start_date->format('H:i') . ' ถึง ' . $this->end_date->format('H:i'),
        );
    }

    // for modal
    public function createAtText(): Attribute
    {
        return Attribute::make(
            get: fn() => 'บันทึกข้อมูลเมื่อ : ' . $this->created_at->thaidate('j F Y'),
        );

    }

    public function datetimeBookedText(): Attribute
    {
        return Attribute::make(
            get: fn() => 'วันเดือนปีที่จอง : ' . $this->start_date->thaidate('j F Y') . ' เวลา ' . $this->start_date->format('H:i น.') . ' ถึง ' . $this->end_date->format('H:i น.'),
        );
    }

    public function medicineroom()
    {
        return $this->belongsTo(DepartmentRoom::class, 'meeting_room_id');
    }

    public function medicineroomText(): Attribute
    {
        return Attribute::make(
            get: fn() => 'ห้องประชุม : ' . $this->medicineroom->name_th,
        );
    }

    public function attendeeText(): Attribute
    {
        return Attribute::make(
            get: fn() => ' ผู้เข้าร่วมจำนวน : ' . $this->attendees . ' คน',
        );
    }

    public function topicText(): Attribute
    {
        return Attribute::make(
            get: fn() => 'หัวข้อการประชุม : ' . $this->topic,

        );
    }

    public function descriptionText(): Attribute
    {
        return Attribute::make(
            get: fn() => 'รายละเอียดการประชุม : ' . $this->description,

        );
    }

    public function purpose()
    {
        return $this->belongsTo(DepartmentPurposeBookRoom::class, 'purpose_id');
    }

    public function purposeText(): Attribute
    {
        return Attribute::make(
            get: fn() => 'วัตถุประสงค์การใช้งาน : ' . $this->purpose->name_th,
        );
    }

    public function setRoomText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $setRoom = $this->set_room;
                if (!$setRoom['status']) {
                    return 'ไม่ต้องจัดห้อง';
                }

                return ' จัดห้องแบบ : ' . $setRoom['type_table'];
            }
        );
    }

    public function equipmentText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $equipment = $this->equipment;
                if ($equipment['computer'] === 0) {
                    return 'ไม่ต้องการ';
                }

                return 'ต้องการ ' . $equipment['computer'];
            }
        );
    }

    public function foodText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $food = $this->food;
                if (!$food['status']) {
                    return 'ไม่ต้องการอาหาร';
                }

                return 'ต้องการอาหาร ' . $food['lunch'];
            }
        );
    }

    public function statusLocale(): Attribute
    {
        return Attribute::make(
            get: fn() => (new BookingStatus)->getStatusLocale($this->attributes['status']),
        );
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function userData(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->users,
        );
    }

    public function requesterText(): Attribute
    {
        return Attribute::make(
          get: fn() => 'บันทึกข้อมูลโดย ' . $this->users->full_name . ' หน่วยงาน ' . $this->users->unit->name_th,
        );
    }



}
