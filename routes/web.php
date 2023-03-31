<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\SiteController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ProductController;
use Illuminate\Routing\RouteGroup;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [SiteController::class, 'index'])->name('site.home');
//Route::get('/greeting', function () {
   // return "Thong bao";
//});
// Khai bao route cho trang quan ly
Route::prefix('admin')->group(function(){
   Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard');
   Route::resource('brand', BrandController::class);
   Route::resource('category', CategoryController::class);
   Route::resource('product', ProductController::class);
});