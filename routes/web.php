<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\PublisherController;

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

Route::get('/', function () {

    // $user = User::where('id', 1)-> first();
    // dd($user);
    return view('welcome');

   
});

Route::middleware(['auth', 'role:Admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/category/store', [AdminController::class, 'storeCategory'])->name('admin.category.store');
    Route::post('/admin/post/store', [AdminController::class, 'post'])->name('admin.post.store');
    Route::delete('/admin/category/destroy', [AdminController::class, 'destroy'])->name('admin.category.delete');
});

Route::middleware(['auth', 'role:Advertiser'])->group(function(){
    Route::get('/advertiser/dashboard', [AdvertiserController::class, 'index'])->name('advertiser.dashboard');
    Route::post('/advertiser/orders/store', [AdvertiserController::class, 'storeOrder'])->name('order.store');
    Route::post('/cart/toggleCart', [AdvertiserController::class, 'toggleCart'])->name('cart.toggle');
    Route::get('/cart/count', [AdvertiserController::class, 'cartCount'])->name('cart.count');
    
});

Route::middleware(['auth', 'role:Publisher'])->group(function(){
    Route::get('/publisher/dashboard', [PublisherController::class, 'index'])->name('publisher.dashboard');
    Route::post('/publisher/website/store', [PublisherController::class, 'storePosts'])->name('publisher.website.store');
    Route::post('/publisher/website/create', [PublisherController::class, 'create'])->name('publisher.website.create');
    Route::delete('/publisher/website/destroy', [PublisherController::class, 'destroy'])->name('publisher.website.delete');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
//Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//AdminController Routes
Route::get('/admin/categories/list', [AdminController::class, 'list'])->name('categories.list');
Route::get('/admin/post/index', [AdminController::class, 'post'])->name('post.index');
Route::get('/admin/orders/list', [AdminController::class, 'showOrders'])->name('order.list');

//PublisherController Routes
Route::get('/publisher/website/list', [PublisherController::class, 'list'])->name('website.list');
Route::get('publisher/website/create', [PublisherController::class, 'create'])->name('website.create');

//AdvertiserController Routes
Route::get('/advertiser/orders/list', [AdvertiserController::class, 'show'])->name('orders.list');
Route::get('/advertiser/orders/create', [AdvertiserController::class, 'create'])->name('orders.create');
Route::get('/advertiser/cart/cartItems', [AdvertiserController::class, 'cartItems'])->name('cart.cartItems');
Route::get('/advertiser/website/list', [AdvertiserController::class, 'showWebsite'])->name('website.lists');


//route for category type::
Route::get('/categories-by-type', [PublisherController::class, 'getCategoriesByType'])->name('categories-by-type');
Route::get('/cart-websites', [AdvertiserController::class, 'getCartWebsites'])->name('website.cart');

//route for the categories to show dynamically.
//Route::get('/publisher/website/create', [PublisherController::class, 'showCategories']);
