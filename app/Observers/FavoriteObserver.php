<?php

namespace App\Observers;

use App\Models\Favorite;
use App\Services\ProductRecommendationService;
use Illuminate\Support\Facades\Log;

class FavoriteObserver
{
    public function created(Favorite $favorite)
    {
        // Train model khi có yêu thích mới
        $this->triggerAutoTrain();
    }

    public function updated(Favorite $favorite)
    {
        // Train model khi yêu thích được cập nhật
        $this->triggerAutoTrain();
    }

    public function deleted(Favorite $favorite)
    {
        // Train model khi yêu thích bị xóa
        $this->triggerAutoTrain();
    }

    private function triggerAutoTrain()
    {
        try {
            $recommendationService = new ProductRecommendationService();
            $recommendationService->autoTrainIfNeeded();
        } catch (\Exception $e) {
            // Log lỗi nhưng không làm crash ứng dụng
            Log::error('Auto train failed: ' . $e->getMessage());
        }
    }
} 