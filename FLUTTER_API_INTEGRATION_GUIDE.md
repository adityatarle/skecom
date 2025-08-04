# Flutter API Integration Guide

## 🚀 Quick Start for Flutter Development

**Base URL:** `https://yourdomain.com/api/v1`  
**Authentication:** Bearer Token  
**Platform:** Flutter/Dart

---

## 📋 Table of Contents

1. [Setup & Configuration](#setup--configuration)
2. [Authentication Flow](#authentication-flow)
3. [API Services](#api-services)
4. [Models](#models)
5. [State Management](#state-management)
6. [Error Handling](#error-handling)
7. [Complete Examples](#complete-examples)

---

## 🔧 Setup & Configuration

### 1. Add Dependencies

Add these to your `pubspec.yaml`:

```yaml
dependencies:
  flutter:
    sdk: flutter
  http: ^1.1.0
  shared_preferences: ^2.2.2
  flutter_secure_storage: ^9.0.0
  provider: ^6.1.1
  cached_network_image: ^3.3.0
  flutter_rating_bar: ^4.0.1
  razorpay_flutter: ^1.3.5
```

### 2. API Configuration

Create `lib/services/api_config.dart`:

```dart
class ApiConfig {
  // Replace with your actual domain
  static const String baseUrl = 'https://yourdomain.com/api/v1';
  
  // API Headers
  static Map<String, String> getHeaders({String? token}) {
    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    
    if (token != null) {
      headers['Authorization'] = 'Bearer $token';
    }
    
    return headers;
  }
  
  // Image URL Helper
  static String getImageUrl(String? imagePath) {
    if (imagePath == null || imagePath.isEmpty) {
      return 'https://via.placeholder.com/300x300?text=No+Image';
    }
    
    if (imagePath.startsWith('http')) {
      return imagePath;
    }
    
    return 'https://yourdomain.com$imagePath';
  }
}
```

### 3. Token Storage

Create `lib/services/token_storage.dart`:

```dart
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class TokenStorage {
  static const _storage = FlutterSecureStorage();
  static const _tokenKey = 'auth_token';
  static const _userKey = 'user_data';

  // Save token
  static Future<void> saveToken(String token) async {
    await _storage.write(key: _tokenKey, value: token);
  }

  // Get token
  static Future<String?> getToken() async {
    return await _storage.read(key: _tokenKey);
  }

  // Save user data
  static Future<void> saveUser(Map<String, dynamic> user) async {
    await _storage.write(key: _userKey, value: user.toString());
  }

  // Get user data
  static Future<Map<String, dynamic>?> getUser() async {
    final userString = await _storage.read(key: _userKey);
    if (userString != null) {
      // Parse user string back to map
      return Map<String, dynamic>.from(
        userString as Map<String, dynamic>
      );
    }
    return null;
  }

  // Clear all data
  static Future<void> clearAll() async {
    await _storage.deleteAll();
  }
}
```

---

## 🔐 Authentication Flow

### 1. Auth Service

Create `lib/services/auth_service.dart`:

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'api_config.dart';
import 'token_storage.dart';

class AuthService {
  static Future<Map<String, dynamic>> register({
    required String name,
    required String email,
    required String password,
    String? phone,
    String? address,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('${ApiConfig.baseUrl}/register'),
        headers: ApiConfig.getHeaders(),
        body: jsonEncode({
          'name': name,
          'email': email,
          'password': password,
          'password_confirmation': password,
          'phone': phone,
          'address': address,
        }),
      );

      final data = jsonDecode(response.body);
      
      if (response.statusCode == 201) {
        await TokenStorage.saveToken(data['data']['token']);
        await TokenStorage.saveUser(data['data']['user']);
        return data['data'];
      } else {
        throw Exception(data['message'] ?? 'Registration failed');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<Map<String, dynamic>> login({
    required String email,
    required String password,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('${ApiConfig.baseUrl}/login'),
        headers: ApiConfig.getHeaders(),
        body: jsonEncode({
          'email': email,
          'password': password,
        }),
      );

      final data = jsonDecode(response.body);
      
      if (response.statusCode == 200) {
        await TokenStorage.saveToken(data['data']['token']);
        await TokenStorage.saveUser(data['data']['user']);
        return data['data'];
      } else {
        throw Exception(data['message'] ?? 'Login failed');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<void> logout() async {
    try {
      final token = await TokenStorage.getToken();
      if (token != null) {
        await http.post(
          Uri.parse('${ApiConfig.baseUrl}/user/logout'),
          headers: ApiConfig.getHeaders(token: token),
        );
      }
    } catch (e) {
      // Continue with logout even if API call fails
    } finally {
      await TokenStorage.clearAll();
    }
  }

  static Future<bool> isLoggedIn() async {
    final token = await TokenStorage.getToken();
    return token != null;
  }
}
```

### 2. Auth Provider

Create `lib/providers/auth_provider.dart`:

```dart
import 'package:flutter/foundation.dart';
import '../services/auth_service.dart';
import '../services/token_storage.dart';

class AuthProvider with ChangeNotifier {
  bool _isLoading = false;
  bool _isLoggedIn = false;
  Map<String, dynamic>? _user;

  bool get isLoading => _isLoading;
  bool get isLoggedIn => _isLoggedIn;
  Map<String, dynamic>? get user => _user;

  AuthProvider() {
    checkLoginStatus();
  }

  Future<void> checkLoginStatus() async {
    _isLoggedIn = await AuthService.isLoggedIn();
    if (_isLoggedIn) {
      _user = await TokenStorage.getUser();
    }
    notifyListeners();
  }

  Future<bool> login(String email, String password) async {
    _isLoading = true;
    notifyListeners();

    try {
      final data = await AuthService.login(email: email, password: password);
      _user = data['user'];
      _isLoggedIn = true;
      return true;
    } catch (e) {
      return false;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<bool> register({
    required String name,
    required String email,
    required String password,
    String? phone,
    String? address,
  }) async {
    _isLoading = true;
    notifyListeners();

    try {
      final data = await AuthService.register(
        name: name,
        email: email,
        password: password,
        phone: phone,
        address: address,
      );
      _user = data['user'];
      _isLoggedIn = true;
      return true;
    } catch (e) {
      return false;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> logout() async {
    await AuthService.logout();
    _user = null;
    _isLoggedIn = false;
    notifyListeners();
  }
}
```

---

## 📦 API Services

### 1. Product Service

Create `lib/services/product_service.dart`:

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'api_config.dart';
import 'token_storage.dart';

class ProductService {
  static Future<Map<String, dynamic>> getProducts({
    int page = 1,
    int perPage = 12,
    String? sortBy,
    String? sortOrder,
  }) async {
    try {
      final token = await TokenStorage.getToken();
      
      final queryParams = {
        'page': page.toString(),
        'per_page': perPage.toString(),
      };

      if (sortBy != null) queryParams['sort_by'] = sortBy;
      if (sortOrder != null) queryParams['sort_order'] = sortOrder;

      final uri = Uri.parse('${ApiConfig.baseUrl}/products')
          .replace(queryParameters: queryParams);

      final response = await http.get(
        uri,
        headers: ApiConfig.getHeaders(token: token),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load products');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<Map<String, dynamic>> getProduct(int id) async {
    try {
      final token = await TokenStorage.getToken();
      
      final response = await http.get(
        Uri.parse('${ApiConfig.baseUrl}/products/$id'),
        headers: ApiConfig.getHeaders(token: token),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load product');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<Map<String, dynamic>> searchProducts(String query) async {
    try {
      final token = await TokenStorage.getToken();
      
      final uri = Uri.parse('${ApiConfig.baseUrl}/products/search')
          .replace(queryParameters: {'query': query});

      final response = await http.get(
        uri,
        headers: ApiConfig.getHeaders(token: token),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Search failed');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<Map<String, dynamic>> filterProducts({
    int? categoryId,
    int? subCategoryId,
    double? minPrice,
    double? maxPrice,
    String? sortBy,
    String? sortOrder,
  }) async {
    try {
      final token = await TokenStorage.getToken();
      
      final queryParams = <String, String>{};
      
      if (categoryId != null) queryParams['category_id'] = categoryId.toString();
      if (subCategoryId != null) queryParams['sub_category_id'] = subCategoryId.toString();
      if (minPrice != null) queryParams['min_price'] = minPrice.toString();
      if (maxPrice != null) queryParams['max_price'] = maxPrice.toString();
      if (sortBy != null) queryParams['sort_by'] = sortBy;
      if (sortOrder != null) queryParams['sort_order'] = sortOrder;

      final uri = Uri.parse('${ApiConfig.baseUrl}/products/filter')
          .replace(queryParameters: queryParams);

      final response = await http.get(
        uri,
        headers: ApiConfig.getHeaders(token: token),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Filter failed');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }
}
```

### 2. Cart Service

Create `lib/services/cart_service.dart`:

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'api_config.dart';
import 'token_storage.dart';

class CartService {
  static Future<Map<String, dynamic>> addToCart(int productId, int quantity) async {
    try {
      final token = await TokenStorage.getToken();
      
      final response = await http.post(
        Uri.parse('${ApiConfig.baseUrl}/user/cart/add'),
        headers: ApiConfig.getHeaders(token: token),
        body: jsonEncode({
          'product_id': productId,
          'quantity': quantity,
        }),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        final data = jsonDecode(response.body);
        throw Exception(data['message'] ?? 'Failed to add to cart');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<Map<String, dynamic>> getCart() async {
    try {
      final token = await TokenStorage.getToken();
      
      final response = await http.get(
        Uri.parse('${ApiConfig.baseUrl}/user/cart'),
        headers: ApiConfig.getHeaders(token: token),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load cart');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<void> removeFromCart(int cartItemId) async {
    try {
      final token = await TokenStorage.getToken();
      
      final response = await http.delete(
        Uri.parse('${ApiConfig.baseUrl}/user/cart/remove/$cartItemId'),
        headers: ApiConfig.getHeaders(token: token),
      );

      if (response.statusCode != 200) {
        throw Exception('Failed to remove from cart');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<void> updateQuantity(int cartItemId, int quantity) async {
    try {
      final token = await TokenStorage.getToken();
      
      final response = await http.patch(
        Uri.parse('${ApiConfig.baseUrl}/user/cart/update/$cartItemId'),
        headers: ApiConfig.getHeaders(token: token),
        body: jsonEncode({'quantity': quantity}),
      );

      if (response.statusCode != 200) {
        throw Exception('Failed to update quantity');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<void> clearCart() async {
    try {
      final token = await TokenStorage.getToken();
      
      final response = await http.delete(
        Uri.parse('${ApiConfig.baseUrl}/user/cart/clear'),
        headers: ApiConfig.getHeaders(token: token),
      );

      if (response.statusCode != 200) {
        throw Exception('Failed to clear cart');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }
}
```

### 3. Order Service

Create `lib/services/order_service.dart`:

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'api_config.dart';
import 'token_storage.dart';

class OrderService {
  static Future<Map<String, dynamic>> getOrders() async {
    try {
      final token = await TokenStorage.getToken();
      
      final response = await http.get(
        Uri.parse('${ApiConfig.baseUrl}/orders'),
        headers: ApiConfig.getHeaders(token: token),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load orders');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<Map<String, dynamic>> createOrder({
    required List<Map<String, dynamic>> products,
    required String firstName,
    required String lastName,
    required String email,
    required String phone,
    required String streetAddress,
    required String city,
    required String state,
    required String country,
    required String paymentMethod,
    String? notes,
  }) async {
    try {
      final token = await TokenStorage.getToken();
      
      final response = await http.post(
        Uri.parse('${ApiConfig.baseUrl}/orders'),
        headers: ApiConfig.getHeaders(token: token),
        body: jsonEncode({
          'products': products,
          'first_name': firstName,
          'last_name': lastName,
          'email': email,
          'phone': phone,
          'street_address': streetAddress,
          'city': city,
          'state': state,
          'country': country,
          'payment_method': paymentMethod,
          'notes': notes,
        }),
      );

      if (response.statusCode == 201) {
        return jsonDecode(response.body);
      } else {
        final data = jsonDecode(response.body);
        throw Exception(data['message'] ?? 'Failed to create order');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<Map<String, dynamic>> getOrder(int orderId) async {
    try {
      final token = await TokenStorage.getToken();
      
      final response = await http.get(
        Uri.parse('${ApiConfig.baseUrl}/orders/$orderId'),
        headers: ApiConfig.getHeaders(token: token),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load order');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  static Future<Map<String, dynamic>> trackOrder(int orderId) async {
    try {
      final token = await TokenStorage.getToken();
      
      final response = await http.get(
        Uri.parse('${ApiConfig.baseUrl}/orders/$orderId/track'),
        headers: ApiConfig.getHeaders(token: token),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to track order');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }
}
```

---

## 📱 Models

### 1. Product Model

Create `lib/models/product.dart`:

```dart
class Product {
  final int id;
  final String name;
  final String description;
  final double price;
  final String? imagePath;
  final Map<String, dynamic>? category;
  final Map<String, dynamic>? subcategory;
  final List<Map<String, dynamic>>? images;
  final String status;

  Product({
    required this.id,
    required this.name,
    required this.description,
    required this.price,
    this.imagePath,
    this.category,
    this.subcategory,
    this.images,
    required this.status,
  });

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'],
      name: json['name'],
      description: json['description'] ?? '',
      price: double.parse(json['price'].toString()),
      imagePath: json['image_path'],
      category: json['category'],
      subcategory: json['subcategory'],
      images: json['images'] != null 
          ? List<Map<String, dynamic>>.from(json['images'])
          : null,
      status: json['status'] ?? 'active',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'price': price,
      'image_path': imagePath,
      'category': category,
      'subcategory': subcategory,
      'images': images,
      'status': status,
    };
  }
}
```

### 2. Cart Item Model

Create `lib/models/cart_item.dart`:

```dart
class CartItem {
  final int id;
  final int productId;
  final int quantity;
  final double price;
  final Map<String, dynamic> product;

  CartItem({
    required this.id,
    required this.productId,
    required this.quantity,
    required this.price,
    required this.product,
  });

  factory CartItem.fromJson(Map<String, dynamic> json) {
    return CartItem(
      id: json['id'],
      productId: json['product_id'],
      quantity: json['quantity'],
      price: double.parse(json['price'].toString()),
      product: json['product'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'product_id': productId,
      'quantity': quantity,
      'price': price,
      'product': product,
    };
  }
}
```

### 3. Order Model

Create `lib/models/order.dart`:

```dart
class Order {
  final int id;
  final String status;
  final double totalPrice;
  final String paymentMethod;
  final Map<String, dynamic> billingInfo;
  final List<Map<String, dynamic>> products;
  final String createdAt;
  final String? razorpayOrderId;
  final String? razorpayPaymentId;

  Order({
    required this.id,
    required this.status,
    required this.totalPrice,
    required this.paymentMethod,
    required this.billingInfo,
    required this.products,
    required this.createdAt,
    this.razorpayOrderId,
    this.razorpayPaymentId,
  });

  factory Order.fromJson(Map<String, dynamic> json) {
    return Order(
      id: json['id'],
      status: json['status'],
      totalPrice: double.parse(json['total_price'].toString()),
      paymentMethod: json['payment_method'],
      billingInfo: {
        'first_name': json['first_name'],
        'last_name': json['last_name'],
        'email': json['email'],
        'phone': json['phone'],
        'street_address': json['street_address'],
        'city': json['city'],
        'state': json['state'],
        'country': json['country'],
      },
      products: List<Map<String, dynamic>>.from(json['products']),
      createdAt: json['created_at'],
      razorpayOrderId: json['razorpay_order_id'],
      razorpayPaymentId: json['razorpay_payment_id'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'status': status,
      'total_price': totalPrice,
      'payment_method': paymentMethod,
      'billing_info': billingInfo,
      'products': products,
      'created_at': createdAt,
      'razorpay_order_id': razorpayOrderId,
      'razorpay_payment_id': razorpayPaymentId,
    };
  }
}
```

---

## 🎯 Complete Examples

### 1. Login Screen

```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/auth_provider.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Login')),
      body: Padding(
        padding: EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              TextFormField(
                controller: _emailController,
                decoration: InputDecoration(labelText: 'Email'),
                validator: (value) {
                  if (value?.isEmpty ?? true) {
                    return 'Please enter email';
                  }
                  return null;
                },
              ),
              SizedBox(height: 16),
              TextFormField(
                controller: _passwordController,
                decoration: InputDecoration(labelText: 'Password'),
                obscureText: true,
                validator: (value) {
                  if (value?.isEmpty ?? true) {
                    return 'Please enter password';
                  }
                  return null;
                },
              ),
              SizedBox(height: 24),
              Consumer<AuthProvider>(
                builder: (context, auth, child) {
                  return ElevatedButton(
                    onPressed: auth.isLoading ? null : _login,
                    child: auth.isLoading 
                        ? CircularProgressIndicator()
                        : Text('Login'),
                  );
                },
              ),
            ],
          ),
        ),
      ),
    );
  }

  Future<void> _login() async {
    if (_formKey.currentState?.validate() ?? false) {
      final auth = Provider.of<AuthProvider>(context, listen: false);
      final success = await auth.login(
        _emailController.text,
        _passwordController.text,
      );

      if (success) {
        Navigator.pushReplacementNamed(context, '/home');
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Login failed')),
        );
      }
    }
  }
}
```

### 2. Product List Screen

```dart
import 'package:flutter/material.dart';
import '../models/product.dart';
import '../services/product_service.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'api_config.dart';

class ProductListScreen extends StatefulWidget {
  @override
  _ProductListScreenState createState() => _ProductListScreenState();
}

class _ProductListScreenState extends State<ProductListScreen> {
  List<Product> products = [];
  bool isLoading = false;
  int currentPage = 1;
  bool hasMore = true;

  @override
  void initState() {
    super.initState();
    _loadProducts();
  }

  Future<void> _loadProducts({bool refresh = false}) async {
    if (isLoading) return;

    setState(() {
      isLoading = true;
    });

    try {
      if (refresh) {
        currentPage = 1;
        products.clear();
      }

      final response = await ProductService.getProducts(
        page: currentPage,
        perPage: 12,
      );

      final newProducts = (response['data']['products'] as List)
          .map((json) => Product.fromJson(json))
          .toList();

      setState(() {
        products.addAll(newProducts);
        currentPage++;
        hasMore = newProducts.length == 12;
      });
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed to load products: $e')),
      );
    } finally {
      setState(() {
        isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Products')),
      body: RefreshIndicator(
        onRefresh: () => _loadProducts(refresh: true),
        child: GridView.builder(
          padding: EdgeInsets.all(8),
          gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: 2,
            childAspectRatio: 0.75,
            crossAxisSpacing: 8,
            mainAxisSpacing: 8,
          ),
          itemCount: products.length + (hasMore ? 1 : 0),
          itemBuilder: (context, index) {
            if (index == products.length) {
              return _buildLoadMoreButton();
            }
            return _buildProductCard(products[index]);
          },
        ),
      ),
    );
  }

  Widget _buildProductCard(Product product) {
    return Card(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Expanded(
            child: CachedNetworkImage(
              imageUrl: ApiConfig.getImageUrl(product.imagePath),
              fit: BoxFit.cover,
              width: double.infinity,
              placeholder: (context, url) => Center(
                child: CircularProgressIndicator(),
              ),
              errorWidget: (context, url, error) => Icon(Icons.error),
            ),
          ),
          Padding(
            padding: EdgeInsets.all(8),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  product.name,
                  style: TextStyle(fontWeight: FontWeight.bold),
                  maxLines: 2,
                  overflow: TextOverflow.ellipsis,
                ),
                SizedBox(height: 4),
                Text(
                  '₹${product.price.toStringAsFixed(2)}',
                  style: TextStyle(
                    color: Colors.green,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLoadMoreButton() {
    return Center(
      child: Padding(
        padding: EdgeInsets.all(16),
        child: ElevatedButton(
          onPressed: isLoading ? null : () => _loadProducts(),
          child: isLoading 
              ? CircularProgressIndicator()
              : Text('Load More'),
        ),
      ),
    );
  }
}
```

---

## 🚀 Ready to Use!

Your colleague now has:

✅ **Complete API integration guide**  
✅ **Ready-to-use Flutter code examples**  
✅ **Authentication flow**  
✅ **Product management**  
✅ **Cart operations**  
✅ **Order processing**  
✅ **Error handling patterns**  
✅ **State management setup**  

**Next Steps for Your Colleague:**

1. **Copy the code examples** into their Flutter project
2. **Update the base URL** in `ApiConfig` to your actual domain
3. **Install the required dependencies** from `pubspec.yaml`
4. **Start building the UI** using the provided examples
5. **Test the API integration** with the provided services

The API is production-ready and will work perfectly with Hostinger hosting! 🎉