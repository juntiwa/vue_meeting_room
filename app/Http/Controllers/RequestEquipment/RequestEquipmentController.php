<?php

namespace App\Http\Controllers\RequestEquipment;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\RequestEquipment;
use App\Models\UnitInner;
use App\Models\UnitLevel;
use App\Models\UnitOutter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestEquipmentController extends Controller
{
    public function index()
    {
        $requestEquipments = RequestEquipment::query()->get();
        return Inertia::render('RequestEquipment/ListRequestEquipment',[
            'requestEquipments' => $requestEquipments
        ]);
    }

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'unit_level' => 'required',
            'unit_id' => 'required',
            'full_name' => 'required',
            'tel' => 'required',
            'building' => 'required',
            'floor' => 'required',
            'room' => 'required',
            'equipment.lcdprojector' => 'required',
            'equipment.visualizer' => 'required',
        ]);


        $validated['place'] = 'ตึก' . $validated['building'] . ' ชั้น ' . $validated['floor'] . ' ห้อง ' . $validated['room'];

        RequestEquipment::query()->create($validated);
        return $validated;
    }
}
