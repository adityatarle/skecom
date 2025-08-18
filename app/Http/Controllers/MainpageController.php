<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\ProductCategory;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class MainpageController extends Controller
{

    public function header()
    {
        $categories = ProductCategory::with('subcategories')->get();
        return view('layout.header', compact('categories'));
    }


    public function index(Request $request)
    {
        // Fetch all products
        $products = Product::all();

        // Fetch only categories that have at least one product (and are active)
        $categories = ProductCategory::active()
            ->whereHas('products')
            ->get();

        // Organize products by category (for easier display in tabs)
        $productsByCategory = [];
        foreach ($categories as $category) {
            $productsByCategory[$category->name] = $products->where('category_id', $category->id);
        }

        // Separate All products for All Tab
        $productsByCategory['All'] = $products;

        // Fetch latest products
        $latestProducts = Product::latest()->take(6)->get();

        // Fetch approved reviews for all products, grouped by product_id
        $reviews = Review::where('is_approved', true)->get()->groupBy('product_id');


        return view('welcome', [
            'productsByCategory' => $productsByCategory,
            'categories' => $categories,
            'latestProducts' => $latestProducts,
            'reviews' => $reviews, // Pass reviews to view
        ]);
    }

    public function productDetails(Product $product)
    {
        // Fetch related products (same category, excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Fetch pricing breakup
        $pricingBreakup = $product->getPricingBreakup();

        // Fetch approved reviews for this product
        $reviews = Review::where('product_id', $product->id)
            ->where('is_approved', true)
            ->get();

        return view('product.details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'pricingBreakup' => $pricingBreakup, // ✅ Pass it to the view
        ]);
    }


    public function createReviewForm(Product $product)
    {
        return view('product.review-form', ['product' => $product]);
    }

    public function submitReview(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'review_text' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'uploads/' . $imageName;
            $image->move(public_path('uploads'), $imageName);
        }

        Review::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'review_text' => $request->review_text,
            'image_path' => $imagePath,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Your review is awaiting approval');
    }





    public function products(Request $request)
    {
        $category = $request->input('category');
        $subcategory = $request->input('subcategory');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        $products = Product::when($category && $category != 'all', function ($query) use ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        })
            ->when($subcategory, function ($query) use ($subcategory) {
                $query->whereHas('subcategory', function ($q) use ($subcategory) {
                    $q->where('name', $subcategory);
                });
            })
            ->when($min_price !== null && $max_price !== null, function ($query) use ($min_price, $max_price) {
                $query->where('price', '>=', $min_price)
                    ->where('price', '<=', $max_price);
            })
            ->get();

        // Only show categories that have at least one product (and are active)
        $categories = ProductCategory::active()
            ->whereHas('products')
            ->get();

        if ($request->ajax()) {
            return view('partials.product_grid', ['products' => $products])->render();
        }

        return view('products', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }


    public function contactform() {

        return view('contact');
    }

    public function contactstore() {

        return view('contact');
    }

    public function about() {
        return view('about');
    }

    public function privacyPolicy() {
        return view('privacy-policy');
    }

    public function termsConditions() {
        return view('terms-conditions');
    }

    public function shippingPolicy() {
        return view('shipping-policy');
    }

    public function returnPolicy() {
        return view('return-policy');
    }

    public function sizeGuide() {
        return view('size-guide');
    }

    public function jewelryCare() {
        return view('jewelry-care');
    }

    public function blog() {
        return view('blog.index');
    }

    public function blogPost($slug) {
        return view('blog.post', ['slug' => $slug]);
    }

    }

