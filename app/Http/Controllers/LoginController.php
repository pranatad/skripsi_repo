<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function login()
    {
        $login = request()->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        //dd($login, $field);
        if (Auth::attempt([$field => $login, 'password' => request()->password], false)) {
            return redirect('/home');
        } else {
            Alert::info('Username / Password Salah', 'Info Message');
            //toast('Username / Password Salah', 'warning');
            return back();
        }
    }

    public function loginhome()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
