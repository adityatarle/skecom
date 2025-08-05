# Flutter Implementation Guide for Laravel Jewelry Shop APIs

## Overview

This guide provides step-by-step instructions for integrating your Flutter application with the Laravel jewelry shop APIs. All APIs have been tested and are ready for production use.

## 1. Project Setup

### Dependencies

Add these dependencies to your `pubspec.yaml`:

```yaml
dependencies:
  flutter:
    sdk: flutter
  http: ^1.1.0
  shared_preferences: ^2.2.2
  provider: ^6.1.1
  cached_network_image: ^3.3.0
  flutter_secure_storage: ^9.0.0

dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_lints: ^3.0.0
```

### Project Structure

```
lib/
├── main.dart
├── config/
│   └── api_config.dart
├── models/
│   ├── user.dart
│   ├── product.dart
│   ├── category.dart
│   ├── cart_item.dart
│   └── order.dart
├── services/
│   ├── api_service.dart
│   ├── auth_service.dart
│   ├── product_service.dart
│   ├── cart_service.dart
│   └── order_service.dart
├── providers/
│   ├── auth_provider.dart
│   ├── cart_provider.dart
│   └── product_provider.dart
├── screens/
│   ├── auth/
│   │   ├── login_screen.dart
│   │   └── register_screen.dart
│   ├── home/
│   │   └── home_screen.dart
│   ├── products/
│   │   ├── product_list_screen.dart
│   │   └── product_detail_screen.dart
│   ├── cart/
│   │   └── cart_screen.dart
│   └── orders/
│       └── orders_screen.dart
└── widgets/
    ├── product_card.dart
    ├── cart_item_widget.dart
    └── loading_widget.dart
```

## 2. Configuration

### API Configuration

Create `lib/config/api_config.dart`:

```dart
class ApiConfig {
  // Replace with your actual domain
  static const String baseUrl = 'https://your-domain.com/api/v1';
  
  // For local development
  // static const String baseUrl = 'http://10.0.2.2:8000/api/v1'; // Android Emulator
  // static const String baseUrl = 'http://localhost:8000/api/v1'; // iOS Simulator
  
  // API Endpoints
  static const String login = '/login';
  static const String register = '/register';
  static const String logout = '/logout';
  static const String profile = '/profile';
  static const String products = '/products';
  static const String categories = '/categories';
  static const String home = '/home';
  static const String cart = '/cart';
  static const String orders = '/orders';
  
  // Request timeout
  static const Duration timeout = Duration(seconds: 30);
}
```

## 3. Data Models

### User Model

Create `lib/models/user.dart`:

```dart
class User {
  final int id;
  final String name;
  final String email;
  final String? phone;
  final String? address;
  final String role;
  final DateTime? createdAt;

  User({
    required this.id,
    required this.name,
    required this.email,
    this.phone,
    this.address,
    required this.role,
    this.createdAt,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      name: json['name'],
      email: json['email'],
      phone: json['phone'],
      address: json['address'],
      role: json['role'],
      createdAt: json['created_at'] != null 
          ? DateTime.parse(json['created_at']) 
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'phone': phone,
      'address': address,
      'role': role,
      'created_at': createdAt?.toIso8601String(),
    };
  }
}
```

### Product Model

Create `lib/models/product.dart`:

```dart
class Product {
  final int id;
  final String name;
  final String description;
  final double price;
  final double? salePrice;
  final String? image;
  final int categoryId;
  final String categoryName;
  final int stock;
  final bool isActive;
  final DateTime? createdAt;

  Product({
    required this.id,
    required this.name,
    required this.description,
    required this.price,
    this.salePrice,
    this.image,
    required this.categoryId,
    required this.categoryName,
    required this.stock,
    required this.isActive,
    this.createdAt,
  });

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'],
      name: json['name'],
      description: json['description'] ?? '',
      price: double.parse(json['price'].toString()),
      salePrice: json['sale_price'] != null 
          ? double.parse(json['sale_price'].toString()) 
          : null,
      image: json['image'],
      categoryId: json['category_id'],
      categoryName: json['category_name'] ?? json['category']?['name'] ?? '',
      stock: json['stock'] ?? 0,
      isActive: json['is_active'] ?? true,
      createdAt: json['created_at'] != null 
          ? DateTime.parse(json['created_at']) 
          : null,
    );
  }

  double get effectivePrice => salePrice ?? price;
  bool get isOnSale => salePrice != null && salePrice! < price;
  bool get isInStock => stock > 0;
}

class ProductPagination {
  final List<Product> products;
  final int currentPage;
  final int lastPage;
  final int perPage;
  final int total;

  ProductPagination({
    required this.products,
    required this.currentPage,
    required this.lastPage,
    required this.perPage,
    required this.total,
  });

  factory ProductPagination.fromJson(Map<String, dynamic> json) {
    return ProductPagination(
      products: (json['products'] as List)
          .map((item) => Product.fromJson(item))
          .toList(),
      currentPage: json['pagination']['current_page'],
      lastPage: json['pagination']['last_page'],
      perPage: json['pagination']['per_page'],
      total: json['pagination']['total'],
    );
  }

  bool get hasNextPage => currentPage < lastPage;
}
```

