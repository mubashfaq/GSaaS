<?php

namespace Workdo\RestaurantMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantPlaceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'varient',
        'description',
        'item_id',
        'total_price',
        'created_by',
        'workspace'
    ];
}
