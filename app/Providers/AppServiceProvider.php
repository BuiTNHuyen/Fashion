<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Product;
use App\Models\Review;
use App\Models\Viewed;
use App\Models\Favorite;
use App\Models\Order;
use App\Observers\ReviewObserver;
use App\Observers\ViewedObserver;
use App\Observers\FavoriteObserver;
use App\Observers\OrderObserver;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();

        // Đăng ký observers cho auto train
        Review::observe(ReviewObserver::class);
        Viewed::observe(ViewedObserver::class);
        Favorite::observe(FavoriteObserver::class);
        Order::observe(OrderObserver::class);
    }
}
