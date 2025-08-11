<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;

class AuthController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    public function loginPost(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('admin/dashboard')->with('success','Xin chào ' . Auth::guard('admin')->user()->name . ', chào mừng quay trở lại.');
        }
 
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();
 
        $request->session()->regenerateToken();
    
        return redirect('/admin/login');
    }

    public function password(){
        return view('admin.auth.change-password');
    }

    public function changePassword(Request $request){
        $user = Auth::guard('admin')->user();

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6'
        ],[
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải tối thiểu 6 kí tự.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Mật khẩu cũ không đúng.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Thay đổi mật khẩu thành công.');
    }
} /*php*/
