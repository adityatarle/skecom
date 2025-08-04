# API Setup Guide for Mobile Application

## Overview

This guide will help you set up and integrate the ecommerce API with your mobile application. The API provides comprehensive functionality for user authentication, product management, cart operations, order processing, and payment integration.

## Prerequisites

- Laravel 10+ application
- PHP 8.1+
- MySQL/PostgreSQL database
- Composer
- Laravel Sanctum package
- Razorpay PHP SDK (for payments)

## Installation Steps

### 1. Install Laravel Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### 2. Install Razorpay SDK

```bash
composer require razorpay/razorpay
```

### 3. Configure Environment Variables

Add the following to your `.env` file:

```env
# API Configuration
API_BASE_URL=https://yourdomain.com/api/v1

# Razorpay Configuration
RAZORPAY_KEY=rzp_test_your_key_here
RAZORPAY_SECRET=your_secret_here

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# App Configuration
APP_NAME="Your Store Name"
APP_ENV=local
APP_KEY=base64:your_app_key
APP_DEBUG=true
APP_URL=http://localhost

# Mail Configuration (for password reset)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Register Middleware

Add the admin middleware to `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    // ... other middlewares
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];
```

### 6. Configure CORS (if needed)

Update `config/cors.php` for mobile app access:

```php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

## API Integration in Mobile App

### 1. Base Configuration

Create an API service class in your mobile app:

```dart
// Flutter/Dart Example
class ApiService {
  static const String baseUrl = 'https://yourdomain.com/api/v1';
  static String? authToken;

  static Map<String, String> get headers {
    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    
    if (authToken != null) {
      headers['Authorization'] = 'Bearer $authToken';
    }
    
    return headers;
  }
}
```

### 2. Authentication Service

```dart
class AuthService {
  static Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('${ApiService.baseUrl}/login'),
      headers: ApiService.headers,
      body: jsonEncode({
        'email': email,
        'password': password,
      }),
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      ApiService.authToken = data['data']['token'];
      return data['data'];
    } else {
      throw Exception('Login failed');
    }
  }

  static Future<Map<String, dynamic>> register(Map<String, dynamic> userData) async {
    final response = await http.post(
      Uri.parse('${ApiService.baseUrl}/register'),
      headers: ApiService.headers,
      body: jsonEncode(userData),
    );

    if (response.statusCode == 201) {
      final data = jsonDecode(response.body);
      ApiService.authToken = data['data']['token'];
      return data['data'];
    } else {
      throw Exception('Registration failed');
    }
  }

  static Future<void> logout() async {
    await http.post(
      Uri.parse('${ApiService.baseUrl}/user/logout'),
      headers: ApiService.headers,
    );
    ApiService.authToken = null;
  }
}
```

### 3. Product Service

```dart
class ProductService {
  static Future<List<Product>> getProducts({
    int page = 1,
    int perPage = 12,
    String? sortBy,
    String? sortOrder,
  }) async {
    final queryParams = {
      'page': page.toString(),
      'per_page': perPage.toString(),
    };

    if (sortBy != null) queryParams['sort_by'] = sortBy;
    if (sortOrder != null) queryParams['sort_order'] = sortOrder;

    final uri = Uri.parse('${ApiService.baseUrl}/products')
        .replace(queryParameters: queryParams);

    final response = await http.get(uri, headers: ApiService.headers);

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return (data['data']['products'] as List)
          .map((product) => Product.fromJson(product))
          .toList();
    } else {
      throw Exception('Failed to load products');
    }
  }

  static Future<Product> getProduct(int id) async {
    final response = await http.get(
      Uri.parse('${ApiService.baseUrl}/products/$id'),
      headers: ApiService.headers,
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return Product.fromJson(data['data']['product']);
    } else {
      throw Exception('Failed to load product');
    }
  }

  static Future<List<Product>> searchProducts(String query) async {
    final uri = Uri.parse('${ApiService.baseUrl}/products/search')
        .replace(queryParameters: {'query': query});

    final response = await http.get(uri, headers: ApiService.headers);

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return (data['data']['products'] as List)
          .map((product) => Product.fromJson(product))
          .toList();
    } else {
      throw Exception('Search failed');
    }
  }
}
```

### 4. Cart Service

```dart
class CartService {
  static Future<void> addToCart(int productId, int quantity) async {
    final response = await http.post(
      Uri.parse('${ApiService.baseUrl}/user/cart/add'),
      headers: ApiService.headers,
      body: jsonEncode({
        'product_id': productId,
        'quantity': quantity,
      }),
    );

    if (response.statusCode != 200) {
      throw Exception('Failed to add to cart');
    }
  }

  static Future<List<CartItem>> getCart() async {
    final response = await http.get(
      Uri.parse('${ApiService.baseUrl}/user/cart'),
      headers: ApiService.headers,
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return (data['data']['items'] as List)
          .map((item) => CartItem.fromJson(item))
          .toList();
    } else {
      throw Exception('Failed to load cart');
    }
  }

  static Future<void> removeFromCart(int cartItemId) async {
    final response = await http.delete(
      Uri.parse('${ApiService.baseUrl}/user/cart/remove/$cartItemId'),
      headers: ApiService.headers,
    );

    if (response.statusCode != 200) {
      throw Exception('Failed to remove from cart');
    }
  }

  static Future<void> updateQuantity(int cartItemId, int quantity) async {
    final response = await http.patch(
      Uri.parse('${ApiService.baseUrl}/user/cart/update/$cartItemId'),
      headers: ApiService.headers,
      body: jsonEncode({'quantity': quantity}),
    );

    if (response.statusCode != 200) {
      throw Exception('Failed to update quantity');
    }
  }
}
```

