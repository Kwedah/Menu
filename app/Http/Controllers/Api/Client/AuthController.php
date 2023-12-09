<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed ",
            "address" => "required",
            "phone" => "required"
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->phone = isset($request->phone) ? $request->phone : "";

        $user->save();

        return response()->json([
            "status" => 1,
            "message" => "You Are Registerd Now"
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where('email' , $request->email)->first();

            if (isset($user->id)) {

                if (Hash::check($request->password, $user->password)) {

                    $token = $user->createToken("auth_token")->plainTextToken;

                    return response()->json([
                        "status" => 1,
                        "message" => "user logged in successfully!",
                        "access_token" => $token
                    ]);

                }else{
                    return response()->json([
                        "status" => 0,
                        "message" => "Password in wrong!",

                    ]);
                }

        }else{
            return response()->json([
                "status" => 0,
                "message" => "email not found!",
            ]);
        }
    }

    public function profile()
    {
        return response()->json([
            "status" => 1,
            "message" => "Your Profile",
            "data" => auth()->user()
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => 1,
            "message" => "You Are Logouted!",
            "data" => auth()->user()
        ]);
    }
}
