<?php

namespace App\Observers;

use App\Models\Viewed;
use App\Services\ProductRecommendationService;
use Illuminate\Support\Facades\Log;

class ViewedObserver
{
    public function created(Viewed $viewed)
    {
        // Train model khi có lượt xem mới
        $this->triggerAutoTrain();
    }

    public function updated(Viewed $viewed)
    {
        // Train model khi lượt xem được cập nhật
        $this->triggerAutoTrain();
    }

    public function deleted(Viewed $viewed)
    {
        // Train model khi lượt xem bị xóa
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