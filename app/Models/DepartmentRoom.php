<?php

namespace App\Models;

use App\Traits\CSVLoadable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentRoom extends Model
{
    use HasFactory,CSVLoadable;

    public function departmentroomstatus()
    {
        return $this->belongsTo(DepartmentRoomStatus::class,'status_id');
    }

    public function getRoomStatusAttribute()
    {
        return $this->departmentroomstatus->name_th;
    }

    public function medicineroom()
    {
        return $this->hasOne(DepartmentBookRoom::class,'meeting_room_id', 'id');
    }

    public function roomID():Attribute
    {
        return Attribute::make(
            get: fn() => $this->id,
        );
    }

    public function roomName():Attribute
    {
        return Attribute::make(
            get: fn() => $this->name_th,
        );
    }
}
