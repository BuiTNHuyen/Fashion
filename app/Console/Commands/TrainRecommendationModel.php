<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductRecommendationService;
use Illuminate\Support\Facades\Storage;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\Kernels\Distance\Euclidean;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

class TrainRecommendationModel extends Command
{
    protected $signature = 'recommendation:train {--force : Force retrain even if no new data}';
    protected $description = 'Train the product recommendation model and save to file';

    private const MODEL_FILE = 'recommendation_model.rbx';
    private const METADATA_FILE = 'recommendation_metadata.json';

    public function handle()
    {
        $this->info('Starting to train recommendation model...');

        // Kiểm tra xem có cần train lại không
        if (!$this->shouldRetrain() && !$this->option('force')) {
            $this->info('No new data detected. Skipping training. Use --force to retrain anyway.');
            return;
        }

        // Lấy dữ liệu và train model
        $scores = [];
        
        // Đánh giá
        foreach (\App\Models\Review::all() as $review) {
            $scores[$review->user_id][$review->product_id] = $review->point ?? 3;
        }

        // Đã xem
        foreach (\App\Models\Viewed::all() as $viewed) {
            $scores[$viewed->user_id][$viewed->product_id] = ($scores[$viewed->user_id][$viewed->product_id] ?? 0) + 1;
        }

        // Yêu thích
        foreach (\App\Models\Favorite::all() as $favorite) {
            $scores[$favorite->user_id][$favorite->product_id] = ($scores[$favorite->user_id][$favorite->product_id] ?? 0) + 3;
        }

        // Đã mua
        $orders = \Illuminate\Support\Facades\DB::table('order_product')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.user_id', '!=', 0)
            ->select('orders.user_id', 'order_product.product_id')
            ->get();
        foreach ($orders as $order) {
            $scores[$order->user_id][$order->product_id] = ($scores[$order->user_id][$order->product_id] ?? 0) + 2;
        }

        // Chuẩn hóa dữ liệu
        $dataset = [];
        $labels = [];

        // Lấy tất cả các sản phẩm đã có tương tác
        $allProducts = collect();
        foreach ($scores as $products) {
            $allProducts = $allProducts->merge(array_keys($products));
        }
        $allProducts = $allProducts->unique()->values()->toArray();

        foreach ($scores as $uid => $products) {
            if (empty($products) || array_sum($products) == 0) {
                continue;
            }
            $features = [];
            foreach ($allProducts as $productId) {
                $features['product_' . $productId] = $products[$productId] ?? 0;
            }
            $dataset[] = $features;
            $labels[] = 'user_' . $uid;
        }

        // Tạo và train model
        $estimator = new KNearestNeighbors(10, true, new Euclidean());
        $dataset = Labeled::build($dataset, $labels);
        $estimator->train($dataset);

        // Lưu model đã train
        $persister = new Filesystem(storage_path('app/' . self::MODEL_FILE));
        $model = new PersistentModel($estimator, $persister);
        $model->save();

        // Lưu metadata
        $metadata = [
            'scores' => $scores,
            'allProducts' => $allProducts,
            'trained_at' => now()->toDateTimeString(),
            'total_users' => count($scores),
            'total_products' => count($allProducts),
            'total_interactions' => array_sum(array_map('count', $scores))
        ];

        Storage::put(self::METADATA_FILE, json_encode($metadata));
        
        $this->info('Model trained and saved successfully!');
        $this->info("Total users: " . count($scores));
        $this->info("Total products: " . count($allProducts));
        $this->info("Total interactions: " . array_sum(array_map('count', $scores)));
    }

    private function shouldRetrain(): bool
    {
        // Nếu chưa có model, cần train
        if (!Storage::exists(self::METADATA_FILE)) {
            return true;
        }

        // Kiểm tra dữ liệu mới trong 1 phút qua
        $oneMinuteAgo = now()->subMinute();
        
        $newReviews = \App\Models\Review::where('created_at', '>=', $oneMinuteAgo)->count();
        $newViews = \App\Models\Viewed::where('created_at', '>=', $oneMinuteAgo)->count();
        $newFavorites = \App\Models\Favorite::where('created_at', '>=', $oneMinuteAgo)->count();
        $newOrders = \Illuminate\Support\Facades\DB::table('order_product')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', $oneMinuteAgo)
            ->count();

        $totalNewData = $newReviews + $newViews + $newFavorites + $newOrders;
        
        $this->info("New data in last 5 minutes: Reviews: $newReviews, Views: $newViews, Favorites: $newFavorites, Orders: $newOrders");
        
        return $totalNewData > 0;
    }
} 