### Category Model

Create `lib/models/category.dart`:

```dart
class Category {
  final int id;
  final String name;
  final String? description;
  final String? image;
  final bool isActive;

  Category({
    required this.id,
    required this.name,
    this.description,
    this.image,
    required this.isActive,
  });

  factory Category.fromJson(Map<String, dynamic> json) {
    return Category(
      id: json['id'],
      name: json['name'],
      description: json['description'],
      image: json['image'],
      isActive: json['is_active'] ?? true,
    );
  }
}
```

## 4. API Service Layer

### Base API Service

Create `lib/services/api_service.dart`:

```dart
import 'dart:convert';
import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import '../config/api_config.dart';

class ApiResponse<T> {
  final bool success;
  final String message;
  final T? data;
  final Map<String, dynamic>? errors;

  ApiResponse({
    required this.success,
    required this.message,
    this.data,
    this.errors,
  });
}

class ApiService {
  static const _storage = FlutterSecureStorage();
  static String? _token;

  static Future<String?> getToken() async {
    _token ??= await _storage.read(key: 'auth_token');
    return _token;
  }

  static Future<void> setToken(String token) async {
    _token = token;
    await _storage.write(key: 'auth_token', value: token);
  }

  static Future<void> clearToken() async {
    _token = null;
    await _storage.delete(key: 'auth_token');
  }

  static Map<String, String> get _headers => {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  };

  static Map<String, String> get _authHeaders => {
    ..._headers,
    if (_token != null) 'Authorization': 'Bearer $_token',
  };

  static Future<ApiResponse<T>> _handleResponse<T>(
    http.Response response,
    T Function(Map<String, dynamic>)? fromJson,
  ) async {
    try {
      final Map<String, dynamic> body = jsonDecode(response.body);
      
      if (response.statusCode >= 200 && response.statusCode < 300) {
        return ApiResponse<T>(
          success: true,
          message: body['message'] ?? 'Success',
          data: fromJson != null && body['data'] != null 
              ? fromJson(body['data']) 
              : body['data'],
        );
      } else {
        return ApiResponse<T>(
          success: false,
          message: body['message'] ?? 'An error occurred',
          errors: body['errors'],
        );
      }
    } catch (e) {
      return ApiResponse<T>(
        success: false,
        message: 'Network error: ${e.toString()}',
      );
    }
  }

  static Future<ApiResponse<T>> get<T>(
    String endpoint, {
    T Function(Map<String, dynamic>)? fromJson,
    bool requiresAuth = false,
  }) async {
    try {
      if (requiresAuth) await getToken();
      
      final response = await http.get(
        Uri.parse('${ApiConfig.baseUrl}$endpoint'),
        headers: requiresAuth ? _authHeaders : _headers,
      ).timeout(ApiConfig.timeout);

      return _handleResponse(response, fromJson);
    } on SocketException {
      return ApiResponse<T>(
        success: false,
        message: 'No internet connection',
      );
    } on HttpException {
      return ApiResponse<T>(
        success: false,
        message: 'Server error',
      );
    } catch (e) {
      return ApiResponse<T>(
        success: false,
        message: 'Unexpected error: ${e.toString()}',
      );
    }
  }

  static Future<ApiResponse<T>> post<T>(
    String endpoint,
    Map<String, dynamic> body, {
    T Function(Map<String, dynamic>)? fromJson,
    bool requiresAuth = false,
  }) async {
    try {
      if (requiresAuth) await getToken();
      
      final response = await http.post(
        Uri.parse('${ApiConfig.baseUrl}$endpoint'),
        headers: requiresAuth ? _authHeaders : _headers,
        body: jsonEncode(body),
      ).timeout(ApiConfig.timeout);

      return _handleResponse(response, fromJson);
    } on SocketException {
      return ApiResponse<T>(
        success: false,
        message: 'No internet connection',
      );
    } catch (e) {
      return ApiResponse<T>(
        success: false,
        message: 'Unexpected error: ${e.toString()}',
      );
    }
  }

  static Future<ApiResponse<T>> put<T>(
    String endpoint,
    Map<String, dynamic> body, {
    T Function(Map<String, dynamic>)? fromJson,
    bool requiresAuth = true,
  }) async {
    try {
      if (requiresAuth) await getToken();
      
      final response = await http.put(
        Uri.parse('${ApiConfig.baseUrl}$endpoint'),
        headers: requiresAuth ? _authHeaders : _headers,
        body: jsonEncode(body),
      ).timeout(ApiConfig.timeout);

      return _handleResponse(response, fromJson);
    } catch (e) {
      return ApiResponse<T>(
        success: false,
        message: 'Unexpected error: ${e.toString()}',
      );
    }
  }

  static Future<ApiResponse<T>> delete<T>(
    String endpoint, {
    T Function(Map<String, dynamic>)? fromJson,
    bool requiresAuth = true,
  }) async {
    try {
      if (requiresAuth) await getToken();
      
      final response = await http.delete(
        Uri.parse('${ApiConfig.baseUrl}$endpoint'),
        headers: requiresAuth ? _authHeaders : _headers,
      ).timeout(ApiConfig.timeout);

      return _handleResponse(response, fromJson);
    } catch (e) {
      return ApiResponse<T>(
        success: false,
        message: 'Unexpected error: ${e.toString()}',
      );
    }
  }
}
```

