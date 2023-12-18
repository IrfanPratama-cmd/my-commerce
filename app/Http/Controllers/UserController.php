<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $page = "Master Data User";
        $role = Role::all();
        if ($request->ajax()) {
            $data = User::with('role')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('no', function ($row) {
                        static $no = 0;
                        return ++$no;
                    })
                    ->addColumn('action', function($row){

                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a> ';
                            $btn = $btn. ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('user.index', compact('page', 'role'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        $role = Role::where('id', $request->role_id)->first();
        $token = Str::random(64);
        $data['password'] = $token;
        $user = User::create($data);

        $user->assignRole($role->name);

        UserVerify::create([
              'user_id' => $user->id,
              'token' => $token
            ]);

        UserProfile::create([
            'user_id' => $user->id,
        ]);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
          ]);

        Mail::send('user.verificationEmail', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Email Verification Mail');
          });
          return response()->json(['success','Register user successfully']);
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->email_verified_at = Carbon::now();
                $verifyUser->user->save();
            } else {
                return redirect()->route('login')
                        ->with('success','Your e-mail is already verified. You can now login.');
            }
        }

        return view('auth.reset-password', ['token' => $token]);
    }
}
