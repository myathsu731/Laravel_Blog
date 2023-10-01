<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        $user_data = auth()->user();
        return view('users.index',[
            'user' => $user_data,
        ]);
    }

    public function profile_update(Request $request)
    {
        $validator = validator(request()->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user =  User::find(Auth::user()->id);
        $user->name = request()->name;
        $user->email = request()->email;
        $user->save();
        return back()->with('success', "Your profile changed successfully");;
    }

    public function change_password(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8'
        ]);

        $auth = Auth::user();
 
        // The passwords matches
        if (!Hash::check($request->get('current_password'), $auth->password)) 
        {
            return back()->with('error', "Current Password is Invalid");
        }
 
        // Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0) 
        {
            return back()->with("error", "New Password cannot be same as your current password.");
        }
 
        $user =  User::find($auth->id);
        $user->password =  Hash::make($request->new_password);
        $user->save();
        return back()->with('success', "Password changed successfully");
    }
}