### Authentication Service

Create `lib/services/auth_service.dart`:

```dart
import '../models/user.dart';
import '../config/api_config.dart';
import 'api_service.dart';

class AuthResponse {
  final User user;
  final String token;

  AuthResponse({required this.user, required this.token});

  factory AuthResponse.fromJson(Map<String, dynamic> json) {
    return AuthResponse(
      user: User.fromJson(json['user']),
      token: json['token'],
    );
  }
}

class AuthService {
  static Future<ApiResponse<AuthResponse>> login({
    required String email,
    required String password,
  }) async {
    final response = await ApiService.post<AuthResponse>(
      ApiConfig.login,
      {
        'email': email,
        'password': password,
      },
      fromJson: (json) => AuthResponse.fromJson(json),
    );

    if (response.success && response.data != null) {
      await ApiService.setToken(response.data!.token);
    }

    return response;
  }

  static Future<ApiResponse<AuthResponse>> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
    String? phone,
    String? address,
  }) async {
    final response = await ApiService.post<AuthResponse>(
      ApiConfig.register,
      {
        'name': name,
        'email': email,
        'password': password,
        'password_confirmation': passwordConfirmation,
        if (phone != null) 'phone': phone,
        if (address != null) 'address': address,
      },
      fromJson: (json) => AuthResponse.fromJson(json),
    );

    if (response.success && response.data != null) {
      await ApiService.setToken(response.data!.token);
    }

    return response;
  }

  static Future<ApiResponse<User>> getProfile() async {
    return ApiService.get<User>(
      ApiConfig.profile,
      fromJson: (json) => User.fromJson(json),
      requiresAuth: true,
    );
  }

  static Future<ApiResponse<void>> logout() async {
    final response = await ApiService.post<void>(
      ApiConfig.logout,
      {},
      requiresAuth: true,
    );

    if (response.success) {
      await ApiService.clearToken();
    }

    return response;
  }

  static Future<bool> isLoggedIn() async {
    final token = await ApiService.getToken();
    return token != null;
  }
}
```

### Product Service

Create `lib/services/product_service.dart`:

