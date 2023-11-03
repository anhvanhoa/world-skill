<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Organizers;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view("index");
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);
        $check = Organizers::where("email", $request->email)->first();
        if ($check) {
            if (Hash::check($request->password, $check->password_hash)) {
                session()->put('user', $check);
                return redirect()->route("event");
            } else {
                return redirect()->back()->with('error', 'Tên đăng nhập hoặc mật khẩu 
                không chính xác');
            }
        } else {
            return redirect()->back()->with('error', 'Tên đăng nhập hoặc mật khẩu 
            không chính xác');
        }
    }

    public function logout(Request $request)
    {
        session()->forget('user');
        return redirect("/");
    }
}
