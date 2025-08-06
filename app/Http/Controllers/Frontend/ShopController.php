<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Post;
use App\Models\Viewed;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ProductRecommendationService;

class ShopController extends Controller
{
    public function index(){
        // Gợi ý sản phẩm với collaborative filtering
        $product_recommends = [];
        if(Auth::guard('web')->check()){
            $userId = Auth::guard('web')->id() ;
            $recommendationService = new ProductRecommendationService();
            
            // Tự động train nếu cần
            $recommendationService->autoTrainIfNeeded();
            
            if ($recommendationService->hasEnoughRecommendationData($userId)) {
                $product_recommends = $recommendationService->getRecommendations($userId);
            }
        }
        $topSellingProducts = Product::with('images')->select('*', DB::raw('1 as is_best_selling'))->orderByDesc('sold')->get()->take(20);
        $discountProducts = Product::with('images')->where('discount', '>', 0)->orderByDesc('id')->limit(20)->get();
        $newPosts = Post::orderByDesc('id')->limit(3)->get();
        $latestProducts = Product::with('images')->orderByDesc('id')->limit(20)->get();
        return view('frontend.index', compact('discountProducts','topSellingProducts', 'newPosts', 'latestProducts', 'product_recommends'));
    }

    public function shop(Request $request){
        $keyword = $request->input('keyword');
       
        $products = Product::when($keyword, function($query,$keyword){
            return $query->where('name','like',"%$keyword%");
        });
        
        $products = $this->filter($products, $request);
        $products = $this->sortBy($products, $request);
        $products = $products->paginate(12);
        return view('frontend.shop', compact('products'));
    }

    public function product(Product $product){
        if(Auth::guard('web')->check()){
            $user_id = auth('web')->id();
            $product_viewed = Viewed::where('product_id', $product->id)->where('user_id', $user_id)->first();
            if(!empty($product_viewed)){
                $product_viewed->created_at = now();
                $product_viewed->save();
            }else{
                Viewed::create([
                    'product_id' => $product->id,
                    'user_id' => $user_id,
                ]);
            }
        }
        $product->view += 1;
        $product->save();

        $relatedProducts = Product::where('category_id', $product->category_id)
                            ->where('id', '<>', $product->id)
                            ->limit(3)
                            ->get();
        $reviews = $product->reviews;
        return view('frontend.product', compact('product', 'relatedProducts', 'reviews'));
    }

    public function getProductByCategory(Category $category, Request $request){
        
        if($category->children->count() != 0){
            $child_cate_ids = $category->children()->pluck('id');
            $products = Product::whereIn('category_id', $child_cate_ids);
        }
        else{
            $products = Product::where('category_id',$category->id);
        }
        $products = $this->filter($products, $request);
        $products = $this->sortBy($products, $request);
        $products = $products->paginate(12);

        return view('frontend.shop',compact('products'));
    }

    // public function getProductByAuthor(Author $author, Request $request){
        
    //     $products = Product::where('author_id',$author->id);
    //     $products = $this->filter($products, $request);
    //     $products = $this->sortBy($products, $request);

    //     return view('frontend.shop',compact('products'));
    // }

    protected function filter($products, $request){
        
        /* Nơi sản xuất filter */
        $origins = $request->input('xuat_xu') ?? [];
        $arr_origins = array_keys($origins);

        $products = $products->when($arr_origins, function($query, $arr_origins){
            return $query->whereIn('origin_id', $arr_origins);
        });

        /* Thương hiệu filter */
        $brands = $request->input('thuong_hieu') ?? [];
        $arr_brands = array_keys($brands);

        $products = $products->when($arr_brands, function($query, $arr_brands){
            return $query->whereIn('brand_id', $arr_brands);
        });

        // $min_price = $request->input('min_price');
        // $max_price = $request->input('max_price');

        // $products = ($min_price != null && $max_price != null) 
        //             ? $products->whereBetween('price', [$min_price, $max_price]) : $products;

        return $products;
    }

    protected function sortBy($products,Request $request){
        $sortBy = $request->input('sort_by') ?? 'latest';
        
        switch ($sortBy) {
            case 'latest':
                $products = $products->orderByDesc('id');
                break;
            case 'oldest':
                $products = $products->orderBy('id');
                break;
            case 'price-ascending':
                $products = $products->orderBy('price');
                break;
            case 'price-desending':
                $products = $products->orderByDesc('price');
                break;
            case 'discount':
                $products = $products->where('discount', '<>', 0)->orderByDesc('discount');
                break;
            default: $products = $products->orderByDesc('id');
        }

        // $products = $products->paginate(1);
        // $products->appends(['sort_by' => $sortBy , 'show' => $perPage]);

        return $products;
    }

    public function contact(){
        return view('frontend.contact');
    }

    public function compare(){
        return view('frontend.compare');
    }

    public function sendContact(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'from' => 'required|email',
            'message' => 'required|string',
        ]);

        \App\Models\Contact::create([
            'name' => $request->name,
            'from' => $request->from,
            'message' => $request->message,
        ]);

        return redirect()->route('contact')->with('success', 'Gửi liên hệ thành công!');
    }
}

//Gợi ý sản phẩm
// $thirtyDaysAgo = date('Y-m-d', strtotime("-30 days"));
// $viewed = Viewed::where('user_id', auth('web')->id())->where('created_at', '>', $thirtyDaysAgo)->pluck('product_id')->toArray();
// $farvorited = Favorite::where('user_id', auth('web')->id())->pluck('product_id')->toArray();
// $product_ids = array_merge($viewed, $farvorited);
// $most_category = Product::whereIn('products.id', $product_ids)
//                     ->select('category_id', DB::raw('COUNT(category_id) as count'))
//                     ->groupBy('category_id')
//                     ->orderByDesc('count')
//                     ->limit(3)
//                     ->pluck('category_id')
//                     ->toArray();
// $product_recommends = Product::whereIn('category_id', $most_category)->orderByDesc('created_at')->get()->take(20);