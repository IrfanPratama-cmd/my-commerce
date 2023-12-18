<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UserProfile;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        $profile = UserProfile::where('user_id', auth()->user()->id)->first();
        $category = Category::all();
        return view('ecommerce.profile.index', compact('profile', 'category'));
    }

    public function edit(){
        $profile = UserProfile::where('user_id', auth()->user()->id)->first();
        $category = Category::all();
        return view('ecommerce.profile.edit', compact('profile', 'category'));
    }

    public function update(Request $request){
        $data = $request->validate([
            'full_name' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
        ]);

        if ($files = $request->file('asset')) {

            //delete old file
            File::delete('profile/'.$request->asset);

            //insert new file
            $destinationPath = 'profile/'; // upload path
            $filename = $request->full_name . '.' . $files->getClientOriginalExtension();
            $files->move($destinationPath, $filename);
            // $size = $request->file('asset')->getSize();
            $url = $destinationPath . $filename;

            $data['profile_asset'] = $filename;
         }

        //  dd($data);

         UserProfile::where('user_id', auth()->user()->id)->update($data);

         return redirect()->route('profile.index')
                        ->with('success','Edit profile successfully');
    }
}
