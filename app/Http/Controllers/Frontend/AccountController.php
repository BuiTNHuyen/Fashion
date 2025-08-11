<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;
use Hash;
use Auth;
use DB;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function account(){
        $user = Auth::guard('web')->user();
        $orders = Order::where('user_id', $user->id)->orderByDesc('id')->paginate(10);
        return view('frontend.account', compact('orders', 'user'));
    }

    public function updateAccount(Request $request){
        $user = \Auth::guard('web')->user();
        if($request->avatar){
            $file = $request->avatar;
            $imageName = $file->hashName();
            $res = $file->storeAs('avatars', $imageName, 'public');
            if($res){
                $user->avatar = 'avatars/' . $imageName;
            }
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();
        toastr()->success('Cập nhật tài khoản thành công.');
        return redirect()->back();
    }

    public function review(Request $request){
        DB::beginTransaction();
        try {
            Review::create([
                'user_id' => auth('web')->id(),
                'product_id' => $request->product_id,
                'order_product_id' => $request->order_product_id,
                'point' => $request->point,
                'content' => $request->content,
            ]);
            DB::commit();
            toastr()->success('Đánh giá sản phẩm thành công.');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return back();
        }
        
    }

    public function cancel(Order $order){
        $order->status = 0;
        $order->save();
        toastr()->success('Hủy đơn hàng thành công.');
        return redirect()->back();
    }

    public function receive(Order $order){
        foreach($order->products as $item){
            $item->sold += $item->pivot->quantity;
            $item->save();
        }
        $order->status = 4;
        $order->save();
        toastr()->success('Nhận hàng thành công.');
        return redirect()->back();
    }
    public function return(Order $order){
        $order->status = 1;
        $order->save();
        toastr()->success('Đơn hàng đã được hoàn trả.');
        return redirect()->back();
    }

    public function orderDetail(Order $order){
        return view('frontend.order-detail', compact('order'));
    }

    public function changePassword(){
        return view('frontend.change-password');
    }

    public function updatePassword(Request $request){
        $user = \Auth::guard('web')->user();

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6'
        ],[
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Mật khẩu cũ không đúng.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        toastr()->success('Thay đổi mật khẩu thành công.');
        return redirect()->back();

    }
} /*php*/
