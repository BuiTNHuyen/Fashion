<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request){
        $status = $request->status;
        $orders = Order::orderByDesc('id');
        if(isset($status)){
            $orders = $orders->where('status', $status);
        }
        $orders = $orders->paginate(10);
        return view('admin.order.list', compact('orders'));
    }

    public function show(Order $order){
        return view('admin.order.show', compact('order'));
    }

    public function confirm(Order $order){
        $order->status = 3;
        $order->save();

        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận.');
    }
} /*php*/
