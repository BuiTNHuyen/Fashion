<?php

namespace App\Observers;

use App\Models\Review;
use App\Services\ProductRecommendationService;
use Illuminate\Support\Facades\Log;

class ReviewObserver
{
    public function created(Review $review)
    {
        // Train model khi có review mới
        $this->triggerAutoTrain();
    }

    public function updated(Review $review)
    {
        // Train model khi review được cập nhật
        $this->triggerAutoTrain();
    }

    public function deleted(Review $review)
    {
        // Train model khi review bị xóa
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