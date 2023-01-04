<?php

namespace App\Http\Controllers\RequestEquipment;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\UnitInner;
use App\Models\UnitLevel;
use App\Models\UnitOutter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormRequestEquipmentController extends Controller
{
    public function create()
    {
        $unitLevel = UnitLevel::query()->get();
        $inners = UnitInner::query()->get();
        $outters = UnitOutter::query()->get();
        $company = Company::query()->get();
        return Inertia::render('RequestEquipment/FormRequestEquipment', [
            'unitLevel' => $unitLevel,
            'inners' => $inners,
            'outters' => $outters,
            'company' => $company,
        ]);
    }
}
