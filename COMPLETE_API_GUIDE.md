# Complete API Setup Guide

## 🚀 **Step-by-Step API Setup for SK Ornaments**

### **Prerequisites**
- Laravel application running on XAMPP
- Same database for website and mobile app
- Shared user authentication system

---

## 📋 **Step 1: Fix Route Loading Issue**

### **Problem:** Only 1 API route showing up
### **Solution:** Update bootstrap/app.php

Your `bootstrap/app.php` was missing the API routes configuration. I've already fixed it:

```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',  // ← This was missing!
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
```

---

## 🔧 **Step 2: Clear All Caches**

Run these commands in your terminal:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan route:cache
```

**Or use the batch file I created:**
```bash
clear-cache.bat
```

---

## ✅ **Step 3: Verify Routes Are Loaded**

After clearing cache, run:
```bash
php artisan route:list --path=api
```

You should now see **40+ routes** instead of just 1:

```
GET|HEAD       api/test ...................................................... 
GET|HEAD       api/health ................................................... 
POST           api/v1/register ............................................. 
POST           api/v1/login ............................................... 
GET|HEAD       api/v1/products ............................................ 
GET|HEAD       api/v1/products/{product} .................................. 
POST           api/v1/cart/add ............................................ 
GET|HEAD       api/v1/cart ................................................ 
... (and many more)
```

---

## 🧪 **Step 4: Test API Endpoints**

### **Test 1: Basic API Test**
```bash
curl -X GET http://localhost/sk/api/test
```

**Expected Response:**
```json
{
    "status": "success",
    "message": "API is working!",
    "timestamp": "2024-01-01T00:00:00.000000Z",
    "version": "1.0.0"
}
```

### **Test 2: Health Check**
```bash
curl -X GET http://localhost/sk/api/health
```

### **Test 3: Products API**
```bash
curl -X GET http://localhost/sk/api/v1/products
```

### **Test 4: User Registration**
```bash
curl -X POST http://localhost/sk/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

---

## 📱 **Step 5: Mobile App Integration**

### **Base URL Configuration**
For local development:
```
Base URL: http://localhost/sk/api/v1
```

For production (Hostinger):
```
Base URL: https://staging.skornaments.com/api/v1
```

### **Shared Database Benefits**
✅ **Same user accounts** for website and mobile app  
✅ **Shared cart/wishlist** data  
✅ **Unified order management**  
✅ **Consistent product catalog**  
✅ **Single authentication system**  

---

## 🔐 **Step 6: Authentication Flow**

### **User Registration**
```http
POST /api/v1/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "+1234567890",
    "address": "123 Main St"
}
```

**Response:**
```json
{
    "status": "success",
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "token": "1|abc123..."
    }
}
```

### **User Login**
```http
POST /api/v1/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

### **Using Authentication Token**
```http
GET /api/v1/user/profile
Authorization: Bearer 1|abc123...
```

---

## 🛒 **Step 7: Cart & Wishlist**

### **Guest Cart (Session-based)**
```http
POST /api/v1/cart/add
Content-Type: application/json

{
    "product_id": 1,
    "quantity": 2
}
```

### **User Cart (Database-based)**
```http
POST /api/v1/user/cart/add
Authorization: Bearer {token}
Content-Type: application/json

{
    "product_id": 1,
    "quantity": 2
}
```

---

## 📦 **Step 8: Product Management**

### **Get All Products**
```http
GET /api/v1/products?page=1&per_page=12
```

### **Get Product Details**
```http
GET /api/v1/products/1
```

### **Search Products**
```http
GET /api/v1/products/search?query=diamond
```

### **Filter Products**
```http
GET /api/v1/products/filter?category_id=1&min_price=100&max_price=1000
```

---

## 📋 **Step 9: Order Management**

### **Create Order**
```http
POST /api/v1/orders
Authorization: Bearer {token}
Content-Type: application/json

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

### **Get User Orders**
```http
GET /api/v1/orders
Authorization: Bearer {token}
```

---

## 💳 **Step 10: Payment Integration**

### **Create Payment Order**
```http
POST /api/v1/payment/create-order
Content-Type: application/json

{
    "amount": 1000,
    "currency": "INR",
    "receipt": "order_123"
}
```

