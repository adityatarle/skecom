<?php

namespace App\Providers;

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
        View::composer('layout.header', function ($view) {
            // The query is now simplified.
            // 1. Get all parent categories that are active.
            // 2. For each of those, simply load all of their subcategories.
            $categories = ProductCategory::where('is_active', 1)
                                         ->with('subcategories') // <-- MODIFIED: We removed the extra filter condition
                                         ->orderBy('name', 'asc')
                                         ->get();
                                         
            // This makes the $categories variable available inside the view.
            $view->with('categories', $categories);
        });
    }
}