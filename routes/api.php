<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\MainController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes
Route::prefix('v1')->group(function () {
    
    // Authentication Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    
    // Public Product Routes
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::get('/products/search', [ProductController::class, 'search']);
    Route::get('/products/filter', [ProductController::class, 'filter']);
    
    // Public Category Routes
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::get('/categories/{category}/products', [CategoryController::class, 'products']);
    
    // Public Main Routes
    Route::get('/home', [MainController::class, 'home']);
    Route::get('/about', [MainController::class, 'about']);
    Route::get('/contact', [MainController::class, 'contact']);
    Route::post('/contact', [MainController::class, 'contactStore']);
    Route::get('/privacy-policy', [MainController::class, 'privacyPolicy']);
    Route::get('/terms-conditions', [MainController::class, 'termsConditions']);
    Route::get('/shipping-policy', [MainController::class, 'shippingPolicy']);
    Route::get('/return-policy', [MainController::class, 'returnPolicy']);
    
    // Guest Cart Routes (Session-based)
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart']);
    Route::patch('/cart/update/{id}', [CartController::class, 'updateQuantity']);
    Route::delete('/cart/clear', [CartController::class, 'clearCart']);
    Route::get('/cart/count', [CartController::class, 'getCount']);
    
    // Guest Wishlist Routes (Session-based)
    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist']);
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove']);
    Route::get('/wishlist/count', [WishlistController::class, 'getCount']);
    
    // Payment Routes
    Route::post('/payment/create-order', [PaymentController::class, 'createOrder']);
    Route::post('/payment/verify', [PaymentController::class, 'verifyPayment']);
    
    // Protected Routes (Require Authentication)
    Route::middleware('auth:sanctum')->group(function () {
        
        // User Profile Routes
        Route::get('/user/profile', [UserController::class, 'profile']);
        Route::put('/user/profile', [UserController::class, 'updateProfile']);
        Route::post('/user/change-password', [UserController::class, 'changePassword']);
        Route::post('/user/logout', [AuthController::class, 'logout']);
        
        // Authenticated Cart Routes (Database-based)
        Route::post('/user/cart/add', [CartController::class, 'addToUserCart']);
        Route::get('/user/cart', [CartController::class, 'userCart']);
        Route::delete('/user/cart/remove/{id}', [CartController::class, 'removeFromUserCart']);
        Route::patch('/user/cart/update/{id}', [CartController::class, 'updateUserCartQuantity']);
        Route::delete('/user/cart/clear', [CartController::class, 'clearUserCart']);
        
        // Authenticated Wishlist Routes (Database-based)
        Route::post('/user/wishlist/add', [WishlistController::class, 'addToUserWishlist']);
        Route::get('/user/wishlist', [WishlistController::class, 'userWishlist']);
        Route::delete('/user/wishlist/remove/{productId}', [WishlistController::class, 'removeFromUserWishlist']);
        
        // Order Routes
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder']);
        Route::get('/orders/{order}/track', [OrderController::class, 'track']);
        
        // Review Routes
        Route::get('/reviews', [ReviewController::class, 'index']);
        Route::post('/reviews', [ReviewController::class, 'store']);
        Route::put('/reviews/{review}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
        
        // Product Inquiry Routes
        Route::post('/products/{product}/inquiry', [ProductController::class, 'storeInquiry']);
        
    });
    
    // Admin Routes (Require Admin Role)
    Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
        
        // Admin Dashboard
        Route::get('/dashboard', [MainController::class, 'adminDashboard']);
        
        // Admin Product Management
        Route::get('/products', [ProductController::class, 'adminIndex']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
        
        // Admin Order Management
        Route::get('/orders', [OrderController::class, 'adminIndex']);
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus']);
        Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
        
        // Admin User Management
        Route::get('/users', [UserController::class, 'adminIndex']);
        Route::get('/users/{user}', [UserController::class, 'adminShow']);
        
    });
    
});

// Health Check Route
Route::get('/health', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API is running',
        'timestamp' => now()->toISOString()
    ]);
});