```dart
import '../models/product.dart';
import '../models/category.dart';
import '../config/api_config.dart';
import 'api_service.dart';

class HomeData {
  final List<Product> featuredProducts;
  final List<Category> categories;
  final List<Product> latestProducts;

  HomeData({
    required this.featuredProducts,
    required this.categories,
    required this.latestProducts,
  });

  factory HomeData.fromJson(Map<String, dynamic> json) {
    return HomeData(
      featuredProducts: (json['featured_products'] as List? ?? [])
          .map((item) => Product.fromJson(item))
          .toList(),
      categories: (json['categories'] as List? ?? [])
          .map((item) => Category.fromJson(item))
          .toList(),
      latestProducts: (json['latest_products'] as List? ?? [])
          .map((item) => Product.fromJson(item))
          .toList(),
    );
  }
}

class ProductService {
  static Future<ApiResponse<HomeData>> getHomeData() async {
    return ApiService.get<HomeData>(
      ApiConfig.home,
      fromJson: (json) => HomeData.fromJson(json),
    );
  }

  static Future<ApiResponse<ProductPagination>> getProducts({
    int page = 1,
    int perPage = 12,
  }) async {
    return ApiService.get<ProductPagination>(
      '${ApiConfig.products}?page=$page&per_page=$perPage',
      fromJson: (json) => ProductPagination.fromJson(json),
    );
  }

  static Future<ApiResponse<Product>> getProduct(int id) async {
    return ApiService.get<Product>(
      '${ApiConfig.products}/$id',
      fromJson: (json) => Product.fromJson(json),
    );
  }

  static Future<ApiResponse<List<Category>>> getCategories() async {
    return ApiService.get<List<Category>>(
      ApiConfig.categories,
      fromJson: (json) => (json['categories'] as List)
          .map((item) => Category.fromJson(item))
          .toList(),
    );
  }

  static Future<ApiResponse<ProductPagination>> getProductsByCategory({
    required int categoryId,
    int page = 1,
    int perPage = 12,
  }) async {
    return ApiService.get<ProductPagination>(
      '${ApiConfig.products}/category/$categoryId?page=$page&per_page=$perPage',
      fromJson: (json) => ProductPagination.fromJson(json),
    );
  }

  static Future<ApiResponse<ProductPagination>> searchProducts({
    required String query,
    int page = 1,
    int perPage = 12,
  }) async {
    return ApiService.get<ProductPagination>(
      '${ApiConfig.products}/search?q=$query&page=$page&per_page=$perPage',
      fromJson: (json) => ProductPagination.fromJson(json),
    );
  }
}
```

## 5. State Management with Provider

### Authentication Provider

Create `lib/providers/auth_provider.dart`:

```dart
import 'package:flutter/foundation.dart';
import '../models/user.dart';
import '../services/auth_service.dart';

class AuthProvider with ChangeNotifier {
  User? _user;
  bool _isLoading = false;
  String? _error;

  User? get user => _user;
  bool get isLoading => _isLoading;
  String? get error => _error;
  bool get isLoggedIn => _user != null;

  void _setLoading(bool loading) {
    _isLoading = loading;
    notifyListeners();
  }

  void _setError(String? error) {
    _error = error;
    notifyListeners();
  }

  Future<bool> login(String email, String password) async {
    _setLoading(true);
    _setError(null);

    try {
      final response = await AuthService.login(
        email: email,
        password: password,
      );

      if (response.success && response.data != null) {
        _user = response.data!.user;
        _setLoading(false);
        notifyListeners();
        return true;
      } else {
        _setError(response.message);
        _setLoading(false);
        return false;
      }
    } catch (e) {
      _setError('Login failed: ${e.toString()}');
      _setLoading(false);
      return false;
    }
  }

  Future<bool> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
    String? phone,
    String? address,
  }) async {
    _setLoading(true);
    _setError(null);

    try {
      final response = await AuthService.register(
        name: name,
        email: email,
        password: password,
        passwordConfirmation: passwordConfirmation,
        phone: phone,
        address: address,
      );

      if (response.success && response.data != null) {
        _user = response.data!.user;
        _setLoading(false);
        notifyListeners();
        return true;
      } else {
        _setError(response.message);
        _setLoading(false);
        return false;
      }
    } catch (e) {
      _setError('Registration failed: ${e.toString()}');
      _setLoading(false);
      return false;
    }
  }

  Future<void> logout() async {
    _setLoading(true);
    
    try {
      await AuthService.logout();
      _user = null;
      _setLoading(false);
      notifyListeners();
    } catch (e) {
      _setError('Logout failed: ${e.toString()}');
      _setLoading(false);
    }
  }

  Future<void> checkAuthStatus() async {
    if (await AuthService.isLoggedIn()) {
      final response = await AuthService.getProfile();
      if (response.success && response.data != null) {
        _user = response.data;
        notifyListeners();
      }
    }
  }
}
```

