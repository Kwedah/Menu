<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

    public function editProfile(Request $request)
    {
        $name = ($request->name) ? $request->name : Auth::guard('user_api')->user()->name;
        $email = ($request->email) ? $request->email :Auth::guard('user_api')->user()->email;
        $phone = ($request->phone) ? $request->phone :Auth::guard('user_api')->user()->phone;
        $address = ($request->address) ? $request->address :Auth::guard('user_api')->user()->address;
        $password = ($request->password) ? Hash::make($request->address) : Auth::guard('user_api')->user()->password;

        $client = User::find(Auth::guard('user_api')->user()->id);
        $client->name = $name;
        $client->email = $email;
        $client->phone = $phone;
        $client->address = $address;
        $client->password = $password;
        $client->save();

        return response()->json([
            "status" => 1,
            "message" => 'تم تعديل بياناتك بنجاح',
            "data" => $client
        ]);
        // return $this->helper->ResponseJson(1 , 'تم تعديل بياناتك بنجاح' , ['your info' => $client]);
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

    // <------------------------------\ Forgeted Email /------------------------------>
    // public function change_password(Request $request)
    // {

    //     $request->validate([
    //         'email' => 'required',
    //         'otp' => 'required',
    //     ]);

    //     $email = $request->email;
    //     $otp = $request->otp;

    //     $client = User::where('email' , $email)->first();
    //     if($client){
    //         if($otp == $client->otp){
    //             $token = $client->createToken('ClientToken')->plainTextToken;
    //             return $this->helper->ResponseJson(1 , 'تم التاكد من احقيتك لهذا الحساب' , ['token' => $token]);
    //         }else{
    //             return $this->helper->ResponseJson(0 , 'رمز التحقق خاطئ');
    //         }
    //     }else{
    //         return $this->helper->ResponseJson(0 , 'لا يوجد ايميل مسجل كهذا');
    //     }
    // }


    // <------------------------------\ Forgeted Password /------------------------------>
    // public function reset_password(Request $request)
    // {

    //     $request->validate([
    //         'old_password' => 'required',
    //         'password' => 'required|confirmed',
    //     ]);

    //     $password = $request->password;

    //     $client = User::find(Auth::guard('client_api')->user()->id);
    //     if($client){
    //         $client->otp = null;
    //         $client->password = Hash::make($password);
    //         $client->save();
    //         return $this->helper->ResponseJson(1 , 'تم تغيير كلمة المرور بنجاح');
    //     }else{
    //         return $this->helper->ResponseJson(0 , 'لا يوجد ايميل مسجل كهذا');
    //     }

    // }

    // <------------------------------\ Edit Password /------------------------------>
    public function edit_password(Request $request)
    {
        $request->validate([
            'past_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $pastPassword = $request->past_password;
        $password = $request->password;
        $user = Auth::guard('user_api')->user();

        if (Hash::check($pastPassword, $user->password))
        {
            $user->password = Hash::make($password);
            $user->save();
        }

        return response()->json([
            "status" => 1,
            "message" => "The password has been changed successfully",
        ]);

    }
}
