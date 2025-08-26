<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'return_id',
        'purchase_product_id',
        'product_id',
        'quantity',
        'price',
        'tax',
        'discount',
        'batch_no',
        'description',
        'workspace',
    ];

    public function purchaseReturn()
    {
        return $this->belongsTo(PurchaseReturn::class, 'return_id', 'id');
    }

    public function product()
    {
        if (module_is_active('ProductService')) {
            return $this->hasOne(\Workdo\ProductService\Entities\ProductService::class, 'id', 'product_id');
        }
        return null;
    }

    // Calculate subtotal
    public function getSubtotalAttribute()
    {
        $price = $this->price * $this->quantity;
        $tax = ($price * $this->tax) / 100;
        $subtotal = $price + $tax;
        $discount = ($subtotal * $this->discount) / 100;

        return $subtotal - $discount;
    }

    // Get formatted price
    public function getFormattedPriceAttribute()
    {
        return priceFormat($this->price);
    }

    // Get formatted subtotal
    public function getFormattedSubtotalAttribute()
    {
        return priceFormat($this->getSubtotalAttribute());
    }
}
