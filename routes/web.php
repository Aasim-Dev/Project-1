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
});

Route::middleware(['auth', 'role:Publisher'])->group(function(){
    Route::get('/publisher/dashboard', [PublisherController::class, 'index'])->name('publisher.dashboard');
    Route::post('/admin/posts/store', [PublisherController::class, 'storePosts'])->name('publisher.post.store');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
//Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/admin/categories/list', [AdminController::class, 'list'])->name('categories.list');
Route::get('/publisher/posts/list', [PublisherController::class, 'list'])->name('posts.list'); 
Route::get('/admin/post/index', [AdminController::class, 'post'])->name('post.index');


