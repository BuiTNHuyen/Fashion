<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class RecommendationDataSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run()
    {
        $imagePaths = [
            'products/HH1UwLGK2Qeq2j70B8MUVRJJe0L1YT6mF9jb0K7f.webp',
            'products/qHPXuHgt4X8dAFM6e42LDdp7enMbPYSbStY7RHH2.jpg',
            'products/1NVhuTYcRBlXizSQkbLli26kUDFuyfCryLS0Jbq1.webp',
            'products/EEtESWc0OiVHTZGPnTN07thnuDWORHmAoAftscF7.jpg',
            'products/0Ttropoz54TIdUORDWZuvbXzTrGXtUqlTmagV2y1.jpg',
            'products/kOEAsMuheaCtKSmvuGzNAfu2G8cx6bYgHGVAiwVn.jpg',
            'products/9DYsJYPDbpcYVjRphRlFtWGxDXsfqFRR6SQ54R3S.jpg',
            'products/hJDYRvIapmg9BWjZnozGnTAZyjIY2D3c3OFUWGV2.webp',
            'products/LHgsfGjLxCLypHdrHyNiC0xr8QA4RCm8ziQM3Otx.jpg',
            'products/earqlv9y8U6cCYMuKYLv4iTA8XgSBhfQnCHXkudl.webp',
            'products/3rZyK5KmQY2YQUth7mDAVLF8rJV11bIs89a0EdSQ.webp',
            'products/HKNb70G2qYNYBU8rmMlujTX7AHjcKVgADZE34RrZ.webp',
            'products/Pllfh5Xkg1jNSDQKyvzJLkawWeUwdCCAejmmJge4.webp',
            'products/tScOfKukQlw4aEgO6PpadHuHKtVntIoYDe937Ipn.jpg',
            'products/pxCFzUS4Q3ZHvdp8sFE9Vxgr9kAipSmx39aKDTNz.jpg',
            'products/sUbHm71PGrU0OEdU9yXW2d8jbOnMSQ7gJYglVVkl.webp',
            'products/xj4UOM9XRB2Bg8dRoEeLNosaao8UoB0tQhYCHMpw.webp',
            'products/r615FiXmsT7TEWihJSqP08vM6zEh4pFeMlulxUwS.webp',
            'products/mnQtQaYEk1kzI0HaIITzoglrJC39KdaUzKafElE4.webp',
            'products/IyBrknsrlJ1sWToiHaCISbnJWsrhhclwIyhgUXzC.webp',
            'products/M9jeGnBcyNAHk5ZdfxQBYPwYZAb6Z4Ef5TK8miiH.webp',
            'products/BbymuLZEVGgTig53xu3nPgi5muZcpbuycyCLXRe9.webp',
            'products/TQVAz060zEYUckSFMDpVu4blscApd1b4nFwegVvj.webp',
            'products/DocwoGdRhfDvp2ygYn8w7iLcuqEeblsIfo7IMDxV.jpg',
            'products/tSnJCRXtg4eMJyZh4AE112ekQ54cZqYhQrLk9JJr.webp',
            'products/8vI2AnWpW6rGsSfTaSpDB6M6mQ8wCsF2bl206TaZ.webp',
            'products/T8ICDsPGbieLquAVena9Y6bT0hgTumzexdd0vyQH.webp',
            'products/kshdrDG8XhLZAbN2H0dAtWqUpxGAGQ15NI6YeGWL.jpg',
            'products/7PvNW3vyMWmXIwmjMQFVyNVUFN600HFweHSYH8CF.jpg',
            'products/J5YA37bW9jHuaRT0zDahRjYZh5dketm4eryUPkCi.webp',
            'products/nmYjtpXprUOqsxRUO8VN8S9ZhjH9KOdlqhQPfJ0m.jpg',
            'products/CGXGlKyI2xyDfcNmmIFDwo8HbXsxZNwVt7BntVmU.jpg',
            'products/BeCjZzdeCt0yWpLz8Yrc3rHZJb1eijksHUpL16Gb.webp',
            'products/MAidsWW5yzUNLxikYDhD19fliBwGgvOe7Zbkzohj.webp',
            'products/3RmsApDhJc6TMwYS1S9PTECsbU1cNdmAOjR05DOX.webp',
            'products/p5P3QM8DVcBgpIoT0qyWDJolrUGYhFPNoyUTpfDT.webp',
            'products/tdiT6P03Aph8CuBreLBioEd0RsxkpLzkOKhTnbH8.webp',
            'products/ryadHnrcbzLEFeWcJnlPjZCZTpS3I7KGjD7CUWjl.jpg',
            'products/xEFeTMXqW579rpUU3vbFDgCbiAZ1YrkSjYZUutWp.jpg',
        ];

        // Tạo 50 sản phẩm
        // $products = Product::factory()->count(50)->create();
        // Lấy tất cả id của category hiện có
        $categoryIds = \App\Models\Category::pluck('id')->toArray();

        // // Tạo 50 sản phẩm với category_id hợp lệ
        $products = Product::factory()->count(50)->create([
            'category_id' => function() use ($categoryIds) {
                return $categoryIds[array_rand($categoryIds)];
            },
        ]);

        // Tạo ảnh cho mỗi sản phẩm (2-4 ảnh mỗi sản phẩm)
        foreach ($products as $product) {
            $imageCount = rand(2, 4);
            for ($i = 0; $i < $imageCount; $i++) {
                DB::table('product_images')->insert([
                    'product_id' => $product->id,
                    'image' => $this->faker->randomElement($imagePaths),
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ]);
            }
        }

        // Tạo 50 người dùng
        $users = User::factory()->count(50)->create();

        // Tạo đơn hàng (50-80 đơn hàng)
        $orderUsers = $users->random(rand(25, 30));
        foreach ($orderUsers as $user) {
            $userOrders = rand(2, 3);
            $orders = Order::factory()
                ->count($userOrders)
                ->create([
                    'user_id' => $user->id
                ]);

            // Tạo chi tiết đơn hàng cho mỗi đơn
            foreach ($orders as $order) {
                $orderItems = rand(1, 5);
                for ($i = 0; $i < $orderItems; $i++) {
                    $product = $products->random();
                    DB::table('order_product')->insert([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'quantity' => rand(1, 3),
                        'price' => $product->price,
                        'created_at' => $order->created_at,
                        'updated_at' => $order->updated_at,
                    ]);
                }
            }
        }

        // Tạo đánh giá (200-300 đánh giá)
        $reviewUsers = $users->random(rand(30, 40));
        foreach ($reviewUsers as $user) {
            $userReviews = rand(1, 5);
            // Lấy các order_product của user này từ đơn hàng đã hoàn thành
            $orderProducts = DB::table('order_product')
                ->join('orders', 'order_product.order_id', '=', 'orders.id')
                ->where('orders.user_id', $user->id)
                ->where('orders.status', 4) // 4: delivered
                ->select('order_product.*')
                ->get();

            if ($orderProducts->isNotEmpty()) {
                Review::factory()
                    ->count(min($userReviews, $orderProducts->count()))
                    ->create([
                        'user_id' => $user->id,
                        'product_id' => fn() => $orderProducts->random()->product_id,
                        'order_product_id' => fn() => $orderProducts->random()->id,
                    ]);
            }
        }

        // Tạo lượt xem (500 lượt xem)
        $viewUsers = $users->random(rand(40, 50));
        $totalViews = 500;
        $remainingViews = $totalViews;
        $createdViews = 0;
        
        foreach ($viewUsers as $user) {
            if ($remainingViews <= 0) break;
            
            // Phân bố lượt xem còn lại cho user hiện tại
            $maxViews = min(20, $remainingViews);
            $userViews = rand(15, $maxViews);
            $remainingViews -= $userViews;
            $createdViews += $userViews;
            
            for ($i = 0; $i < $userViews; $i++) {
                DB::table('vieweds')->insert([
                    'user_id' => $user->id,
                    'product_id' => $products->random()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Tạo sản phẩm yêu thích (100-150 sản phẩm)
        $favoriteUsers = $users->random(rand(30, 40));
        foreach ($favoriteUsers as $user) {
            $userFavorites = rand(3, 5);
            // Lấy danh sách sản phẩm chưa được yêu thích bởi user này
            $existingFavorites = DB::table('favorites')
                ->where('user_id', $user->id)
                ->pluck('product_id')
                ->toArray();
            
            $availableProducts = $products->filter(function($product) use ($existingFavorites) {
                return !in_array($product->id, $existingFavorites);
            });

            if ($availableProducts->isNotEmpty()) {
                $favoriteCount = min($userFavorites, $availableProducts->count());
                $selectedProducts = $availableProducts->random($favoriteCount);
                
                foreach ($selectedProducts as $product) {
                    DB::table('favorites')->insert([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
} 