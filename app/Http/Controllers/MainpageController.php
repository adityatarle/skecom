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

        // Fetch all product categories
        $categories = ProductCategory::all();

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
        // Get filter parameters
        $category = $request->input('category');
        $subcategory = $request->input('subcategory');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');
        $search = $request->input('search');
        $sort = $request->input('sort', 'latest'); // default sort

        // Start building the query
        $query = Product::with(['category', 'subcategory', 'images']);

        // Apply category filter
        if ($category && $category !== 'all') {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }

        // Apply subcategory filter
        if ($subcategory && $subcategory !== 'all') {
            $query->whereHas('subcategory', function ($q) use ($subcategory) {
                $q->where('name', $subcategory);
            });
        }

        // Apply price range filter
        if ($min_price !== null && $min_price !== '') {
            $query->where('price', '>=', (float) $min_price);
        }
        if ($max_price !== null && $max_price !== '') {
            $query->where('price', '<=', (float) $max_price);
        }

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function ($catQuery) use ($search) {
                      $catQuery->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('subcategory', function ($subQuery) use ($search) {
                      $subQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        // Get products with pagination
        $products = $query->paginate(12);

        // Get categories with subcategories for the sidebar
        $categories = ProductCategory::with('subcategories')->get();

        // Get price range for slider
        $priceRange = Product::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();
        $minPrice = $priceRange->min_price ?? 0;
        $maxPrice = $priceRange->max_price ?? 10000;

        // If AJAX request, return only the product grid
        if ($request->ajax()) {
            return view('partials.product_grid', compact('products'))->render();
        }

        // Return full view with all data
        return view('products', compact(
            'products',
            'categories',
            'minPrice',
            'maxPrice',
            'category',
            'subcategory',
            'min_price',
            'max_price',
            'search',
            'sort'
        ));
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

    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        if (!$categoryId) {
            return response()->json([]);
        }

        $subcategories = Subcategory::where('category_id', $categoryId)->get(['id', 'name']);
        
        return response()->json($subcategories);
    }

    }

