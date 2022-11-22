<?php

namespace App\Models;

use App\Traits\CSVLoadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentPurposeBookRoom extends Model
{
    use HasFactory,CSVLoadable;

    protected $fillable = [
        'name_th',
        'name_en',
        'label',
    ];
}
