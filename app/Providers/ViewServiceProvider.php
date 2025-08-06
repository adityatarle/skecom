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
                                         ->with(['subcategories' => function ($query) {
                                             $query->where('is_active', 1); // Also get only active subcategories
                                         }])
                                         ->orderBy('name', 'asc')
                                         ->get();
                                         
            // This makes the $categories variable available inside the view.
            $view->with('categories', $categories);
        });
    }
}