<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function cart(){
        return view('frontend.cart');
    }

    public function add(Product $product, Request $request){
        if($product->quantity == 0){
            toastr()->error('Sản phẩm này đã hết hàng.');
            return back();
        }
        $quantity = $request->quantity ?? 1;
        $cart = session('cart', []);

        if(array_key_exists($product->id, $cart)){
            $cart[$product->id]['quantity'] += $quantity;
            
        }
        else{
            $cart[$product->id] = [
                'product_id' => $product->id,
                'image' => $product->firstImage()->image,
                'name' => $product->name,
                'quantity' => $quantity,
                'price'=> $product->price,
            ];
        }
        session()->put('cart', $cart);
        $this->totalPrice();
        toastr()->success('Thêm sản phẩm thành công.');
        return redirect()->back();
    }

    public function increase($product_id){ 
        $cart = session('cart', []);
        if(isset($cart[$product_id])){
            $cart[$product_id]['quantity'] += 1;
        };
        session()->put('cart', $cart);
        $this->totalPrice();
        toastr()->success('Cập nhật thành công.');
        return redirect()->back();
    }

    public function decrease($product_id){ 
        $cart = session('cart', []);
        if(isset($cart[$product_id])){
            $cart[$product_id]['quantity'] -= 1;
            if($cart[$product_id]['quantity'] === 0){
                unset($cart[$product_id]);
            }
        };
        session()->put('cart', $cart);
        $this->totalPrice();
        toastr()->success('Cập nhật thành công.');
        return redirect()->back();
    }

    public function delete($product_id){
        $cart = session('cart');
        unset($cart[$product_id]);
        session()->put('cart', $cart);
        $this->totalPrice();
        toastr()->success('Xóa thành công');
        return back();
    }

    protected function totalPrice(){
        $total_price = 0;
        foreach(session('cart') as $item){
            $total_price += $item['quantity'] * $item['price'];
        }
        session()->put('total_price', $total_price);
    }

}
 /*php*/
