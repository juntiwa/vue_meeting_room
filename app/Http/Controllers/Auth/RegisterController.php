<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AddPermissionAuto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        $sirirajUser = session('sirirajUser');
        if (!$sirirajUser) {
            return redirect()->route('login');
        }
        return Inertia::render('Auth/Register', ['sirirajUser' => $sirirajUser]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sap_id' => 'required',
            'login' => 'required',
            'full_name' => 'required',
            'unit_id' => 'required',
            'tel' => 'required',
            'phone' => 'required'
        ]);

        $user = User::query()->create($validated);
        $addPermission = AddPermissionAuto::query()->where('sap_id', $validated['sap_id'])->first();
        if ($addPermission) {
            $user->assignRole($addPermission['role']);
        } else {
            $user->assignRole('user');
        }

        session()->forget('sirirajUser');

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
