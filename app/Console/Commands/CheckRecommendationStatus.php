<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Review;
use App\Models\Viewed;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class CheckRecommendationStatus extends Command
{
    protected $signature = 'recommendation:status';
    protected $description = 'Check the status of recommendation system';

    private const MODEL_FILE = 'recommendation_model.rbx';
    private const METADATA_FILE = 'recommendation_metadata.json';

    public function handle()
    {
        $this->info('=== Recommendation System Status ===');
        
        // Kiểm tra model file
        $modelPath = storage_path('app/' . self::MODEL_FILE);
        if (file_exists($modelPath)) {
            $this->info('✓ Model file exists: ' . self::MODEL_FILE);
            $this->info('  Size: ' . number_format(filesize($modelPath) / 1024, 2) . ' KB');
        } else {
            $this->error('✗ Model file not found: ' . self::MODEL_FILE);
        }

        // Kiểm tra metadata file
        if (Storage::exists(self::METADATA_FILE)) {
            $this->info('✓ Metadata file exists: ' . self::METADATA_FILE);
            $metadata = json_decode(Storage::get(self::METADATA_FILE), true);
            
            if ($metadata) {
                $this->info('  Last trained: ' . ($metadata['trained_at'] ?? 'Unknown'));
                $this->info('  Total users: ' . ($metadata['total_users'] ?? 'Unknown'));
                $this->info('  Total products: ' . ($metadata['total_products'] ?? 'Unknown'));
                $this->info('  Total interactions: ' . ($metadata['total_interactions'] ?? 'Unknown'));
            }
        } else {
            $this->error('✗ Metadata file not found: ' . self::METADATA_FILE);
        }

        // Thống kê dữ liệu hiện tại
        $this->info('');
        $this->info('=== Current Data Statistics ===');
        
        $totalReviews = Review::count();
        $totalViews = Viewed::count();
        $totalFavorites = Favorite::count();
        $totalOrders = DB::table('order_product')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.user_id', '!=', 0)
            ->count();

        $this->info("Total Reviews: $totalReviews");
        $this->info("Total Views: $totalViews");
        $this->info("Total Favorites: $totalFavorites");
        $this->info("Total Orders: $totalOrders");

        // Kiểm tra dữ liệu mới trong 1 phút qua
        $this->info('');
        $this->info('=== Recent Activity (Last 1 minute) ===');
        
        $oneMinuteAgo = now()->subMinute();
        
        $newReviews = Review::where('created_at', '>=', $oneMinuteAgo)->count();
        $newViews = Viewed::where('created_at', '>=', $oneMinuteAgo)->count();
        $newFavorites = Favorite::where('created_at', '>=', $oneMinuteAgo)->count();
        $newOrders = DB::table('order_product')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', $oneMinuteAgo)
            ->count();

        $this->info("New Reviews: $newReviews");
        $this->info("New Views: $newViews");
        $this->info("New Favorites: $newFavorites");
        $this->info("New Orders: $newOrders");

        $totalNewData = $newReviews + $newViews + $newFavorites + $newOrders;
        
        if ($totalNewData > 0) {
            $this->info("✓ New data detected - training will be triggered");
        } else {
            $this->info("✗ No new data - training will be skipped");
        }

        // Kiểm tra auto train
        $this->info('');
        $this->info('=== Auto Train Status ===');
        $this->info('Mode: Real-time (when new data detected)');
        $this->info('Status: Always enabled');
        
        $this->info('');
        $this->info('To manually train: php artisan recommendation:train --force');
    }
} 