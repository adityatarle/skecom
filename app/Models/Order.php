<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',              // Foreign key to users table (can be nullable if guest checkout is allowed)
        'products',             // Will store the cart items as JSON
        'total_price',          // The final calculated total price
        'status',               // e.g., 'pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled', 'failed'
        'first_name',           // Billing/Shipping Info
        'last_name',
        'email',
        'phone',
        'street_address',
        'city',
        'state',
        'country',
        'payment_method',       // e.g., 'cash_on_delivery', 'razorpay'
        'razorpay_payment_id',  // Razorpay Payment ID (nullable)
        'razorpay_order_id',    // Razorpay Order ID (nullable)
        // Add any other fields like shipping details if separate from billing, tracking numbers, notes etc.
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'products' => 'array', // Automatically encode/decode the 'products' column to/from JSON <-> PHP array
        'total_price' => 'decimal:2', // Cast total_price to a decimal with 2 places (ensure DB column is DECIMAL/FLOAT)
        // 'created_at' => 'datetime:Y-m-d H:i', // Example: Customize date format if needed
        // 'updated_at' => 'datetime:Y-m-d H:i',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        // Use optional() if user_id can be null (guest orders)
        // return optional($this->belongsTo(User::class, 'user_id'));
        // Use regular belongsTo if user_id is always required
         return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the items associated with the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}