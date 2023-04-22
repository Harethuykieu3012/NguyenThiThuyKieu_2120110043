<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\SiteController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\TopicController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ProductController;
use Illuminate\Routing\RouteGroup;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [SiteController::class, 'index'])->name('site.home');
//Route::get('/greeting', function () {
// return "Thong bao";
//});
// Khai bao route cho trang quan ly
Route::prefix('admin')->group(function () {
   Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
   // Category
   Route::resource('category', CategoryController::class);
   Route::get('category_trash', [CategoryController::class, 'trash'])->name('category.trash');
   Route::prefix('admin')->group(function () {
      Route::get('status/{category}', [CategoryController::class, 'status'])->name('category.status');
      Route::get('delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');
      Route::get('restore/{category}', [CategoryController::class, 'restore'])->name('category.restore');
      Route::get('destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
   });
   // brand
   Route::resource('brand', BrandController::class);
   Route::get('brand_trash', [BrandController::class, 'trash'])->name('brand.trash');
   Route::prefix('brand')->group(function () {
      Route::get('status/{brand}', [BrandController::class, 'status'])->name('brand.status');
      Route::get('delete/{brand}', [BrandController::class, 'delete'])->name('brand.delete');
      Route::get('restore/{brand}', [BrandController::class, 'restore'])->name('brand.restore');
      Route::get('destroy/{brand}', [BrandController::class, 'destroy'])->name('brand.destroy');
   });
   // topic
   Route::resource('topic', TopicController::class);
   Route::get('topic_trash', [TopicController::class, 'trash'])->name('topic.trash');
   Route::prefix('topic')->group(function () {
      Route::get('status/{topic}', [TopicController::class, 'status'])->name('topic.status');
      Route::get('delete/{topic}', [TopicController::class, 'delete'])->name('topic.delete');
      Route::get('restore/{topic}', [TopicController::class, 'restore'])->name('topic.restore');
      Route::get('destroy/{topic}', [TopicController::class, 'destroy'])->name('topic.destroy');
   });   
   // post
   Route::resource('post', PostController::class);
   Route::get('post_trash', [PostController::class, 'trash'])->name('post.trash');
   Route::prefix('post')->group(function () {
      Route::get('status/{post}', [PostController::class, 'status'])->name('post.status');
      Route::get('delete/{post}', [PostController::class, 'delete'])->name('post.delete');
      Route::get('restore/{post}', [PostController::class, 'restore'])->name('post.restore');
      Route::get('destroy/{post}', [PostController::class, 'destroy'])->name('post.destroy');
   });


   Route::resource('product', ProductController::class);
});
