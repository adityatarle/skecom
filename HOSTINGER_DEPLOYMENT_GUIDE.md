# Hostinger Deployment Guide

## 🚀 Deploy Your Ecommerce API to Hostinger

This guide will help you deploy your Laravel ecommerce API to Hostinger hosting platform.

---

## 📋 Prerequisites

- Hostinger hosting account with PHP 8.1+ support
- Domain name (or subdomain)
- Access to Hostinger control panel
- Database (MySQL) access

---

## 🔧 Step-by-Step Deployment

### 1. Prepare Your Laravel Project

#### A. Update Environment Configuration

Create/update your `.env` file for production:

```env
APP_NAME="Your Ecommerce Store"
APP_ENV=production
APP_KEY=base64:your_generated_key_here
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Razorpay Configuration
RAZORPAY_KEY=rzp_test_your_key_here
RAZORPAY_SECRET=your_secret_here
RAZORPAY_TEST_MODE=true

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"

# API Configuration
API_BASE_URL=https://yourdomain.com/api/v1
```

#### B. Generate Application Key

```bash
php artisan key:generate
```

#### C. Optimize for Production

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Upload to Hostinger

#### A. Using File Manager

1. **Login to Hostinger Control Panel**
2. **Go to File Manager**
3. **Navigate to `public_html` folder**
4. **Upload your Laravel project files**

**Important:** Upload all files EXCEPT the `public` folder contents directly to `public_html`.

#### B. Using FTP/SFTP

1. **Get FTP credentials from Hostinger**
2. **Connect using FileZilla or similar**
3. **Upload files to `public_html`**

### 3. Configure Directory Structure

#### A. Move Public Files

1. **Create a new folder called `laravel` in `public_html`**
2. **Move all Laravel files to `laravel` folder**
3. **Move contents of `laravel/public` to `public_html`**

#### B. Update Index.php

Edit `public_html/index.php`:

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
*/

if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/

require __DIR__.'/../laravel/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

### 4. Database Setup

#### A. Create Database in Hostinger

1. **Go to Hostinger Control Panel**
2. **Click on "Databases" → "MySQL Databases"**
3. **Create a new database**
4. **Create a database user**
5. **Assign user to database with all privileges**

#### B. Run Migrations

1. **Access SSH Terminal in Hostinger** (if available)
2. **Navigate to your Laravel directory**
3. **Run migrations:**

```bash
cd laravel
php artisan migrate
```

**Alternative (if SSH not available):**
- Use phpMyAdmin to import the database structure
- Or create a temporary migration script

### 5. Configure Permissions

Set proper file permissions:

```bash
# Storage directory
chmod -R 755 laravel/storage
chmod -R 755 laravel/bootstrap/cache

# Make sure these directories are writable
chmod 755 laravel/storage/logs
chmod 755 laravel/storage/framework/cache
chmod 755 laravel/storage/framework/sessions
chmod 755 laravel/storage/framework/views
```

### 6. Install Dependencies

#### A. Via SSH (Recommended)

```bash
cd laravel
composer install --optimize-autoloader --no-dev
```

#### B. Via File Manager

1. **Upload `composer.json` and `composer.lock`**
2. **Use Hostinger's Composer tool** (if available)
3. **Or download vendor folder locally and upload**

### 7. Configure Web Server

#### A. Create .htaccess

Create `.htaccess` in `public_html`:

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

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# Enable CORS for API
<IfModule mod_headers.c>
    Header always set Access-Control-Allow-Origin "*"
    Header always set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, PATCH, OPTIONS"
    Header always set Access-Control-Allow-Headers "Content-Type, Authorization, Accept"
</IfModule>
```

### 8. Test Your API

#### A. Health Check

Visit: `https://yourdomain.com/api/health`

Expected response:
```json
{
    "status": "success",
    "message": "API is running",
    "timestamp": "2024-01-01T00:00:00.000000Z"
}
```

#### B. Test Authentication

```bash
curl -X POST https://yourdomain.com/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### 9. SSL Configuration

#### A. Enable SSL in Hostinger

1. **Go to Hostinger Control Panel**
2. **Click on "SSL"**
3. **Enable SSL for your domain**
4. **Wait for SSL to activate (usually 5-10 minutes)**

#### B. Force HTTPS

Add to your `.htaccess`:

```apache
# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 10. Performance Optimization

#### A. Enable Caching

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

#### B. Optimize Composer

```bash
composer install --optimize-autoloader --no-dev
```

#### C. Set Proper Permissions

```bash
# Make storage writable
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

## 🔍 Troubleshooting

### Common Issues

#### 1. 500 Internal Server Error

**Check:**
- File permissions
- `.env` file exists
- Database connection
- PHP version compatibility

**Solution:**
```bash
# Check error logs
tail -f storage/logs/laravel.log

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

#### 2. Database Connection Error

**Check:**
- Database credentials in `.env`
- Database exists
- User has proper permissions

**Solution:**
```bash
# Test database connection
php artisan tinker
DB::connection()->getPdo();
```

#### 3. API Endpoints Not Working

**Check:**
- Routes are cached
- `.htaccess` is correct
- CORS configuration

**Solution:**
```bash
# Clear route cache
php artisan route:clear
php artisan route:cache
```

#### 4. File Upload Issues

**Check:**
- Storage directory permissions
- File size limits in PHP
- Upload directory exists

**Solution:**
```bash
# Create symbolic link
php artisan storage:link

# Set permissions
chmod -R 755 storage/app/public
```

---

## 📱 Mobile App Configuration

### Update Flutter App

In your Flutter app, update the base URL:

```dart
// lib/services/api_config.dart
class ApiConfig {
  static const String baseUrl = 'https://yourdomain.com/api/v1';
  // ... rest of the code
}
```

### Test API Endpoints

Use the provided Postman collection to test all endpoints:

1. **Import** `Ecommerce_API.postman_collection.json`
2. **Update** the `base_url` variable to your domain
3. **Test** all endpoints

---

## 🔒 Security Checklist

- [ ] SSL certificate enabled
- [ ] `.env` file not accessible via web
- [ ] Database credentials secure
- [ ] File permissions set correctly
- [ ] Error reporting disabled in production
- [ ] CORS configured properly
- [ ] Rate limiting enabled
- [ ] Input validation working
- [ ] SQL injection protection active

---

## 📊 Monitoring

### 1. Error Logs

Monitor error logs:
```bash
tail -f storage/logs/laravel.log
```

### 2. Performance

Use Hostinger's built-in monitoring tools:
- Resource usage
- Response times
- Error rates

### 3. API Health

Create a monitoring endpoint:
```php
// routes/api.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});
```

---

## 🎉 Deployment Complete!

Your API is now live at: `https://yourdomain.com/api/v1`

**Next Steps:**
1. **Test all endpoints** using Postman
2. **Update Flutter app** with new base URL
3. **Monitor performance** and error logs
4. **Set up backups** for database
5. **Configure monitoring** alerts

**Support:**
- Hostinger Support: Available 24/7
- Laravel Documentation: https://laravel.com/docs
- API Documentation: Check `API_DOCUMENTATION.md`

---

## 📞 Quick Reference

**API Base URL:** `https://yourdomain.com/api/v1`  
**Health Check:** `https://yourdomain.com/api/health`  
**Documentation:** `https://yourdomain.com/api/docs` (if you set up API docs)

**Emergency Contacts:**
- Hostinger Support: Available in control panel
- Laravel Community: https://laravel.io/forum
- Stack Overflow: Tag with `laravel` and `api`