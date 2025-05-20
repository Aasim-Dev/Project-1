<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\RegisterController;

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

    return view('welcome');
   
});

Route::middleware(['auth', 'role:Admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/category/store', [AdminController::class, 'storeCategory'])->name('admin.category.store');
    Route::post('/admin/post/store', [AdminController::class, 'post'])->name('admin.post.store');
    Route::delete('/admin/category/destroy', [AdminController::class, 'destroy'])->name('admin.category.delete');
    Route::post('/admin/order/update-status', [AdminController::class, 'updateRequest'])->name('order.updateStatus');
});

Route::middleware(['auth', 'role:Advertiser', 'verified'])->group(function(){
    Route::get('/advertiser/dashboard', [AdvertiserController::class, 'index'])->name('advertiser.dashboard');
    Route::post('/advertiser/orders/store', [AdvertiserController::class, 'storeOrder'])->name('order.store');
    Route::post('/cart/toggleCart', [AdvertiserController::class, 'toggleCart'])->name('cart.toggle');
    Route::get('/cart/count', [AdvertiserController::class, 'cartCount'])->name('cart.count');
    Route::post('/orders/cancel', [AdvertiserController::class, 'cancelOrder'])->name('orders.cancel'); 
});

Route::middleware(['auth', 'role:Publisher', 'verified'])->group(function(){
    Route::get('/publisher/dashboard', [PublisherController::class, 'index'])->name('publisher.dashboard');
    Route::post('/publisher/website/store', [PublisherController::class, 'storePosts'])->name('website.store');
    Route::post('/publisher/website/create', [PublisherController::class, 'create'])->name('publisher.website.create');
    Route::delete('/publisher/website/destroy', [PublisherController::class, 'destroy'])->name('publisher.website.delete');
    Route::get('/publisher/orders', [PublisherController::class, 'showOrders'])->name('orders');
    Route::post('/publisher/order/update', [PublisherController::class, 'updateRequest'])->name('order.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/chat/messages/{user}', [ChatController::class, 'messages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
});

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
//Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register/partner', [RegisterController::class, 'showPartnerForm'])->name('partner.register');
Route::post('/register/partner/submit', [RegisterController::class, 'registerForm'])->name('register.partner');
Route::get('/register/email-verify', [RegisterController::class, 'registered']);

//AdminController Routes
Route::get('/admin/categories/list', [AdminController::class, 'list'])->name('categories.list');
Route::get('/admin/post/index', [AdminController::class, 'post'])->name('post.index');
Route::get('/admin/order/list', [AdminController::class, 'showOrders'])->name('order.list');
Route::post('/admin/order/data', [AdminController::class, 'orderData'])->name('adminsideorder.data');

//PublisherController Routes
Route::get('/publisher/website/list', [PublisherController::class, 'list'])->name('website.list');
Route::get('publisher/website/create', [PublisherController::class, 'create'])->name('website.create');
Route::post('publisher-orderData', [PublisherController::class, 'orderData'])->name('publisher.orderdata');

//AdvertiserController Routes
Route::get('/advertiser/orders/list', [AdvertiserController::class, 'show'])->name('orders.list');
Route::get('/advertiser/orders/create', [AdvertiserController::class, 'create'])->name('orders.create');
Route::get('/advertiser/cart/cartItems', [AdvertiserController::class, 'cartItems'])->name('cart.cartItems');
Route::get('/advertiser/website/list', [AdvertiserController::class, 'showWebsite'])->name('website.lists');
Route::get('/advertiser/partner/api', [AdvertiserController::class, 'apiPage'])->name('api');
Route::get('/advertiser/dashboard', [WalletController::class, 'index'])->name('advertiser.dashboard');
Route::post('/add/funds', [WalletController::class, 'addFunds'])->name('add-funds');
Route::post('/wallet/paypal', [WalletController::class, 'handlePayPalPayment'])->name('wallet.paypal');
Route::get('/wallet/paypal/success', [WalletController::class, 'handlePayPalSuccess'])->name('wallet.paypal.success');
Route::get('/wallet/paypal/cancel', [WalletController::class, 'handlePayPalCancel'])->name('wallet.paypal.cancel');


//route for category type::
    Route::get('/categories-by-type', [PublisherController::class, 'getCategoriesByType'])->name('categories-by-type');
    Route::get('/cart-websites', [AdvertiserController::class, 'getCartWebsites'])->name('website.cart');
    
    //route for CartController
    Route::post('/cart/update', [CartController::class, 'storeProvideContent'])->name('cart.content');
    Route::post('/cart/linkInsertion', [CartController::class, 'linkInsertion'])->name('cart.link');
    Route::post('/cart/hire', [CartController::class, 'hireContent'])->name('cart.hire');
    
    //route for the categories to show dynamically.
    //Route::get('/publisher/website/create', [PublisherController::class, 'showCategories']);

//MarkeplaceController Routes 
Route::post('/website/data', [MarketplaceController::class, 'websiteData'])->name('dataTable');
Route::post('/advertiser/website/data', [OrderController::class, 'orderData'])->name('order.data');