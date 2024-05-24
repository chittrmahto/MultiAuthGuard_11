<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;

class AdminController extends Controller
{
    public function dologin(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:15',
        ]);
        $credentials = $request->only('email','password');
        if(Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.home')->with('success','Welcome to user dashboard.');
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
