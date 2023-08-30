<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
    public function index()
    {
        return view('session.login', ["data_user" => User::all()]);
    }

    public function create()
    {
        return view('session.create', ["user" => User::all()]);
    }
    
    public function auth(Request $request)
    {
        //validate data
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'device_token' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/dashboard/paket/all');
        }

        return back()->with([
            'loginError' => 'LOGIN GAGAL YA GES!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/session/login');
    }
}