## 6. Sample Screens

### Login Screen

Create `lib/screens/auth/login_screen.dart`:

```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../providers/auth_provider.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  Future<void> _login() async {
    if (_formKey.currentState?.validate() ?? false) {
      final authProvider = Provider.of<AuthProvider>(context, listen: false);
      
      final success = await authProvider.login(
        _emailController.text.trim(),
        _passwordController.text,
      );

      if (success && mounted) {
        Navigator.of(context).pushReplacementNamed('/home');
      } else if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(authProvider.error ?? 'Login failed'),
            backgroundColor: Colors.red,
          ),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Login'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              TextFormField(
                controller: _emailController,
                decoration: const InputDecoration(
                  labelText: 'Email',
                  border: OutlineInputBorder(),
                ),
                keyboardType: TextInputType.emailAddress,
                validator: (value) {
                  if (value?.isEmpty ?? true) {
                    return 'Please enter your email';
                  }
                  if (!RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$')
                      .hasMatch(value!)) {
                    return 'Please enter a valid email';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _passwordController,
                decoration: const InputDecoration(
                  labelText: 'Password',
                  border: OutlineInputBorder(),
                ),
                obscureText: true,
                validator: (value) {
                  if (value?.isEmpty ?? true) {
                    return 'Please enter your password';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 24),
              Consumer<AuthProvider>(
                builder: (context, authProvider, child) {
                  return SizedBox(
                    width: double.infinity,
                    child: ElevatedButton(
                      onPressed: authProvider.isLoading ? null : _login,
                      child: authProvider.isLoading
                          ? const CircularProgressIndicator()
                          : const Text('Login'),
                    ),
                  );
                },
              ),
              const SizedBox(height: 16),
              TextButton(
                onPressed: () {
                  Navigator.of(context).pushNamed('/register');
                },
                child: const Text('Don\'t have an account? Register'),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
```

### Product List Screen

Create `lib/screens/products/product_list_screen.dart`:

```dart
import 'package:flutter/material.dart';
import '../../models/product.dart';
import '../../services/product_service.dart';
import '../../widgets/product_card.dart';

class ProductListScreen extends StatefulWidget {
  final int? categoryId;
  final String? searchQuery;

  const ProductListScreen({
    super.key,
    this.categoryId,
    this.searchQuery,
  });

  @override
  State<ProductListScreen> createState() => _ProductListScreenState();
}

class _ProductListScreenState extends State<ProductListScreen> {
  final List<Product> _products = [];
  bool _isLoading = false;
  bool _hasNextPage = true;
  int _currentPage = 1;
  String? _error;

  @override
  void initState() {
    super.initState();
    _loadProducts();
  }

  Future<void> _loadProducts({bool refresh = false}) async {
    if (_isLoading) return;

    setState(() {
      _isLoading = true;
      if (refresh) {
        _products.clear();
        _currentPage = 1;
        _hasNextPage = true;
      }
    });

    try {
      ApiResponse<ProductPagination> response;

      if (widget.categoryId != null) {
        response = await ProductService.getProductsByCategory(
          categoryId: widget.categoryId!,
          page: _currentPage,
        );
      } else if (widget.searchQuery != null) {
        response = await ProductService.searchProducts(
          query: widget.searchQuery!,
          page: _currentPage,
        );
      } else {
        response = await ProductService.getProducts(page: _currentPage);
      }

      if (response.success && response.data != null) {
        setState(() {
          _products.addAll(response.data!.products);
          _hasNextPage = response.data!.hasNextPage;
          _currentPage++;
          _error = null;
        });
      } else {
        setState(() {
          _error = response.message;
        });
      }
    } catch (e) {
      setState(() {
        _error = 'Failed to load products: ${e.toString()}';
      });
    } finally {
      setState(() {
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(
          widget.categoryId != null
              ? 'Category Products'
              : widget.searchQuery != null
                  ? 'Search Results'
                  : 'Products',
        ),
      ),
      body: RefreshIndicator(
        onRefresh: () => _loadProducts(refresh: true),
        child: _error != null
            ? Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Text(_error!),
                    ElevatedButton(
                      onPressed: () => _loadProducts(refresh: true),
                      child: const Text('Retry'),
                    ),
                  ],
                ),
              )
            : NotificationListener<ScrollNotification>(
                onNotification: (ScrollNotification scrollInfo) {
                  if (!_isLoading &&
                      _hasNextPage &&
                      scrollInfo.metrics.pixels ==
                          scrollInfo.metrics.maxScrollExtent) {
                    _loadProducts();
                  }
                  return false;
                },
                child: GridView.builder(
                  padding: const EdgeInsets.all(16),
                  gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                    crossAxisCount: 2,
                    childAspectRatio: 0.7,
                    crossAxisSpacing: 16,
                    mainAxisSpacing: 16,
                  ),
                  itemCount: _products.length + (_isLoading ? 2 : 0),
                  itemBuilder: (context, index) {
                    if (index >= _products.length) {
                      return const Center(child: CircularProgressIndicator());
                    }
                    return ProductCard(product: _products[index]);
                  },
                ),
              ),
      ),
    );
  }
}
```

