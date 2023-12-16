<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Organizers;

class AuthController extends Controller
{
    function loginShow(Request $req) {
        return view('login');
    }
    public function loginHandle(Request $req) {
        $req->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ], 
            [
                'email.required' => 'Vui long nhap email',
                'password.required' => 'Vui long nhap password',
            ]
        );
        $email = $req->email;
        $password = $req->password;
        $organizer = Organizers::where('email', $email)->first();
        if(!$organizer) return redirect()->back()->with('error', 'Tên đăng nhập hoặc mật khẩu 
        không chính xác');
        if(!Hash::check($password, $organizer->password_hash)) return redirect()->back()->with('error', 'Tên đăng nhập hoặc mật khẩu 
        không chính xác');
        session()->put('user', $organizer);
        return redirect()->route('events');
    }
    public function logoutHandle(Request $req) {
        session()->forget('user');
        return redirect()->route('login');
    }
}
