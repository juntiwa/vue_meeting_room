<?php

namespace App\Models;

use App\Traits\CSVLoadable;
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
}
