<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function resetPassword(){
        return view('auth.forgot-password');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard')
                ->withSuccess('You have Successfully loggedin');
        }

        return redirect("login")->with('error', 'Login Gagal!, Email atau Password anda salah!.');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }


}
