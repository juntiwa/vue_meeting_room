<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestEquipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'unit_level',
        'unit_id',
        'full_name',
        'tel',
        'place',
        'equipment',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'equipment' => AsArrayObject::class,
    ];

    public function dateFormat(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->start_date->thaidate('d/m/Y') . ' - ' . $this->end_date->thaidate('d/m/Y'),
        );
    }

    public function timeFormat(): Attribute
    {
        return Attribute::make(
            // get: fn() => $this->start_date->thaidate('d/m/Y H:i') . ' ถึง ' . $this->end_date->thaidate('d/m/Y H:i'),

            get: fn() => $this->start_date->thaidate('H:i') . ' - ' . $this->end_date->thaidate('H:i'),
        );
    }

    public function unitInner()
    {
        return $this->belongsTo(UnitInner::class, 'unit_id', 'id');
    }

    public function unitOutter()
    {
        return $this->belongsTo(UnitOutter::class, 'unit_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'unit_id', 'id');
    }

    public function unitText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $unitLevel = $this->unit_level;
                if ($unitLevel === 1) {
                    return 'หน่วยงานภายใน ' . $this->unitInner->name_th;
                } elseif ($unitLevel === 2) {
                    return 'หน่วยงานภายนอก ' . $this->unitOutter->name_th;
                } else {
                    return  $this->company->name_th;
                }

            }
        );
    }

    public function equipmentText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $equipment = $this->equipment;
                if ($equipment['visualizer'] === "0" && $equipment['lcdprojector'] === "0" && !$equipment['other']) {
                    $data = false;
                } else {
                    $data = null;
                    if ($equipment['visualizer'] !== "0") {
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
}
