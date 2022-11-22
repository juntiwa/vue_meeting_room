<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthUserAPI;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request, AuthUserAPI $api)
    {
        $sirirajUser = $api->authenticate($request->login, $request->password);

        if($sirirajUser['found'] !== true){
            return back()->withErrors([
                'login' => $sirirajUser['reply_text'] ?? 'not allow',
            ]);
        }

        $user = User::query()->where('sap_id',$sirirajUser['org_id'])->first();
        if(!$user){
            // return Inertia::render('Auth/Register',['sirirajUser'=>$sirirajUser]);
            session()->put('sirirajUser',$sirirajUser);
            return redirect()->route('register');
        }

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function destroy(){
        Auth::logout();

        return redirect()->route('login');
    }
}
