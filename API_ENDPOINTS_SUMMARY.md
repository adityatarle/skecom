# API Endpoints Summary

## 🚀 Quick Reference for Flutter Development

**Base URL:** `https://yourdomain.com/api/v1`  
**Authentication:** Bearer Token  
**Content-Type:** `application/json`

---

## 📋 All API Endpoints

### 🔐 Authentication
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/register` | Register new user | ❌ |
| POST | `/login` | Login user | ❌ |
| POST | `/user/logout` | Logout user | ✅ |
| POST | `/forgot-password` | Send password reset | ❌ |
| POST | `/reset-password` | Reset password | ❌ |

### 📦 Products
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/products` | Get all products | ❌ |
| GET | `/products/{id}` | Get product details | ❌ |
| GET | `/products/search` | Search products | ❌ |
| GET | `/products/filter` | Filter products | ❌ |

### 🗂️ Categories
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/categories` | Get all categories | ❌ |
| GET | `/categories/{id}` | Get category details | ❌ |
| GET | `/categories/{id}/products` | Get products by category | ❌ |

### 🛒 Cart (Guest)
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/cart/add` | Add to cart | ❌ |
| GET | `/cart` | Get cart | ❌ |
| DELETE | `/cart/remove/{id}` | Remove from cart | ❌ |
| PATCH | `/cart/update/{id}` | Update quantity | ❌ |
| DELETE | `/cart/clear` | Clear cart | ❌ |
| GET | `/cart/count` | Get cart count | ❌ |

### 🛒 Cart (User)
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/user/cart/add` | Add to cart | ✅ |
| GET | `/user/cart` | Get cart | ✅ |
| DELETE | `/user/cart/remove/{id}` | Remove from cart | ✅ |
| PATCH | `/user/cart/update/{id}` | Update quantity | ✅ |
| DELETE | `/user/cart/clear` | Clear cart | ✅ |

### ❤️ Wishlist (Guest)
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/wishlist/add` | Add to wishlist | ❌ |
| GET | `/wishlist` | Get wishlist | ❌ |
| DELETE | `/wishlist/remove/{id}` | Remove from wishlist | ❌ |
| GET | `/wishlist/count` | Get wishlist count | ❌ |

### ❤️ Wishlist (User)
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/user/wishlist/add` | Add to wishlist | ✅ |
| GET | `/user/wishlist` | Get wishlist | ✅ |
| DELETE | `/user/wishlist/remove/{id}` | Remove from wishlist | ✅ |

### 📋 Orders
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/orders` | Get user orders | ✅ |
| POST | `/orders` | Create order | ✅ |
| GET | `/orders/{id}` | Get order details | ✅ |
| POST | `/orders/{id}/reorder` | Reorder | ✅ |
| GET | `/orders/{id}/track` | Track order | ✅ |

### 💳 Payments
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/payment/create-order` | Create payment order | ❌ |
| POST | `/payment/verify` | Verify payment | ✅ |

### 👤 User Profile
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/user/profile` | Get profile | ✅ |
| PUT | `/user/profile` | Update profile | ✅ |
| POST | `/user/change-password` | Change password | ✅ |

### ⭐ Reviews
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/reviews` | Get user reviews | ✅ |
| POST | `/reviews` | Create review | ✅ |
| PUT | `/reviews/{id}` | Update review | ✅ |
| DELETE | `/reviews/{id}` | Delete review | ✅ |

### 📄 Static Pages
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/home` | Home page data | ❌ |
| GET | `/about` | About page | ❌ |
| GET | `/contact` | Contact info | ❌ |
| POST | `/contact` | Submit contact form | ❌ |
| GET | `/privacy-policy` | Privacy policy | ❌ |
| GET | `/terms-conditions` | Terms & conditions | ❌ |
| GET | `/shipping-policy` | Shipping policy | ❌ |
| GET | `/return-policy` | Return policy | ❌ |

---

## 🔑 Authentication Headers

For protected endpoints, include:

```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

---

## 📝 Request Examples

### Register User
```json
POST /register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "+1234567890",
  "address": "123 Main St"
}
```

### Login
```json
POST /login
{
  "email": "john@example.com",
  "password": "password123"
}
```

### Add to Cart
```json
POST /user/cart/add
{
  "product_id": 1,
  "quantity": 2
}
```

### Create Order
```json
POST /orders
{
  "products": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ],
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "street_address": "123 Main St",
  "city": "City",
  "state": "State",
  "country": "Country",
  "payment_method": "cash_on_delivery"
}
```

---

## 📊 Response Format

### Success Response
```json
{
  "status": "success",
  "message": "Operation completed",
  "data": {
    // Response data here
  }
}
```

### Error Response
```json
{
  "status": "error",
  "message": "Error description",
  "errors": {
    "field_name": ["Validation error"]
  }
}
```

---

## 🔍 Pagination

Most list endpoints support pagination:

```
GET /products?page=1&per_page=12&sort_by=name&sort_order=asc
```

Response includes:
```json
{
  "pagination": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 12,
    "total": 50,
    "from": 1,
    "to": 12
  }
}
```

---

## 🚨 Error Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 422 | Validation Error |
| 500 | Server Error |

---

## 🧪 Testing

### Health Check
```
GET /health
```

### Test Credentials
- **Email:** `test@example.com`
- **Password:** `password123`

### Postman Collection
Import `Ecommerce_API.postman_collection.json` for ready-to-use API tests.

---

## 📱 Flutter Integration

### Base Configuration
```dart
class ApiConfig {
  static const String baseUrl = 'https://yourdomain.com/api/v1';
  
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
}
```

### Quick Test
```dart
// Test API connection
final response = await http.get(
  Uri.parse('${ApiConfig.baseUrl}/health'),
  headers: ApiConfig.getHeaders(),
);

if (response.statusCode == 200) {
  print('API is working!');
}
```

---

## 🎯 Ready to Use!

Your colleague can now:

1. **Copy the endpoints** from this summary
2. **Use the Flutter integration guide** for complete implementation
3. **Test with Postman collection** before coding
4. **Start building the mobile app** immediately

**All endpoints are production-ready and tested!** 🚀