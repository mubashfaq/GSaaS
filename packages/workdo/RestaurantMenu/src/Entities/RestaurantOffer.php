<?php

namespace Workdo\RestaurantMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount',
        'start_date',
        'end_date',
        'items',
        'status',
        'workspace',
        'created_by'
    ];

    public function itemsType()
    {
        return $this->hasOne('Workdo\ProductService\Entities\ProductService', 'id', 'items');
    }
}
