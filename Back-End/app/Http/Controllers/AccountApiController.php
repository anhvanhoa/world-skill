<?php

namespace App\Http\Controllers;

use App\Models\Attendees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "lastname" => "required",
            "registration_code" => "required"
        ]);
        $user = Attendees::where('lastname', $request->lastname)->where("registration_code", $request->registration_code)->first();
        if (!$user) return response()->json(["message" => "Đăng nhập không hợp lệ"], 401);
        $res = [
            "firstname" => $user->firstname,
            "lastname" => $user->lastname,
            "username" => $user->username,
            "email" => $user->email,
            "token" => md5($user->username)
        ];
        $user = Attendees::find($user->id);
        $user->login_token = $res['token'];
        $user->save();
        return response()->json($res, 200);
    }

    public function logout(Request $request)
    {
        $token = $request->query('token');
        $user = Attendees::where('login_token', $token);
        $user->login_token = '';
        if ($user) return response()->json(['message' => '"Đăng xuất thành công'], 200);
        else return response()->json(['message' => 'Token không hợp lệ'], 200);
    }
}
