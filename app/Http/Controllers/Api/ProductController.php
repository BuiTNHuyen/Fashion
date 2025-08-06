<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function getProduct($id){
        $product = Product::findOrFail($id);
        if ($product) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand->name,
                    'origin' => $product->origin->name,
                    'category' => $product->category->name,
                    'product_code' => $product->product_code,
                    'price' => convertPrice($product->price),
                    'price_sale' => convertPrice($product->price * (1 - ($product->discount/100))),
                    'quantity' => $product->quantity,
                    'image_url' => $product->firstImage()->image,
                    'description' => strip_tags($product->description),
                    'point' => number_format($product->reviews()->avg('point'), 1),
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy sản phẩm.'
            ]);
        }
        
    }
}
