# Ecommerce Mobile App API Documentation

## Overview

This API provides comprehensive functionality for the ecommerce mobile application, including user authentication, product management, cart operations, order processing, and payment integration.

**Base URL:** `https://yourdomain.com/api/v1`

**Authentication:** Bearer Token (Laravel Sanctum)

---

## Table of Contents

1. [Authentication](#authentication)
2. [Products](#products)
3. [Categories](#categories)
4. [Cart Management](#cart-management)
5. [Wishlist Management](#wishlist-management)
6. [Orders](#orders)
7. [User Management](#user-management)
8. [Reviews](#reviews)
9. [Payments](#payments)
10. [Static Pages](#static-pages)
11. [Admin Endpoints](#admin-endpoints)
12. [Error Handling](#error-handling)

---

## Authentication

### Register User

**POST** `/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "+1234567890",
    "address": "123 Main St, City, State"
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
            "email": "john@example.com",
            "phone": "+1234567890",
            "address": "123 Main St, City, State",
            "role": "customer",
            "created_at": "2024-01-01T00:00:00.000000Z"
        },
        "token": "1|abc123...",
        "token_type": "Bearer"
    }
}
```

### Login User

**POST** `/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "status": "success",
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+1234567890",
            "address": "123 Main St, City, State",
            "role": "customer"
        },
        "token": "1|abc123...",
        "token_type": "Bearer"
    }
}
```

### Forgot Password

**POST** `/forgot-password`

**Request Body:**
```json
{
    "email": "john@example.com"
}
```

### Reset Password

**POST** `/reset-password`

**Request Body:**
```json
{
    "token": "reset_token_here",
    "email": "john@example.com",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

### Logout

**POST** `/user/logout`

**Headers:** `Authorization: Bearer {token}`

---

## Products

### Get All Products

**GET** `/products`

**Query Parameters:**
- `per_page` (optional): Number of items per page (default: 12)
- `sort_by` (optional): Sort field (name, price, created_at)
- `sort_order` (optional): Sort direction (asc, desc)

**Response:**
```json
{
    "status": "success",
    "data": {
        "products": [
            {
                "id": 1,
                "name": "Product Name",
                "description": "Product description",
                "price": "99.99",
                "image_path": "/images/product.jpg",
                "category": {
                    "id": 1,
                    "name": "Category Name"
                },
                "subcategory": {
                    "id": 1,
                    "name": "Subcategory Name"
                },
                "images": [
                    {
                        "id": 1,
                        "image_path": "/images/product1.jpg"
                    }
                ]
            }
        ],
        "pagination": {
            "current_page": 1,
            "last_page": 5,
            "per_page": 12,
            "total": 50,
            "from": 1,
            "to": 12
        }
    }
}
```

### Get Product Details

**GET** `/products/{id}`

**Response:**
```json
{
    "status": "success",
    "data": {
        "product": {
            "id": 1,
            "name": "Product Name",
            "description": "Product description",
            "price": "99.99",
            "image_path": "/images/product.jpg",
            "category": {
                "id": 1,
                "name": "Category Name"
            },
            "subcategory": {
                "id": 1,
                "name": "Subcategory Name"
            },
            "images": [...],
            "pricing_details": [...]
        },
        "pricing_breakup": {
            "components": [...],
            "subtotal": 99.99,
            "labour_charges": 10.00,
            "gst_percentage": 18,
            "gst_amount": 19.80,
            "grand_total": 129.79
        },
        "related_products": [...]
    }
}
```

### Search Products

**GET** `/products/search`

**Query Parameters:**
- `query` (required): Search term
- `per_page` (optional): Number of items per page

### Filter Products

**GET** `/products/filter`

**Query Parameters:**
- `category_id` (optional): Filter by category
- `sub_category_id` (optional): Filter by subcategory
- `min_price` (optional): Minimum price
- `max_price` (optional): Maximum price
- `sort_by` (optional): Sort field
- `sort_order` (optional): Sort direction

---

## Categories

### Get All Categories

**GET** `/categories`

**Response:**
```json
{
    "status": "success",
    "data": {
        "categories": [
            {
                "id": 1,
                "name": "Category Name",
                "description": "Category description",
                "image_path": "/images/category.jpg",
                "subcategories": [
                    {
                        "id": 1,
                        "name": "Subcategory Name"
                    }
                ]
            }
        ]
    }
}
```

### Get Category Details

**GET** `/categories/{id}`

### Get Products by Category

**GET** `/categories/{id}/products`

**Query Parameters:**
- `sub_category_id` (optional): Filter by subcategory
- `per_page` (optional): Number of items per page
- `sort_by` (optional): Sort field
- `sort_order` (optional): Sort direction

---

## Cart Management

### Guest Cart (Session-based)

#### Add to Cart

**POST** `/cart/add`

**Request Body:**
```json
{
    "product_id": 1,
    "quantity": 2
}
```

#### Get Cart

**GET** `/cart`

#### Remove from Cart

**DELETE** `/cart/remove/{product_id}`

#### Update Quantity

**PATCH** `/cart/update/{product_id}`

**Request Body:**
```json
{
    "quantity": 3
}
```

#### Clear Cart

**DELETE** `/cart/clear`

#### Get Cart Count

**GET** `/cart/count`

### Authenticated User Cart (Database-based)

#### Add to Cart

**POST** `/user/cart/add`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "product_id": 1,
    "quantity": 2
}
```

#### Get Cart

**GET** `/user/cart`

**Headers:** `Authorization: Bearer {token}`

#### Remove from Cart

**DELETE** `/user/cart/remove/{cart_item_id}`

**Headers:** `Authorization: Bearer {token}`

#### Update Quantity

**PATCH** `/user/cart/update/{cart_item_id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "quantity": 3
}
```

#### Clear Cart

**DELETE** `/user/cart/clear`

**Headers:** `Authorization: Bearer {token}`

---

## Wishlist Management

### Guest Wishlist (Session-based)

#### Add to Wishlist

**POST** `/wishlist/add`

**Request Body:**
```json
{
    "product_id": 1
}
```

#### Get Wishlist

**GET** `/wishlist`

#### Remove from Wishlist

**DELETE** `/wishlist/remove/{product_id}`

#### Get Wishlist Count

**GET** `/wishlist/count`

### Authenticated User Wishlist (Database-based)

#### Add to Wishlist

**POST** `/user/wishlist/add`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "product_id": 1
}
```

#### Get Wishlist

**GET** `/user/wishlist`

**Headers:** `Authorization: Bearer {token}`

#### Remove from Wishlist

**DELETE** `/user/wishlist/remove/{product_id}`

**Headers:** `Authorization: Bearer {token}`

---

## Orders

### Get User Orders

**GET** `/orders`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `per_page` (optional): Number of items per page
- `status` (optional): Filter by order status

### Get Order Details

**GET** `/orders/{id}`

**Headers:** `Authorization: Bearer {token}`

### Create Order

**POST** `/orders`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
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
    "payment_method": "cash_on_delivery",
    "notes": "Delivery instructions"
}
```

### Reorder

**POST** `/orders/{id}/reorder`

**Headers:** `Authorization: Bearer {token}`

### Track Order

**GET** `/orders/{id}/track`

**Headers:** `Authorization: Bearer {token}`

---

## User Management

### Get Profile

**GET** `/user/profile`

**Headers:** `Authorization: Bearer {token}`

### Update Profile

**PUT** `/user/profile`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "John Doe",
    "phone": "+1234567890",
    "address": "123 Main St, City, State"
}
```

### Change Password

**POST** `/user/change-password`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "current_password": "oldpassword",
    "new_password": "newpassword123",
    "new_password_confirmation": "newpassword123"
}
```

---

## Reviews

### Get User Reviews

**GET** `/reviews`

**Headers:** `Authorization: Bearer {token}`

### Create Review

**POST** `/reviews`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "product_id": 1,
    "rating": 5,
    "comment": "Great product, highly recommended!"
}
```

### Update Review

**PUT** `/reviews/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "rating": 4,
    "comment": "Updated review comment"
}
```

### Delete Review

**DELETE** `/reviews/{id}`

**Headers:** `Authorization: Bearer {token}`

---

## Payments

### Create Payment Order

**POST** `/payment/create-order`

**Request Body:**
```json
{
    "amount": 129.79,
    "currency": "INR",
    "receipt": "order_123"
}
```

### Verify Payment

**POST** `/payment/verify`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "razorpay_order_id": "order_abc123",
    "razorpay_payment_id": "pay_xyz789",
    "razorpay_signature": "signature_here",
    "order_id": 1
}
```

---

## Static Pages

### Home Page

**GET** `/home`

### About Page

**GET** `/about`

### Contact Information

**GET** `/contact`

### Submit Contact Form

**POST** `/contact`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "subject": "Inquiry",
    "message": "I have a question about your products."
}
```

### Privacy Policy

**GET** `/privacy-policy`

### Terms and Conditions

**GET** `/terms-conditions`

### Shipping Policy

**GET** `/shipping-policy`

### Return Policy

**GET** `/return-policy`

---

## Admin Endpoints

*All admin endpoints require admin authentication*

### Dashboard Statistics

**GET** `/admin/dashboard`

**Headers:** `Authorization: Bearer {admin_token}`

### Product Management

#### Get All Products (Admin)

**GET** `/admin/products`

**Headers:** `Authorization: Bearer {admin_token}`

#### Create Product

**POST** `/admin/products`

**Headers:** `Authorization: Bearer {admin_token}`

**Request Body:**
```json
{
    "name": "New Product",
    "description": "Product description",
    "price": 99.99,
    "category_id": 1,
    "sub_category_id": 1,
    "labour_charges": 10.00,
    "gst_percentage": 18,
    "status": "active",
    "image_path": "/images/product.jpg"
}
```

#### Update Product

**PUT** `/admin/products/{id}`

**Headers:** `Authorization: Bearer {admin_token}`

#### Delete Product

**DELETE** `/admin/products/{id}`

**Headers:** `Authorization: Bearer {admin_token}`

### Order Management

#### Get All Orders (Admin)

**GET** `/admin/orders`

**Headers:** `Authorization: Bearer {admin_token}`

#### Update Order Status

**PUT** `/admin/orders/{id}/status`

**Headers:** `Authorization: Bearer {admin_token}`

**Request Body:**
```json
{
    "status": "shipped",
    "notes": "Order shipped via courier"
}
```

#### Delete Order

**DELETE** `/admin/orders/{id}`

**Headers:** `Authorization: Bearer {admin_token}`

### User Management

#### Get All Users (Admin)

**GET** `/admin/users`

**Headers:** `Authorization: Bearer {admin_token}`

#### Get User Details (Admin)

**GET** `/admin/users/{id}`

**Headers:** `Authorization: Bearer {admin_token}`

---

## Error Handling

### Standard Error Response Format

```json
{
    "status": "error",
    "message": "Error description",
    "errors": {
        "field_name": [
            "Validation error message"
        ]
    }
}
```

### HTTP Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

### Common Error Messages

- `Unauthorized access` - Invalid or missing authentication token
- `Access denied. Admin privileges required.` - User doesn't have admin role
- `Validation failed` - Request data validation errors
- `Product not available` - Product not found or inactive
- `Item not found in cart` - Cart item doesn't exist
- `You have already reviewed this product` - Duplicate review attempt

---

## Authentication Headers

For protected endpoints, include the Bearer token in the Authorization header:

```
Authorization: Bearer {your_token_here}
```

---

## Rate Limiting

The API implements rate limiting to prevent abuse:
- 60 requests per minute for authenticated users
- 30 requests per minute for guest users

---

## Pagination

Most list endpoints support pagination with the following parameters:
- `per_page`: Number of items per page (default varies by endpoint)
- `page`: Page number (default: 1)

Response includes pagination metadata:
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

## File Uploads

For image uploads, use multipart/form-data:
- Supported formats: JPG, PNG, GIF
- Maximum file size: 5MB
- Field name: `image`

---

## Testing

### Test Credentials

**Test User:**
- Email: `test@example.com`
- Password: `password123`

**Test Admin:**
- Email: `admin@example.com`
- Password: `admin123`

### Test Payment (Razorpay)

Use Razorpay test credentials for payment testing:
- Test Card: `4111 1111 1111 1111`
- Expiry: Any future date
- CVV: Any 3 digits

---

## Support

For API support and questions:
- Email: `api-support@example.com`
- Documentation: `https://yourdomain.com/api/docs`
- Status Page: `https://status.yourdomain.com`