### 5. Order Service

```dart
class OrderService {
  static Future<List<Order>> getOrders() async {
    final response = await http.get(
      Uri.parse('${ApiService.baseUrl}/orders'),
      headers: ApiService.headers,
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return (data['data']['orders'] as List)
          .map((order) => Order.fromJson(order))
          .toList();
    } else {
      throw Exception('Failed to load orders');
    }
  }

  static Future<Order> createOrder(Map<String, dynamic> orderData) async {
    final response = await http.post(
      Uri.parse('${ApiService.baseUrl}/orders'),
      headers: ApiService.headers,
      body: jsonEncode(orderData),
    );

    if (response.statusCode == 201) {
      final data = jsonDecode(response.body);
      return Order.fromJson(data['data']['order']);
    } else {
      throw Exception('Failed to create order');
    }
  }

  static Future<Map<String, dynamic>> trackOrder(int orderId) async {
    final response = await http.get(
      Uri.parse('${ApiService.baseUrl}/orders/$orderId/track'),
      headers: ApiService.headers,
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return data['data'];
    } else {
      throw Exception('Failed to track order');
    }
  }
}
```

### 6. Payment Service

```dart
class PaymentService {
  static Future<Map<String, dynamic>> createPaymentOrder(double amount) async {
    final response = await http.post(
      Uri.parse('${ApiService.baseUrl}/payment/create-order'),
      headers: ApiService.headers,
      body: jsonEncode({
        'amount': amount,
        'currency': 'INR',
        'receipt': 'order_${DateTime.now().millisecondsSinceEpoch}',
      }),
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return data['data'];
    } else {
      throw Exception('Failed to create payment order');
    }
  }

  static Future<void> verifyPayment(Map<String, dynamic> paymentData) async {
    final response = await http.post(
      Uri.parse('${ApiService.baseUrl}/payment/verify'),
      headers: ApiService.headers,
      body: jsonEncode(paymentData),
    );

    if (response.statusCode != 200) {
      throw Exception('Payment verification failed');
    }
  }
}
```

## Error Handling

### 1. Create Error Handler

```dart
class ApiException implements Exception {
  final String message;
  final int statusCode;
  final Map<String, dynamic>? errors;

  ApiException({
    required this.message,
    required this.statusCode,
    this.errors,
  });

  factory ApiException.fromResponse(http.Response response) {
    final data = jsonDecode(response.body);
    return ApiException(
      message: data['message'] ?? 'Unknown error',
      statusCode: response.statusCode,
      errors: data['errors'],
    );
  }
}
```

### 2. Handle API Errors

```dart
Future<T> handleApiCall<T>(Future<T> Function() apiCall) async {
  try {
    return await apiCall();
  } on http.ClientException {
    throw ApiException(
      message: 'Network error. Please check your connection.',
      statusCode: 0,
    );
  } on FormatException {
    throw ApiException(
      message: 'Invalid response format.',
      statusCode: 0,
    );
  } catch (e) {
    if (e is ApiException) {
      rethrow;
    }
    throw ApiException(
      message: 'An unexpected error occurred.',
      statusCode: 0,
    );
  }
}
```

## Testing

### 1. Test API Endpoints

```bash
# Test health check
curl -X GET https://yourdomain.com/api/health

# Test registration
curl -X POST https://yourdomain.com/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Test login
curl -X POST https://yourdomain.com/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

### 2. Test with Postman

1. Import the API collection
2. Set up environment variables
3. Test each endpoint
4. Verify responses

## Security Considerations

### 1. Token Storage

- Store tokens securely (Keychain for iOS, Keystore for Android)
- Implement token refresh mechanism
- Clear tokens on logout

### 2. Input Validation

- Validate all user inputs
- Sanitize data before sending to API
- Handle validation errors gracefully

### 3. Network Security

- Use HTTPS for all API calls
- Implement certificate pinning
- Handle network errors gracefully

## Performance Optimization

### 1. Caching

```dart
class CacheManager {
  static final Map<String, dynamic> _cache = {};
  static const Duration _cacheExpiry = Duration(minutes: 5);

  static void set(String key, dynamic data) {
    _cache[key] = {
      'data': data,
      'timestamp': DateTime.now(),
    };
  }

  static dynamic get(String key) {
    final cached = _cache[key];
    if (cached != null) {
      final age = DateTime.now().difference(cached['timestamp']);
      if (age < _cacheExpiry) {
        return cached['data'];
      }
    }
    return null;
  }
}
```

### 2. Image Loading

```dart
class ImageService {
  static String getImageUrl(String? imagePath) {
    if (imagePath == null) return '';
    if (imagePath.startsWith('http')) return imagePath;
    return 'https://yourdomain.com$imagePath';
  }
}
```

## Deployment Checklist

- [ ] Set up production environment variables
- [ ] Configure SSL certificates
- [ ] Set up database backups
- [ ] Configure monitoring and logging
- [ ] Test all API endpoints
- [ ] Set up rate limiting
- [ ] Configure CORS properly
- [ ] Test payment integration
- [ ] Set up error tracking
- [ ] Document API changes

## Support

For technical support:
- Email: api-support@example.com
- Documentation: https://yourdomain.com/api/docs
- GitHub Issues: https://github.com/your-repo/issues

## Version History

- v1.0.0 - Initial API release
- v1.1.0 - Added payment integration
- v1.2.0 - Added admin endpoints
- v1.3.0 - Added review system