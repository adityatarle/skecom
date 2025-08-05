# Hostinger Deployment Guide for Laravel Jewelry Shop

## Overview

This guide provides step-by-step instructions for deploying your Laravel jewelry shop project to Hostinger hosting. Your APIs have been tested and are ready for production deployment.

## Prerequisites

- ✅ Hostinger hosting account with PHP support
- ✅ Domain name configured
- ✅ Laravel project tested locally
- ✅ Database requirements understood
- ✅ SSL certificate (recommended)

## 1. Pre-Deployment Preparation

### Update Environment Configuration

Before deployment, update your `.env` file for production:

```env
APP_NAME="Jewelry Shop"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Mail Configuration (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your-email@your-domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"

# Sanctum Configuration
SANCTUM_STATEFUL_DOMAINS=your-domain.com
```

### Optimize for Production

Run these commands locally before deployment:

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

# Install production dependencies
composer install --optimize-autoloader --no-dev
```

## 2. Hostinger Setup

### Access Your Hosting Panel

1. Log in to your Hostinger account
2. Go to "Hosting" in the main menu
3. Click "Manage" next to your hosting plan
4. Access the File Manager or use FTP

### Database Setup

1. **Create Database:**
   - Go to "Databases" → "MySQL Databases"
   - Create a new database (e.g., `u123456789_jewelry_shop`)
   - Create a database user with full privileges
   - Note down the database credentials

2. **Database Connection:**
   - Host: `localhost`
   - Port: `3306`
   - Database name: Your created database
   - Username: Your database user
   - Password: Your database password

## 3. File Upload Methods

### Method 1: File Manager (Recommended for Small Projects)

1. **Access File Manager:**
   - In Hostinger panel, click "File Manager"
   - Navigate to `public_html` folder

2. **Upload Project:**
   - Create a ZIP file of your Laravel project
   - Upload the ZIP file to `public_html`
   - Extract the ZIP file
   - Move all files from the extracted folder to `public_html`

### Method 2: FTP (Recommended for Large Projects)

1. **Get FTP Credentials:**
   - In Hostinger panel, go to "Files" → "FTP Accounts"
   - Use the main FTP account or create a new one

2. **Upload via FTP:**
   - Use an FTP client like FileZilla
   - Connect using your FTP credentials
   - Upload all project files to `public_html`

### Method 3: Git (Advanced)

1. **Enable SSH (if available):**
   - Check if your Hostinger plan supports SSH
   - Generate SSH keys if needed

2. **Clone Repository:**
   ```bash
   cd public_html
   git clone https://github.com/your-username/jewelry-shop.git .
   ```

## 4. Post-Upload Configuration

### File Structure

Your `public_html` folder should look like this:

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── index.php
│   ├── .htaccess
│   └── assets/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
├── composer.json
└── composer.lock
```

### Important: Document Root Configuration

**Critical Step:** The document root should point to the `public` folder, not the project root.

#### Option 1: Move Public Contents (Recommended)

1. Move all contents from `public/` folder to `public_html/`
2. Update `index.php` paths:

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Update these paths
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();
$kernel->terminate($request, $response);
```

#### Option 2: Subdomain/Subdirectory

If you prefer to keep the structure intact:
- Upload project to a subdirectory (e.g., `public_html/api/`)
- Access via `https://your-domain.com/api/`

### Set File Permissions

Set proper permissions for Laravel:

```bash
# If you have SSH access
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Via File Manager
# Right-click on folders → Permissions
# Set storage/ and bootstrap/cache/ to 755
```

### Environment Configuration

1. **Upload .env file:**
   - Create `.env` file in your project root
   - Copy your production environment variables
   - **Never commit .env to version control**

2. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

## 5. Database Migration

### Run Migrations

1. **Via SSH (if available):**
   ```bash
   cd public_html
   php artisan migrate --force
   ```

2. **Via Web Interface:**
   - Create a temporary migration script
   - Upload and run it via browser
   - Remove the script after use

3. **Manual Database Import:**
   - Export your local database
   - Import via Hostinger's phpMyAdmin
   - Update any hardcoded URLs or paths

### Seed Database (Optional)

```bash
php artisan db:seed --force
```

## 6. Configure Web Server

### .htaccess Configuration

Ensure your `.htaccess` file in the document root contains:

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

### PHP Configuration

Create a `php.ini` file in your document root:

```ini
memory_limit = 256M
max_execution_time = 300
max_input_vars = 3000
upload_max_filesize = 64M
post_max_size = 64M
```

## 7. SSL Certificate Setup

### Enable SSL in Hostinger

1. Go to "Security" → "SSL"
2. Enable "Force HTTPS" 
3. Wait for SSL certificate activation

