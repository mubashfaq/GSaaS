<?php

namespace Workdo\RestaurantMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'product',
        'total',
        'status',
        'table_id',
        'workspace',
        'created_by'
    ];

    public function customer(){
        return $this->hasOne(RestaurantCustomer::class,'id','customer_id');
    }

    public function table(){
        return $this->hasOne(RestaurantDiningTable::class,'id','table_id');
    }

    public static $statues = [
        'Order Placed',
        'Order Accept',
        'Order Procesing',
        'Order Delivered',
    ];
}
