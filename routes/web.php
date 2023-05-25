<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\SiteController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\TopicController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\PageController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\ContactController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\CustomerController;
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
   // page
   Route::resource('page', PageController::class);
   Route::get('page_trash', [PageController::class, 'trash'])->name('page.trash');
   Route::prefix('page')->group(function () {
      Route::get('status/{page}', [PageController::class, 'status'])->name('page.status');
      Route::get('delete/{page}', [PageController::class, 'delete'])->name('page.delete');
      Route::get('restore/{page}', [PageController::class, 'restore'])->name('page.restore');
      Route::get('destroy/{page}', [PageController::class, 'destroy'])->name('page.destroy');
   });
   //menu
   Route::resource('menu', MenuController::class);
   route::get('menu_trash', [MenuController::class, 'trash'])->name('menu.trash');
   route::prefix('menu')->group(function () {
      route::get('status/{menu}', [MenuController::class, 'status'])->name('menu.status');
      route::get('delete/{menu}', [MenuController::class, 'delete'])->name('menu.delete');
      route::get('restore/{menu}', [MenuController::class, 'restore'])->name('menu.restore');
      route::get('destroy/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
   });

   //slider
   Route::resource('slider', SliderController::class);
   route::get('slider_trash', [SliderController::class, 'trash'])->name('slider.trash');
   route::prefix('slider')->group(function () {
      route::get('status/{slider}', [SliderController::class, 'status'])->name('slider.status');
      route::get('delete/{slider}', [SliderController::class, 'delete'])->name('slider.delete');
      route::get('restore/{slider}', [SliderController::class, 'restore'])->name('slider.restore');
      route::get('destroy/{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');
   });

   //product
   Route::resource('product', ProductController::class);
   route::get('product_trash', [ProductController::class, 'trash'])->name('product.trash');
   route::prefix('product')->group(function () {
      route::get('status/{product}', [ProductController::class, 'status'])->name('product.status');
      route::get('delete/{product}', [ProductController::class, 'delete'])->name('product.delete');
      route::get('restore/{product}', [ProductController::class, 'restore'])->name('product.restore');
      route::get('destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
   });

   //order
   Route::resource('order', OrderController::class);
   route::get('order_trash', [OrderController::class, 'trash'])->name('order.trash');
   route::prefix('order')->group(function () {
      route::get('status/{order}', [OrderController::class, 'status'])->name('order.status');
      route::get('delete/{order}', [OrderController::class, 'delete'])->name('order.delete');
      route::get('restore/{order}', [OrderController::class, 'restore'])->name('order.restore');
      route::get('destroy/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
   });

   //user
   Route::resource('user', UserController::class);
   route::get('user_trash', [UserController::class, 'trash'])->name('user.trash');
   route::prefix('user')->group(function () {
      route::get('status/{user}', [UserController::class, 'status'])->name('user.status');
      route::get('delete/{user}', [UserController::class, 'delete'])->name('user.delete');
      route::get('restore/{user}', [UserController::class, 'restore'])->name('user.restore');
      route::get('destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');
   });
   //customer
   Route::resource('customer', CustomerController::class);
   route::get('customer_trash', [CustomerController::class, 'trash'])->name('customer.trash');
   route::prefix('customer')->group(function () {
      route::get('status/{customer}', [CustomerController::class, 'status'])->name('customer.status');
      route::get('delete/{customer}', [CustomerController::class, 'delete'])->name('customer.delete');
      route::get('restore/{customer}', [CustomerController::class, 'restore'])->name('customer.restore');
      route::get('destroy/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
   });
   //contact
   Route::resource('contact', ContactController::class);
   route::get('contact_trash', [ContactController::class, 'trash'])->name('contact.trash');
   route::get('no_reply', [ContactController::class, 'noreply'])->name('contact.noreply');

   route::prefix('contact')->group(function () {
      // route::get('status/{contact}', [ContactController::class, 'status'])->name('contact.status');
      route::get('delete/{contact}', [ContactController::class, 'delete'])->name('contact.delete');
      route::get('restore/{contact}', [ContactController::class, 'restore'])->name('contact.restore');
      route::get('destroy/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');
   });


   Route::resource('product', ProductController::class);
});
