<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;

class FavoriteController extends Controller
{
    public function index(){
        $favoriteProducts = Auth::guard('web')->user()->favoriteProducts;
        return view('frontend.favorite', compact('favoriteProducts'));
    }

    public function add(Product $product){
        $user = Auth::guard('web')->user();
        $check_exist = $user->hasFavoritedProduct($product->id);
        if($check_exist){
            toastr()->error('Sản phẩm yêu thích đã tồn tại.');
        }
        else{
            toastr()->success('Thêm sản phẩm yêu thích thành công.');
            $user->favoriteProducts()->attach($product);
        }
        return back();
    }

    public function delete($product_id){
        $user = Auth::guard('web')->user();
        $user->favoriteProducts()->detach($product_id);
        toastr()->success('Xóa sản phẩm yêu thích thành công.');
        return back();
    }
}
 /*php*/
