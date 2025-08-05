# API Troubleshooting Guide

## 🚨 Current Issue: API Returning 404 Error

Your API endpoint `https://staging.skornaments.com/api/v1` is returning a 404 error page instead of API responses. Here's how to fix it:

---

## 🔍 Step-by-Step Troubleshooting

### 1. **Test Basic API Access**

First, test these URLs to see which ones work:

```
✅ https://staging.skornaments.com/api/test
✅ https://staging.skornaments.com/api/health
❌ https://staging.skornaments.com/api/v1 (This is the problem)
```

### 2. **Check Laravel Route Caching**

The most common cause is cached routes. Run these commands on your server:

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Clear route cache specifically
php artisan route:cache

# List all API routes to verify they exist
php artisan route:list --path=api
```

### 3. **Verify API Routes Are Loaded**

Check if your API routes are being loaded by running:

```bash
php artisan route:list | grep api
```

You should see routes like:
- `api/test`
- `api/health`
- `api/v1/register`
- `api/v1/login`
- etc.

### 4. **Check RouteServiceProvider**

Make sure your `app/Providers/RouteServiceProvider.php` loads API routes:

```php
public function boot(): void
{
    $this->routes(function () {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    });
}
```

### 5. **Test Individual Endpoints**

Try these specific endpoints:

```bash
# Test basic API
curl https://staging.skornaments.com/api/test

# Test health check
curl https://staging.skornaments.com/api/health

# Test v1 endpoint
curl https://staging.skornaments.com/api/v1/products
```

### 6. **Check .htaccess Configuration**

Make sure your `.htaccess` file in the `public` directory is correct:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 7. **Check for Route Conflicts**

Make sure there are no conflicting routes in `routes/web.php` that might catch API requests.

### 8. **Verify Controllers Exist**

Check if all API controllers exist:

```bash
ls app/Http/Controllers/Api/
```

Should show:
- AuthController.php
- ProductController.php
- CategoryController.php
- CartController.php
- WishlistController.php
- OrderController.php
- UserController.php
- ReviewController.php
- PaymentController.php
- MainController.php

---

## 🛠️ Quick Fixes

### Fix 1: Clear All Caches (Most Common Solution)

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan route:cache
```

### Fix 2: Restart Web Server

```bash
# For Apache
sudo service apache2 restart

# For Nginx
sudo service nginx restart

# For PHP-FPM
sudo service php8.1-fpm restart
```

### Fix 3: Check File Permissions

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Fix 4: Verify .env Configuration

Make sure your `.env` file has:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://staging.skornaments.com
```

---

## 🧪 Testing Commands

### Test 1: Basic API Access

```bash
curl -X GET https://staging.skornaments.com/api/test
```

Expected response:
```json
{
    "status": "success",
    "message": "API is working!",
    "timestamp": "2024-01-01T00:00:00.000000Z",
    "version": "1.0.0"
}
```

### Test 2: Health Check

```bash
curl -X GET https://staging.skornaments.com/api/health
```

### Test 3: Products API

```bash
curl -X GET https://staging.skornaments.com/api/v1/products
```

### Test 4: Register User

```bash
curl -X POST https://staging.skornaments.com/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

---

## 🔧 Manual Debugging

### Step 1: Enable Debug Mode

Temporarily enable debug mode in `.env`:

```env
APP_DEBUG=true
```

### Step 2: Check Error Logs

```bash
tail -f storage/logs/laravel.log
```

### Step 3: Test with Simple Route

Add this to `routes/api.php` at the very top:

```php
Route::get('/debug', function () {
    return response()->json([
        'message' => 'API routes are working',
        'routes' => Route::getRoutes()->get('GET'),
        'timestamp' => now()
    ]);
});
```

Then test: `https://staging.skornaments.com/api/debug`

---

## 📱 Thunder Client Testing

### 1. **Test Basic Endpoints**

In Thunder Client, test these URLs:

```
GET https://staging.skornaments.com/api/test
GET https://staging.skornaments.com/api/health
GET https://staging.skornaments.com/api/v1/products
```

### 2. **Test Authentication**

```
POST https://staging.skornaments.com/api/v1/register
Content-Type: application/json

{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### 3. **Test with Headers**

Make sure to include proper headers:

```
Content-Type: application/json
Accept: application/json
```

---

## 🚨 Common Issues & Solutions

### Issue 1: Routes Not Loading
**Solution:** Clear route cache and restart web server

### Issue 2: 404 on All API Routes
**Solution:** Check .htaccess and file permissions

### Issue 3: 500 Server Error
**Solution:** Check Laravel logs and enable debug mode

### Issue 4: CORS Issues
**Solution:** Verify CORS configuration in `config/cors.php`

### Issue 5: Authentication Issues
**Solution:** Check Sanctum configuration and middleware

---

## 📞 Next Steps

1. **Try the cache clearing commands first**
2. **Test the basic endpoints** (`/api/test`, `/api/health`)
3. **Check the Laravel logs** for specific errors
4. **Verify all controllers exist**
5. **Test with Thunder Client** using the provided examples

---

## 🎯 Expected Results

After fixing, you should be able to access:

✅ `https://staging.skornaments.com/api/test`  
✅ `https://staging.skornaments.com/api/health`  
✅ `https://staging.skornaments.com/api/v1/products`  
✅ `https://staging.skornaments.com/api/v1/register`  

**If you're still getting 404 errors after trying these steps, please share:**
1. The output of `php artisan route:list --path=api`
2. Any errors from `storage/logs/laravel.log`
3. The response from `https://staging.skornaments.com/api/test`