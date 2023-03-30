<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\SiteController;

Route::get('/', [SiteController::class, 'index']);
//Route::get('/greeting', function () {
   // return "Thong bao";
//});
