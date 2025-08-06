<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Mail\RegisterSuccessMail;
use Illuminate\Support\Facades\Mail;
use DB;
use Log;

class AuthUserController extends Controller
{
    public function login(){
        return view('frontend.auth.login');
    }

    public function loginPost(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => 'Địa chỉ email không được để trống.',
            'password.required' => 'Mật khẩu không được để trống.',
        ]);

        if (Auth::guard('web')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ])){
            $request->session()->regenerate();
            
            toastr()->success('Đăng nhập thành công.');
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'status' => 'Thông tin đăng nhập được cung cấp không khớp.',
        ]);
    }

    public function register(){
        return view('frontend.auth.register');
    }

    public function registerPost(Request $request){
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ],[
            'name.required' => 'Họ tên không được để trống.',
            'email.required' => 'Địa chỉ email không được để trống.',
            'email.unique' => 'Email này đã được đăng ký',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ]);
        
        DB::beginTransaction();
        try {
            $user = User::create($validated);
            Mail::to($user->email)->send(new RegisterSuccessMail($user));
            toastr()->success('Đăng ký tài khoản thành công.');
            DB::commit();
            
            return redirect()->route('login');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            toastr()->error('Đăng ký tài khoản không thành công.');
            return back();
        }
        
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
 
        // $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}