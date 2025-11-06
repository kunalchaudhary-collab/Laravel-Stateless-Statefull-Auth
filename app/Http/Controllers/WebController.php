<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{
    public function showLogin()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function showRegister()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }
    public function login(Request $r)
    {
        $r->validate([
            "email" => "required|exists:users,email",
            "password"=>"required"
        ]);
        try {
            if(Auth::attempt($r->only('email','password'))){
             return redirect()->route('dashboard')->with('success','Login successfully');
            }
             return redirect()->route('login')->with('error','Login Failed');
        } catch (Exception $e) {
            return  redirect()->route('login')->with('error', $e->getMessage());
        }
    }
    public function register(Request $r)
    {
        $r->validate([
            "name" => "required|min:10|max:30",
            "email" => "required|unique:users,email",
            "password" => "required|min:6|max:8|same:password_confirmation"
        ]);
        try {
            User::create([
                "name" => $r->name,
                "email" => $r->email,
                "password" => Hash::make($r->password)
            ]);
            return redirect()->route('login')->with('success', 'Login now with your email');
        } catch (Exception $e) {
            return  redirect()->route('login')->with('error', $e->getMessage());
        }
    }

    public function blogShow(){
        return view('blogs.index');
    }
}
