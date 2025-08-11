<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Illuminate\Support\Facades;
use App\Models\Category;
use App\Models\Origin;
use App\Models\Brand;
use App\Models\Product;
use App\Models\PostType;
use App\Models\Post;
use DB;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Facades\View::composer('*', function (View $view) {
            $categories = Category::where('parent_id',0)->get();
            $post_types = PostType::all();
            $topPosts = Post::orderByDesc('view')->limit(3)->get();
            $origins = Origin::all();
            $brands = Brand::limit(8)->get();

            $sevenDaysAgo = now()->subDays(7);
            $topProduct_ids = Product::select('products.id', DB::raw('SUM(order_product.quantity) as totalSold'))
                    ->join('order_product', 'products.id', '=', 'order_product.product_id')
                    ->join('orders', 'order_product.order_id', '=', 'orders.id')
                    ->where('orders.created_at', '>=', $sevenDaysAgo)
                    ->groupBy('products.id')
                    ->orderByDesc('totalSold')
                    ->limit(5)
                    ->get();
            $topProducts = [];
            foreach ($topProduct_ids as $item) {
                $product = Product::find($item['id']);

                if ($product) {
                    $product->totalSold = $item['totalSold'];
                    $topProducts[] = $product;
                }
            }
            $view->with(compact('categories','origins','brands','topProducts','post_types','topPosts'));
        });
    }
}
 /*php*/
