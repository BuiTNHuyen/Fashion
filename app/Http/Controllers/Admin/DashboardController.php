<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'total_product' => Product::count(),
            'total_order' => Order::count(),
        ];

        $data['total_income'] = Order::where('status', 4)->sum('total_price');

        // /* Xử lý lấy data cho Bar chart */
        $currentYear = date('Y');
        $currentMonth = $request->month ?? date('m');

        $totalSalesByDay = DB::table('orders')
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('SUM(total_price) as total_price'))
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('day')
            ->get()
            ->pluck('total_price', 'day')
            ->toArray();
        
        // Xử lý để thêm các ngày không có đơn hàng vào mảng
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            if (!array_key_exists($day, $totalSalesByDay)) {
                $totalSalesByDay[$day] = 0;
            }
        }

        ksort($totalSalesByDay);

        $bestSellingProducts = Product::orderByDesc('sold')->where('sold', '>', 0)->get()->take(10);

        $latestOrders = Order::orderByDesc('id')->get()->take(10);

        // Top sản phẩm được yêu thích
        $topLikedProduct_ids = Favorite::select('product_id', DB::raw('COUNT(*) as like_count'))
            ->groupBy('product_id')
            ->orderByDesc('like_count')
            ->limit(10)
            ->get();

        $topLikedProducts= [];
        foreach ($topLikedProduct_ids as $item) {
            $product = Product::select('id', 'name')->where('id', $item->product_id)->first();

            if ($product) {
                $product->like_count = $item->like_count;
                $topLikedProducts[] = $product;
            }
        }

        // Top sản phẩm được chấm điểm cao
        $topPointProduct_ids = Review::select('product_id', DB::raw('AVG(point) as avg_point'))
            ->groupBy('product_id')
            ->orderByDesc('avg_point')
            ->limit(10)
            ->get();

        $topPointProducts= [];
        foreach ($topPointProduct_ids as $item) {
            $product = Product::select('id', 'name')->where('id', $item->product_id)->first();

            if ($product) {
                $product->avg_point = $item->avg_point;
                $topPointProducts[] = $product;
            }
        }
        return view('admin.index', compact('totalSalesByDay','data','bestSellingProducts','latestOrders', 'topLikedProducts','topPointProducts'));
    }

} /*php*/
