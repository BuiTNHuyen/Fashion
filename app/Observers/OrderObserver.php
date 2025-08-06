<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\ProductRecommendationService;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    public function created(Order $order)
    {
        // Train model khi có đơn hàng mới
        $this->triggerAutoTrain();
    }

    public function updated(Order $order)
    {
        // Train model khi đơn hàng được cập nhật
        $this->triggerAutoTrain();
    }

    public function deleted(Order $order)
    {
        // Train model khi đơn hàng bị xóa
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