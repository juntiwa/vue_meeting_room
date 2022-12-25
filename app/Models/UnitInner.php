<?php

namespace App\Models;

use App\Traits\CSVLoadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitInner extends Model
{
    use HasFactory,CSVLoadable;

    protected $fillable = [
        'unit_id',
        'level',
        'name_th',
        'name_en',
        'shot_name_th',
        'shot_name_en',
    ];
}
