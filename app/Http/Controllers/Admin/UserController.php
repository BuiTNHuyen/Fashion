<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::orderByDesc('id')->paginate(10);
        return view('admin.user.list', compact('users'));
    }



    public function destroy(User $user){
        $user->delete();
        return redirect()->back()->with('success', 'Xóa khách hàng thành công.');
    }
}