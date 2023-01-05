<?php

namespace App\Models;

use App\Casts\BookingStatus;
use App\Traits\CSVLoadable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentRoomStatus extends Model
{
    use HasFactory,CSVLoadable;

    public function departmentroom()
    {
        return $this->hasMany(DepartmentRoom::class,'status_id','id');
    }

    protected function statusLocale(): Attribute
    {
        return Attribute::make(
            get: fn() => (new BookingStatus)->getStatusLocale($this->attributes['status']),
        );
    }
}
