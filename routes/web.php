<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MainpageController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SettingsController;

// Public Routes
Route::get('/', [MainpageController::class, 'index'])->name('main.page');
Route::get('/home', [MainpageController::class, 'index'])->name('home');
Route::get('/products', [MainpageController::class, 'products'])->name('products');
Route::get('/contact', [MainpageController::class, 'contactform'])->name('contact');
Route::post('/contact', [MainpageController::class, 'contactstore'])->name('contact.store');
Route::get('/about', [MainpageController::class, 'about'])->name('about');
Route::get('/privacy-policy', [MainpageController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-conditions', [MainpageController::class, 'termsConditions'])->name('terms.conditions');
Route::get('/shipping-policy', [MainpageController::class, 'shippingPolicy'])->name('shipping.policy');
Route::get('/return-policy', [MainpageController::class, 'returnPolicy'])->name('return.policy');
Route::get('/size-guide', [MainpageController::class, 'sizeGuide'])->name('size.guide');
Route::get('/jewelry-care', [MainpageController::class, 'jewelryCare'])->name('jewelry.care');
Route::get('/blog', [MainpageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [MainpageController::class, 'blogPost'])->name('blog.post');
Route::get('/product/{product}', [MainpageController::class, 'productDetails'])->name('product.details');
Route::post('/product/inquiry', [ProductController::class, 'storeInquiry'])->name('product.inquiry');
Route::get('/product/{product}/review/create', [MainpageController::class, 'createReviewForm'])->name('product.review.create');
Route::post('/product/review', [MainpageController::class, 'submitReview'])->name('product.review');
Route::get('/filter-products', [MainpageController::class, 'filterProducts'])->name('filter.products');

// Cart Routes (Work for both guest and authenticated users)
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::patch('/cart/increase/{id}', [CartController::class, 'increaseQuantity'])->name('cart.increase');
Route::patch('/cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

// Wishlist Routes (Work for both guest and authenticated users)
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist/count', [WishlistController::class, 'getWishlistCount'])->name('wishlist.count');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Checkout Routes (Guest checkout allowed with restrictions)
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply.coupon');

// Payment Routes
Route::get('/razorpay-create-order', [RazorpayController::class, 'createOrder'])->name('razorpay.createOrder');
Route::post('/payment-success', [RazorpayController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/test-razorpay', [RazorpayController::class, 'testConfig'])->name('razorpay.test');

// Debug route for configuration (remove in production)
Route::get('/debug/config', function() {
    if (!env('APP_DEBUG', false)) {
        abort(404);
    }
    
    $config = [
        'app_debug' => env('APP_DEBUG', false),
        'razorpay_key_exists' => !empty(env('RAZORPAY_KEY')),
        'razorpay_secret_exists' => !empty(env('RAZORPAY_SECRET')),
        'razorpay_key_value' => env('RAZORPAY_KEY'),
        'is_placeholder_key' => env('RAZORPAY_KEY') === 'rzp_test_your_key_here',
        'is_placeholder_secret' => env('RAZORPAY_SECRET') === 'your_secret_here',
        'cart_session' => session('cart', []),
        'cart_count' => count(session('cart', [])),
    ];
    
    return response()->json($config, 200, [], JSON_PRETTY_PRINT);
})->name('debug.config');

// Order Routes (Requires authentication for viewing orders)
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [CheckoutController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [CheckoutController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{order}/reorder', [CheckoutController::class, 'reorder'])->name('orders.reorder');
    
    // Customer Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes (Protected by Auth and Admin Middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dash', [HomeController::class, 'index'])->name('dashboard');

    // Product Inquiries
    Route::get('/products/inquiries', [ProductController::class, 'showInquiries'])->name('admin.product.inquiries');
    Route::delete('/products/inquiries/{productInquiry}', [ProductController::class, 'destroyInquiry'])->name('admin.product.inquiry.destroy');

    // Product Management
    Route::prefix('product')->name('admin.product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Category Management
    Route::prefix('categories')->name('admin.category.')->group(function () {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('index');
        Route::get('/create', [ProductCategoryController::class, 'create'])->name('create');
        Route::post('/', [ProductCategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [ProductCategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [ProductCategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [ProductCategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [ProductCategoryController::class, 'destroy'])->name('destroy');
        Route::post('/{category}/toggle-status', [ProductCategoryController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/test/pagination', [ProductCategoryController::class, 'testPagination'])->name('test-pagination');
    });
    
    // Category AJAX routes
    Route::get('/categories/get-by-parent', [ProductCategoryController::class, 'getByParent'])->name('admin.category.getByParent');
    
    Route::resource('subcategory', SubcategoryController::class)->names('admin.subcategory');

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/reviews/export', [ReviewController::class, 'export'])->name('admin.reviews.export');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('admin.reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('admin.reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    // Orders Management
    Route::get('/orders', [OrdersController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [OrdersController::class, 'show'])->name('admin.orders.show');
    Route::delete('/orders/{id}', [OrdersController::class, 'destroy'])->name('admin.orders.destroy');
    Route::post('/orders/{id}/status', [OrdersController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/orders/export', [OrdersController::class, 'export'])->name('admin.orders.export');

    // Customer Management
    Route::prefix('customers')->name('admin.customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/groups', [CustomerController::class, 'groups'])->name('groups');
        Route::get('/export', [CustomerController::class, 'export'])->name('export');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
    });

    // Analytics
    Route::prefix('analytics')->name('admin.analytics.')->group(function () {
        Route::get('/sales', [AnalyticsController::class, 'sales'])->name('sales');
        Route::get('/products', [AnalyticsController::class, 'products'])->name('products');
        Route::get('/customers', [AnalyticsController::class, 'customers'])->name('customers');
    });

    // Settings
    Route::prefix('settings')->name('admin.settings.')->group(function () {
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::get('/payment', [SettingsController::class, 'payment'])->name('payment');
        Route::get('/email', [SettingsController::class, 'email'])->name('email');
    });
});

// Admin subcategories helper route
Route::get('/admin/subcategories/get-by-category', [SubcategoryController::class, 'getByCategory'])->name('admin.subcategory.getByCategory');
Route::get('/admin/subcategories/get-by-parent', [SubcategoryController::class, 'getSubcategoriesByParent'])->name('admin.subcategory.getByParent');

// API Routes for real-time order status updates
Route::get('/api/orders/{order}/status', function($orderId) {
    try {
        $order = \App\Models\Order::findOrFail($orderId);
        
        // Check if user is authorized to view this order
        if (auth()->check() && $order->user_id === auth()->id()) {
            return response()->json([
                'success' => true,
                'status' => $order->status,
                'updated_at' => $order->updated_at->format('Y-m-d H:i:s')
            ]);
        }
        
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Order not found'], 404);
    }
})->name('api.orders.status');

// Debug route for testing database connection
Route::get('/debug/categories', function() {
    try {
        $categories = \App\Models\ProductCategory::all();
        return response()->json([
            'success' => true,
            'count' => $categories->count(),
            'categories' => $categories->take(5)->toArray()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
})->name('debug.categories');
