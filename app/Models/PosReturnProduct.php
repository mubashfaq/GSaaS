<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosReturnProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'return_id',
        'product_id',
        'price',
        'original_price',
        'quantity',
        't_quantity',
        'tax',
        'discount',
        'batch_no',
        'workspace',
    ];

    public function product()
    {
        return $this->belongsTo(\Workdo\ProductService\Entities\ProductService::class, 'product_id', 'id');
    }

    public function return()
    {
        return $this->belongsTo(PosReturn::class, 'return_id', 'id');
    }
}
