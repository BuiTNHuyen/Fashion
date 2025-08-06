<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OriginController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostTypeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ContactController;

use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\AuthUserController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\FavoriteController;
use App\Http\Controllers\Frontend\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Admin
Route::prefix('admin')->group(function () {
    //Auth
    Route::get('/', function(){
        return redirect()->route('admin.login');
    });
    Route::get('/login', [AuthController::class, 'login'])->middleware(['guest:admin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'loginPost'])->middleware(['guest:admin'])->name('admin.loginPost');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'] )->name('admin.dashboard');

        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/change-password', [AuthController::class, 'password'])->name('admin.password');
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('admin.change-password');

        //Brand
        Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
        Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
        Route::post('/brand/create', [BrandController::class, 'store'])->name('brand.store');
        Route::get('/brand/edit/{brand}', [BrandController::class, 'edit'])->name('brand.edit');
        Route::post('/brand/edit/{brand}', [BrandController::class, 'update'])->name('brand.update');
        Route::delete('/brand/delete/{brand}', [BrandController::class, 'destroy'])->name('brand.destroy');

        //Origin
        Route::get('/origin', [OriginController::class, 'index'])->name('origin.index');
        Route::get('/origin/create', [OriginController::class, 'create'])->name('origin.create');
        Route::post('/origin/create', [OriginController::class, 'store'])->name('origin.store');
        Route::get('/origin/edit/{origin}', [OriginController::class, 'edit'])->name('origin.edit');
        Route::post('/origin/edit/{origin}', [OriginController::class, 'update'])->name('origin.update');
        Route::delete('/origin/delete/{origin}', [OriginController::class, 'destroy'])->name('origin.destroy');

        //Category
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/category/edit/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

        //Product
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::post('/product', [ProductController::class, 'index'])->name('product.search');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/create', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/product/edit/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/product/show/{product}', [ProductController::class, 'show'])->name('product.show');
        Route::delete('/product/delete/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

        //Order
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::get('/order/show/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/order/confirm/{order}', [OrderController::class, 'confirm'])->name('order.confirm');

        //User
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        //Staff
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff/create', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/edit/{staff}', [StaffController::class, 'edit'])->name('staff.edit');
        Route::post('/staff/edit/{staff}', [StaffController::class, 'update'])->name('staff.update');
        Route::get('/staff/destroy/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');

        //Post Type
        Route::get('/post_type', [PostTypeController::class, 'index'])->name('post_type.index');
        Route::get('/post_type/create', [PostTypeController::class, 'create'])->name('post_type.create');
        Route::post('/post_type/create', [PostTypeController::class, 'store'])->name('post_type.store');
        Route::get('/post_type/edit/{post_type}', [PostTypeController::class, 'edit'])->name('post_type.edit');
        Route::post('/post_type/edit/{post_type}', [PostTypeController::class, 'update'])->name('post_type.update');
        Route::delete('/post_type/delete/{post_type}', [PostTypeController::class, 'destroy'])->name('post_type.destroy');

        //Post
        Route::get('/post', [PostController::class, 'index'])->name('post.index');
        Route::post('/post', [PostController::class, 'index'])->name('post.search');
        Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/post/create', [PostController::class, 'store'])->name('post.store');
        Route::get('/post/edit/{post}', [PostController::class, 'edit'])->name('post.edit');
        Route::post('/post/edit/{post}', [PostController::class, 'update'])->name('post.update');
        Route::get('/post/show/{post}', [PostController::class, 'show'])->name('post.show');
        Route::delete('/post/delete/{post}', [PostController::class, 'destroy'])->name('post.destroy');

        //Contact
        Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts');
    });
    
});

//Frontend

Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/cua-hang', [ShopController::class, 'shop'])->name('shop');
Route::get('/danh-muc/{category}', [ShopController::class, 'getProductByCategory'])->name('category');
Route::get('/san-pham/{product}', [ShopController::class, 'product'])->name('product');
Route::get('/lien-he', [ShopController::class, 'contact'])->name('contact');
Route::post('/lien-he', [ShopController::class, 'sendContact'])->name('contact.send');
Route::get('/so-sanh', [ShopController::class, 'compare'])->name('compare');

//Blog
Route::get('/bai-viet', [BlogController::class, 'blog'])->name('blog');
Route::get('/bai-viet/{post}', [BlogController::class, 'blogDetail'])->name('blog.detail');

Route::get('/gio-hang', [CartController::class, 'cart'])->name('cart');
Route::get('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/increase/{product_id}', [CartController::class, 'increase'])->name('cart.increase');
Route::get('/cart/decrease/{product_id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::get('/cart/delete/{product_id}', [CartController::class, 'delete'])->name('cart.delete');

Route::get('/dat-hang', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkoutPost');
Route::get('/checkout/vnPayCheck', [CheckoutController::class, 'vnPayCheck'])->name('checkout.vnpay');


Route::middleware(['guest:web'])->group(function () {
    Route::get('/dang-nhap', [AuthUserController::class, 'login'])->name('login');
    Route::post('/dang-nhap', [AuthUserController::class, 'loginPost'])->name('loginPost');
    Route::get('/dang-ky', [AuthUserController::class, 'register'])->name('register');
    Route::post('/dang-ky', [AuthUserController::class, 'registerPost'])->name('registerPost');
});


Route::middleware(['auth:web'])->group(function () {
    Route::get('/dang-xuat', [AuthUserController::class, 'logout'])->name('logout');

    Route::get('/yeu-thich', [FavoriteController::class, 'index'])->name('favorite');
    Route::get('/yeu-thich/{product}', [FavoriteController::class, 'add'])->name('favorite.add');
    Route::get('/yeu-thich/delete/{product_id}', [FavoriteController::class, 'delete'])->name('favorite.delete');

    Route::get('/tai-khoan', [AccountController::class, 'account'])->name('account');
    Route::post('/tai-khoan', [AccountController::class, 'updateAccount'])->name('account.update');

    Route::get('/lich-su-don-hang', [AccountController::class, 'orderHistory'])->name('account.orderHistory');
    Route::get('/chi-tiet-don-hang/{order}', [AccountController::class, 'orderDetail'])->name('order.detail');
    Route::post('/order-history/cancel/{order}', [AccountController::class, 'cancel'])->name('order.cancel');
    Route::post('/order-history/receive/{order}', [AccountController::class, 'receive'])->name('order.receive');
    Route::post('/order-history/return/{order}', [AccountController::class, 'return'])->name('order.return');

    Route::get('/doi-mat-khau', [AccountController::class, 'changePassword'])->name('account.change-password');
    Route::post('/doi-mat-khau', [AccountController::class, 'updatePassword'])->name('account.update-password');

    Route::post('/review', [AccountController::class, 'review'])->name('review');

 
});

Route::fallback(function () {
    return view('frontend.404');
});