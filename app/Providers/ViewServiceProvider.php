<?php

namespace App\Providers;

// Add these 'use' statements at the top
use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Using a closure based composer...
        // This tells Laravel to run this function every time the 'layout.header' view is rendered.
        View::composer('layout.header', function ($view) {
            $categories = ProductCategory::where('is_active', 1)
                                         ->where(function ($q) {
                                             $q->whereHas('products')
                                               ->orWhereHas('subcategories.products');
                                         })
                                         ->with(['subcategories' => function ($query) {
                                             $query->where('is_active', 1);
                                         }])
                                         ->orderBy('name', 'asc')
                                         ->get();

            $view->with('categories', $categories);
        });
    }
}