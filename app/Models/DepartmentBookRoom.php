<?php

namespace App\Models;

use App\Casts\BookingStatus;
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

    protected function statusLocale(): Attribute
    {
        return Attribute::make(
            get: fn() => (new BookingStatus)->getStatusLocale($this->attributes['status']),
        );
    }

    public function scopeOverlap($query, $start, $end)
    {
        $start = $start->addMinute();
        $query->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start);
    }

    public function setRoomText(): Attribute
    {
        return Attribute::make(
            get: function() {
                $setRoom = $this->set_room;
                if (!$setRoom['status']) {
                    return 'ไม่ต้องจัดห้อง';
                }

                return 'มีการขอให้จัดห้องแบบ ' . $setRoom['type_table'];
            }
        );
    }

    public function durationText(): Attribute
    {
        return Attribute::make(
            get: function() {
                return 'จองเมื่อ ' . $this->start_date->thaidate('j F Y เวลา H:i') .' ถึง '. $this->end_date->format('H:i');
            }
        );
    }
}
