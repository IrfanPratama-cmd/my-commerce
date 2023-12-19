<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
            return redirect()->route('index')
                        ->with('success','Login Successfull');
        }

        return redirect("login")->with('error', 'Login Gagal!, Email atau Password anda salah!.');
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $check = User::where('email', $request->email)->first();

        if($check != null){
            return back()->with('error', 'Email has been used!');
        }

        $data = $request->all();
        $createUser = $this->create($data);

        $role = Role::where('name', 'user')->first();
        $createUser->assignRole($role->name);

        $token = Str::random(64);

        UserVerify::create([
              'user_id' => $createUser->id,
              'token' => $token
            ]);

        UserProfile::create([
            'user_id' => $createUser->id,
        ]);

        Mail::send('email.verificationEmail', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Email Verification Mail');
          });

          return redirect()->route('login')
                        ->with('success','Register user successfully');
    }

    public function create(array $data)
    {
      $role = Role::where('name', 'user')->first();
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'role_id' => $role->id,
        'password' => Hash::make($data['password'])
      ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->email_verified_at = Carbon::now();
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

      return redirect()->route('login')->with('success', $message);
    }


}