### **Verify Payment**
```http
POST /api/v1/payment/verify
Authorization: Bearer {token}
Content-Type: application/json

{
    "razorpay_payment_id": "pay_123",
    "razorpay_order_id": "order_123",
    "razorpay_signature": "signature_123"
}
```

---

## 🧪 **Step 11: Testing with Thunder Client**

### **1. Import Collection**
Import `Ecommerce_API.postman_collection.json` into Thunder Client

### **2. Set Environment Variables**
```
base_url: http://localhost/sk/api/v1
token: (will be set after login)
```

### **3. Test Authentication**
1. Send registration request
2. Copy token from response
3. Set token in environment variables
4. Test authenticated endpoints

---

## 📊 **Step 12: Database Schema**

### **Shared Tables**
- `users` - User accounts (shared)
- `products` - Product catalog (shared)
- `orders` - Order management (shared)
- `carts` - User cart items (shared)
- `wishlists` - User wishlist (shared)
- `reviews` - Product reviews (shared)
- `categories` - Product categories (shared)

### **Mobile App Specific**
- Uses same database
- Same authentication system
- Same product catalog
- Same order processing

---

## 🔧 **Step 13: Environment Configuration**

### **Local Development (.env)**
```env
APP_URL=http://localhost/sk
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sk_ornaments
DB_USERNAME=root
DB_PASSWORD=

# Razorpay (for payments)
RAZORPAY_KEY=rzp_test_your_key
RAZORPAY_SECRET=your_secret
```

### **Production (.env)**
```env
APP_URL=https://staging.skornaments.com
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Razorpay (for payments)
RAZORPAY_KEY=rzp_live_your_key
RAZORPAY_SECRET=your_live_secret
```

---

## 🚀 **Step 14: Deployment Checklist**

### **Before Deploying to Hostinger:**
- [ ] Clear all caches
- [ ] Test all API endpoints locally
- [ ] Update base URL in mobile app
- [ ] Configure production database
- [ ] Set up SSL certificate
- [ ] Test payment integration
- [ ] Verify CORS settings

### **After Deployment:**
- [ ] Test API endpoints on production
- [ ] Verify mobile app connectivity
- [ ] Test user registration/login
- [ ] Test order creation
- [ ] Test payment processing
- [ ] Monitor error logs

---

## 📱 **Step 15: Mobile App Integration**

### **Flutter Configuration**
```dart
class ApiConfig {
  // Local development
  static const String baseUrl = 'http://localhost/sk/api/v1';
  
  // Production
  // static const String baseUrl = 'https://staging.skornaments.com/api/v1';
}
```

### **Shared Authentication**
- Same login credentials work on website and mobile app
- Token-based authentication
- Automatic token refresh
- Secure token storage

---

## 🎯 **Expected Results**

After completing all steps:

✅ **40+ API endpoints** available  
✅ **Shared database** between website and mobile app  
✅ **Unified authentication** system  
✅ **Real-time cart/wishlist** sync  
✅ **Secure payment** processing  
✅ **Complete order** management  

---

## 🆘 **Troubleshooting**

### **If Routes Still Not Loading:**
1. Check `storage/logs/laravel.log` for errors
2. Verify `bootstrap/app.php` has API routes
3. Clear all caches again
4. Restart XAMPP

### **If API Returns 404:**
1. Check `.htaccess` file
2. Verify file permissions
3. Test with simple endpoint first
4. Check web server configuration

### **If Authentication Fails:**
1. Verify database connection
2. Check user table structure
3. Test with known credentials
4. Check Sanctum configuration

---

## 📞 **Support**

**Files Created:**
- `COMPLETE_API_GUIDE.md` - This guide
- `clear-cache.bat` - Cache clearing script
- `test-api.php` - API testing script
- Updated `bootstrap/app.php` - Route configuration
- Updated `public/.htaccess` - Server configuration

**Next Steps:**
1. Run `clear-cache.bat`
2. Test `php artisan route:list --path=api`
3. Test basic endpoints
4. Share results with your colleague

**Your API will be ready for mobile app development!** 🚀