<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Viewed;
use App\Models\Review;
use App\Models\Product;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\Kernels\Distance\Euclidean;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductRecommendationService
{
    private const MODEL_FILE = 'recommendation_model.rbx';
    private const METADATA_FILE = 'recommendation_metadata.json';


    private $kernel;
    private $model;
    private $metadata;

    public function __construct($loadModel = true)
    {
        $this->kernel = new Euclidean();
        if ($loadModel) {
            $this->loadModel();
        }
    }

    private function loadModel()
    {
        $modelPath = storage_path('app/' . self::MODEL_FILE);

        if (!file_exists($modelPath) || !Storage::exists(self::METADATA_FILE)) {
            throw new \Exception('Recommendation model not found. Please run php artisan recommendation:train first.');
        }

        // Load trained model
        $persister = new Filesystem($modelPath);
        $this->model = PersistentModel::load($persister);

        // Load metadata
        $this->metadata = json_decode(Storage::get(self::METADATA_FILE), true);
    }

    public function getRecommendations($userId, $limit = 15)
    {
        if (!isset($this->model) || !isset($this->metadata)) {
            throw new \Exception('Model not loaded. Please load model first.');
        }

        // Không có dữ liệu
        if (!isset($this->metadata['scores'][$userId])) {
            return collect();
        }

        // Tạo vector đặc trưng cho user hiện tại
        $userFeatures = [];
        foreach ($this->metadata['allProducts'] as $productId) {
            $userFeatures['product_' . $productId] = $this->metadata['scores'][$userId][$productId] ?? 0;
        }

        // Tính khoảng cách với tất cả users
        $distances = [];
        foreach ($this->metadata['scores'] as $uid => $scores) {
            if ($uid == $userId) continue;
            
            $otherFeatures = [];
            foreach ($this->metadata['allProducts'] as $productId) {
                $otherFeatures['product_' . $productId] = $scores[$productId] ?? 0;
            }
            
            $distance = $this->kernel->compute($userFeatures, $otherFeatures);
            $distances['user_' . $uid] = $distance;
        }

        // Sắp xếp theo khoảng cách và lấy 10 user gần nhất
        asort($distances);
        $similarUserIds = collect(array_slice($distances, 0, 10, true))
            ->keys()
            ->map(fn ($id) => (int) str_replace('user_', '', $id))
            ->values();

        // Lấy các sản phẩm của user tương tự mà user hiện tại chưa có
        $currentUserProducts = array_keys($this->metadata['scores'][$userId]);

        $recommendedProducts = collect();

        foreach ($similarUserIds as $simId) {
            foreach ($this->metadata['scores'][$simId] ?? [] as $pid => $score) {
                if (!in_array($pid, $currentUserProducts)) {
                    $recommendedProducts->push($pid);
                }
            }
        }

        return Product::whereIn('id', $recommendedProducts->unique()->take($limit))->get();
    }

    public function buildUserScores(int $userId): array
    {
        $scores = [];

        // Review (mặc định điểm là 3 nếu null)
        $reviews = Review::where('user_id', $userId)->get(['product_id', 'point']);
        foreach ($reviews as $review) {
            $scores[$review->product_id] = $review->point ?? 3;
        }

        // Viewed (mỗi lượt xem tăng 1)
        $vieweds = Viewed::where('user_id', $userId)->get(['product_id']);
        foreach ($vieweds as $viewed) {
            $scores[$viewed->product_id] = ($scores[$viewed->product_id] ?? 0) + 1;
        }

        // Favorite (mỗi yêu thích tăng 3)
        $favorites = Favorite::where('user_id', $userId)->pluck('product_id');
        foreach ($favorites as $productId) {
            $scores[$productId] = ($scores[$productId] ?? 0) + 3;
        }

        // Đã mua (mỗi sản phẩm mua tăng 2)
        $orders = DB::table('order_product')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userId)
            ->select('order_product.product_id')
            ->get();

        foreach ($orders as $order) {
            $scores[$order->product_id] = ($scores[$order->product_id] ?? 0) + 2;
        }

        return $scores;
    }

    public function hasEnoughRecommendationData(int $userId): bool
    {
        $userScores = $this->metadata['scores'][$userId] ?? $this->buildUserScores($userId);

        // Nếu không có bất kỳ tương tác nào
        if (empty($userScores)) return false;

        $interactedProducts = array_filter($userScores, fn ($score) => $score > 0);
        return count($interactedProducts) >= 1;
    }

    /**
     * Train model real-time khi có dữ liệu mới
     */
    public function autoTrainIfNeeded(): bool
    {
        // Kiểm tra dữ liệu mới trong 1 phút qua
        $oneMinuteAgo = now()->subMinute();
        
        $newReviews = Review::where('created_at', '>=', $oneMinuteAgo)->count();
        $newViews = Viewed::where('created_at', '>=', $oneMinuteAgo)->count();
        $newFavorites = Favorite::where('created_at', '>=', $oneMinuteAgo)->count();
        $newOrders = DB::table('order_product')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', $oneMinuteAgo)
            ->count();

        $totalNewData = $newReviews + $newViews + $newFavorites + $newOrders;
        
        if ($totalNewData > 0) {
            // Có dữ liệu mới, train model ngay lập tức
            $this->trainModel();
            return true;
        }

        return false;
    }

    /**
     * Train model ngay lập tức
     */
    public function trainModel(): void
    {
        // Lấy dữ liệu và train model
        $scores = [];
        
        // Đánh giá
        foreach (Review::all() as $review) {
            $scores[$review->user_id][$review->product_id] = $review->point ?? 3;
        }

        // Đã xem
        foreach (Viewed::all() as $viewed) {
            $scores[$viewed->user_id][$viewed->product_id] = ($scores[$viewed->user_id][$viewed->product_id] ?? 0) + 1;
        }

        // Yêu thích
        foreach (Favorite::all() as $favorite) {
            $scores[$favorite->user_id][$favorite->product_id] = ($scores[$favorite->user_id][$favorite->product_id] ?? 0) + 3;
        }

        // Đã mua
        $orders = DB::table('order_product')
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

        // Reload model và metadata
        $this->loadModel();
    }
}