### Update Application URLs

Update your `.env` file:
```env
APP_URL=https://your-domain.com
```

## 8. Testing Your Deployment

### Basic Functionality Tests

1. **Website Access:**
   - Visit `https://your-domain.com`
   - Check if Laravel welcome page loads

2. **API Endpoints:**
   ```bash
   # Test health endpoint
   curl https://your-domain.com/api/health
   
   # Test products endpoint
   curl https://your-domain.com/api/v1/products
   
   # Test categories endpoint
   curl https://your-domain.com/api/v1/categories
   ```

3. **Authentication:**
   ```bash
   # Test registration
   curl -X POST https://your-domain.com/api/v1/register \
        -H "Content-Type: application/json" \
        -d '{"name":"Test User","email":"test@example.com","password":"password123","password_confirmation":"password123"}'
   ```

### Performance Testing

1. **Page Load Speed:**
   - Use tools like GTmetrix or PageSpeed Insights
   - Optimize images and assets if needed

2. **API Response Time:**
   - Test API endpoints for response time
   - Monitor database query performance

## 9. Optimization for Production

### Caching

```bash
# Enable all caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Composer Optimization

```bash
composer install --optimize-autoloader --no-dev
composer dump-autoload --optimize
```

### Asset Optimization

1. **Minify CSS/JS:**
   - Use Laravel Mix for asset compilation
   - Enable minification in production

2. **Image Optimization:**
   - Compress images before upload
   - Use WebP format where possible

## 10. Monitoring and Maintenance

### Log Monitoring

1. **Laravel Logs:**
   - Monitor `storage/logs/laravel.log`
   - Set up log rotation

2. **Server Logs:**
   - Check Hostinger error logs
   - Monitor resource usage

### Backup Strategy

1. **Database Backups:**
   - Set up automated database backups
   - Export database regularly

2. **File Backups:**
   - Backup uploaded files and user data
   - Keep multiple backup versions

### Security Measures

1. **Regular Updates:**
   - Keep Laravel and dependencies updated
   - Monitor security advisories

2. **Access Control:**
   - Use strong passwords
   - Enable two-factor authentication
   - Limit FTP/SSH access

## 11. Troubleshooting Common Issues

### 500 Internal Server Error

1. **Check Error Logs:**
   - Look at Hostinger error logs
   - Check `storage/logs/laravel.log`

2. **Common Fixes:**
   ```bash
   # Clear all caches
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   
   # Fix permissions
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   ```

### Database Connection Issues

1. **Verify Credentials:**
   - Double-check database credentials in `.env`
   - Test connection via phpMyAdmin

2. **Connection Timeout:**
   - Increase `max_execution_time` in php.ini
   - Check database server status

### API Not Working

1. **Route Issues:**
   ```bash
   php artisan route:clear
   php artisan route:cache
   ```

2. **CORS Issues:**
   - Configure CORS for API access
   - Check browser developer tools

### Performance Issues

1. **Enable Caching:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Optimize Database:**
   - Add database indexes
   - Optimize slow queries

## 12. Flutter App Configuration

After successful deployment, update your Flutter app:

```dart
// lib/config/api_config.dart
class ApiConfig {
  static const String baseUrl = 'https://your-domain.com/api/v1';
  // Remove localhost URLs
}
```

## 13. Final Checklist

### Pre-Launch Checklist

- [ ] SSL certificate installed and working
- [ ] Database migrated successfully
- [ ] All API endpoints tested
- [ ] Authentication working properly
- [ ] File permissions set correctly
- [ ] Caches optimized for production
- [ ] Error pages customized
- [ ] Backup system in place
- [ ] Monitoring tools configured

### Post-Launch Monitoring

- [ ] Monitor error logs daily
- [ ] Check API response times
- [ ] Monitor database performance
- [ ] Regular security updates
- [ ] Backup verification
- [ ] User feedback collection

## Conclusion

🎉 **Your Laravel Jewelry Shop is now deployed on Hostinger!**

Your APIs are production-ready and optimized for Flutter application development. The deployment includes:

- ✅ Secure HTTPS access
- ✅ Optimized performance
- ✅ Database properly configured
- ✅ Authentication system working
- ✅ All API endpoints functional

Your Flutter app can now connect to the production APIs and provide a seamless shopping experience for your customers.

### Support Resources

- **Hostinger Documentation:** https://support.hostinger.com
- **Laravel Documentation:** https://laravel.com/docs
- **API Testing Tools:** Postman, Insomnia
- **Monitoring Tools:** Google Analytics, Uptime Robot

Remember to keep your application updated and monitor its performance regularly for the best user experience!