<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helper\CartHelper;
use App\Models\Category;

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
        view()->composer('*',function($view){
            $view->with([
                
                'cart'=> new CartHelper(),
            ]);
        });
    }
}
