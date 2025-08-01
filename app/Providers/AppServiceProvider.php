<?php

 namespace App\Providers;

 use App\Models\ProductCategory;
 use Illuminate\Support\Facades\View;
 use Illuminate\Pagination\Paginator; // <--- MAKE SURE TO ADD THIS "use" STATEMENT
 use Illuminate\Support\ServiceProvider;

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
         View::composer('*', function ($view) {
             $categories = ProductCategory::all();
             $view->with('categories', $categories);
         });


         // Add this line to tell Laravel to use Bootstrap 5 for pagination links
        Paginator::useBootstrapFive();
     }
 }