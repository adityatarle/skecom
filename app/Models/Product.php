<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends Model
{
    use HasFactory;

    protected $table = 'products';  // Explicitly set table name

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'category_id',
        'sub_category_id',
        'labour_charges',
        'gst_percentage',
        'status',
    ];

     protected $casts = [
        'price' => 'decimal:2' //Cast the price column to a decimal with two places after the decimal
    ];

    /**
     * Get the category that owns the product.
     */
     public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'sub_category_id');
    }


    public function images(): HasMany {
        return $this->hasMany(ProductImage::class);
    }

    public function pricingDetails()
    {
        return $this->hasMany(ProductPricingDetail::class);
    }

    public function getPricingBreakup()
    {
        $pricingDetails = ProductPricingDetail::where('product_id', $this->id)->get();

        $subtotal = $pricingDetails->sum('total_value'); // Calculate subtotal

        $labourCharges = $this->labour_charges ?? 0; // Get product-specific labour charge
        $gstPercentage = $this->gst_percentage ?? 0; // Get product-specific GST
        $gstAmount = ($subtotal + $labourCharges) * ($gstPercentage / 100);

        $grandTotal = $subtotal + $labourCharges + $gstAmount;

        return [
            'components' => $pricingDetails,
            'subtotal' => $subtotal,
            'labour_charges' => $labourCharges,
            'gst_percentage' => $gstPercentage,
            'gst_amount' => $gstAmount,
            'grand_total' => $grandTotal,
        ];
    }


}
