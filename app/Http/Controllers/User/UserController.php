<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
class UserController extends Controller
{
    public function create(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:15',
            'cpassword' => 'required|same:password',
        ],[
            'cpassword.required' => 'The Confirm Password is Required.',
            'cpassword.same' => 'The Password and Confirm Password must be same.',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $data = $user->save();
        if($data) {
            return redirect()->back()->with('success','You are registered successfully.');
        } else {
            return redirect()->back()->with('error','Registration failed.');
        }
    }
    public function dologin(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:15',
        ]);
        $credentials = $request->only('email','password');
        if(Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('user.home')->with('success','Welcome to user dashboard.');
        } else {
            return redirect()->back()->with('error','Login failed.');
        }
    }
    public function logout()
    {
        //echo "bye bye"; exit();
        Auth::guard('web')->logout();
        return redirect()->route('user.login');
    }
}
