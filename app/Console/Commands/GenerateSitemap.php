<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Subcategory;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate XML sitemap for the website';

    public function handle()
    {
        $this->info('Generating sitemap...');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Add static pages
        $staticPages = [
            '' => '1.0',
            'about' => '0.8',
            'products' => '0.9',
            'contact' => '0.7',
            'privacy-policy' => '0.5',
            'terms-conditions' => '0.5',
            'shipping-policy' => '0.5',
            'return-policy' => '0.5',
            'size-guide' => '0.6',
            'jewelry-care' => '0.6',
            'blog' => '0.7',
        ];

        foreach ($staticPages as $page => $priority) {
            $xml .= $this->addUrl(url($page), $priority, 'weekly');
        }

        // Add product categories
        $categories = ProductCategory::all();
        foreach ($categories as $category) {
            $xml .= $this->addUrl(url('products?category=' . urlencode($category->name)), '0.8', 'weekly');
        }

        // Add subcategories
        $subcategories = Subcategory::all();
        foreach ($subcategories as $subcategory) {
            $xml .= $this->addUrl(url('products?subcategory=' . urlencode($subcategory->name)), '0.8', 'weekly');
        }

        // Add individual products
        $products = Product::all();
        foreach ($products as $product) {
            $xml .= $this->addUrl(url('product/' . $product->id), '0.9', 'monthly');
        }

        $xml .= '</urlset>';

        // Save sitemap
        File::put(public_path('sitemap.xml'), $xml);

        $this->info('Sitemap generated successfully at: ' . public_path('sitemap.xml'));
        $this->info('Total URLs: ' . (count($staticPages) + $categories->count() + $subcategories->count() + $products->count()));
    }

    private function addUrl($url, $priority, $changefreq)
    {
        return "  <url>\n" .
               "    <loc>" . $url . "</loc>\n" .
               "    <lastmod>" . now()->toISOString() . "</lastmod>\n" .
               "    <changefreq>" . $changefreq . "</changefreq>\n" .
               "    <priority>" . $priority . "</priority>\n" .
               "  </url>\n";
    }
}