## 7. Main App Setup

### Main.dart

```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'providers/auth_provider.dart';
import 'screens/auth/login_screen.dart';
import 'screens/auth/register_screen.dart';
import 'screens/home/home_screen.dart';
import 'screens/products/product_list_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => AuthProvider()),
        // Add other providers here
      ],
      child: MaterialApp(
        title: 'Jewelry Shop',
        theme: ThemeData(
          primarySwatch: Colors.amber,
          visualDensity: VisualDensity.adaptivePlatformDensity,
        ),
        initialRoute: '/',
        routes: {
          '/': (context) => const AuthWrapper(),
          '/login': (context) => const LoginScreen(),
          '/register': (context) => const RegisterScreen(),
          '/home': (context) => const HomeScreen(),
          '/products': (context) => const ProductListScreen(),
        },
      ),
    );
  }
}

class AuthWrapper extends StatelessWidget {
  const AuthWrapper({super.key});

  @override
  Widget build(BuildContext context) {
    return Consumer<AuthProvider>(
      builder: (context, authProvider, child) {
        // Check auth status on app start
        WidgetsBinding.instance.addPostFrameCallback((_) {
          authProvider.checkAuthStatus();
        });

        if (authProvider.isLoggedIn) {
          return const HomeScreen();
        } else {
          return const LoginScreen();
        }
      },
    );
  }
}
```

## 8. Testing Your Integration

### 1. Update API Configuration
- Replace `baseUrl` in `ApiConfig` with your actual domain
- For local testing, use appropriate localhost URLs

### 2. Test Authentication Flow
- Register a new user
- Login with credentials
- Check if token is stored and used for authenticated requests

### 3. Test Product Functionality
- Load home screen data
- Browse products with pagination
- Search for products
- Filter by categories

### 4. Error Handling
- Test network connectivity issues
- Test invalid credentials
- Test server errors

## 9. Production Deployment

### API Deployment on Hostinger
1. Upload your Laravel project to Hostinger
2. Update `.env` file with production database credentials
3. Run migrations: `php artisan migrate`
4. Set proper file permissions
5. Configure SSL certificate

### Flutter App Deployment
1. Update `ApiConfig.baseUrl` to your production URL
2. Test thoroughly with production APIs
3. Build and deploy to app stores

## Conclusion

This implementation guide provides a complete foundation for integrating your Flutter app with the Laravel jewelry shop APIs. The APIs are tested and ready for production use. Follow this guide step by step, and you'll have a fully functional Flutter application integrated with your Laravel backend.

Remember to:
- Test all functionality thoroughly
- Handle edge cases and errors gracefully
- Implement proper loading states
- Add offline capabilities if needed
- Follow Flutter and Dart best practices

Your APIs are well-designed and ready for mobile application development!