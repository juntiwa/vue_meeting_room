<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AddPermissionAuto;
use App\Models\UnitInner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        $sirirajUser = session('sirirajUser');
        $units = UnitInner::query()->orderBy('name_th', 'asc')->get();
        if (!$sirirajUser) {
            return redirect()->route('login');
        }
        return Inertia::render('Auth/Register',
            [
                'sirirajUser' => $sirirajUser,
                'units' => $units
            ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sap_id' => 'required',
            'login' => 'required',
            'full_name' => 'required',
            'unit_id' => 'nullable|numeric',
            'tel' => 'nullable|string',
            'phone' => 'nullable|numeric'
        ]);

        $user = User::query()->create($validated);
        $addPermission = AddPermissionAuto::query()->where('sap_id', $validated['sap_id'])->first();
        if ($addPermission) {
            if ($addPermission['role'] === 'admin') {
                $user->assignRole('user_med');
                $user->assignRole('period_booked');
                $user->assignRole($addPermission['role']);
            }

            if ($addPermission['role'] === 'period_booked'){
                $user->assignRole('user_med');
                $user->assignRole($addPermission['role']);
            }
        } elseif ($validated['unit_id']) {
            $user->assignRole('user_med');
        } else {
            $user->assignRole('user');
        }

        session()->forget('sirirajUser');

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
