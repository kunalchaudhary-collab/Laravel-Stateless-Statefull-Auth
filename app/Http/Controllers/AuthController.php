<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        $validate = $r->validate([
            "username" => "required|min:10|max:30",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|max:8",
            "role_id" => "integer|nullable"
        ]);
        try {
            $validate['role_id'] = isset($validate['role_id']) ? $validate['role_id'] : 1; // Deafult id for employee
            $user = User::create([
                "name" => $validate['username'],
                "email" => $validate['email'],
                "password" => Hash::make($validate['password']),
                "role_id" => $validate['role_id']
            ]);
            return response()->json(['status' => true, "msg" => "Signup Successfully", "user" => $user], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, "msg" => $e->getMessage()], 500);
        }
    }


    public function login(Request $r)
    {

        $r->validate([
            "email" => "required|exists:users,email",
            "password" => "required"
        ]);
        try {
            $user = User::where('email', $r->email)->first();

            if (!Hash::check($r->password, $user->password)) {
                return response()->json(['status' => false, "msg" => "Invalid Credentials"], 401);
            }
            $token = $user->createToken('api')->plainTextToken;
            return response()->json(['status' => true, "msg" => "Login In Successfully", "token" => $token]);
        } catch (Exception $e) {
            return response()->json(['status' => false, "msg" => $e->getMessage()], 500);
        }
    }



    public function logout(Request $r)
    {
        $r->user()->tokens()->delete();
        return response()->json(['status' => true, "msg" => "Log Out Successfully"]);
    }
}
