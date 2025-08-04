<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the API endpoints and mobile app integration
    |
    */

    'version' => 'v1',
    'base_url' => env('APP_URL') . '/api/v1',
    
    'mobile_app' => [
        'name' => 'Ecommerce Mobile App',
        'version' => '1.0.0',
        'platform' => 'flutter',
    ],

    'pagination' => [
        'default_per_page' => 12,
        'max_per_page' => 50,
    ],

    'rate_limiting' => [
        'guest_requests_per_minute' => 30,
        'authenticated_requests_per_minute' => 60,
    ],

    'file_uploads' => [
        'max_size' => 5 * 1024 * 1024, // 5MB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif'],
        'storage_path' => 'public/uploads',
    ],

    'razorpay' => [
        'test_mode' => env('RAZORPAY_TEST_MODE', true),
        'currency' => 'INR',
    ],

    'cors' => [
        'allowed_origins' => ['*'],
        'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
        'allowed_headers' => ['*'],
        'exposed_headers' => [],
        'max_age' => 0,
        'supports_credentials' => false,
    ],
];