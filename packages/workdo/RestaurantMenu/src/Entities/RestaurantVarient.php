<?php

namespace Workdo\RestaurantMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantVarient extends Model
{
    use HasFactory;

    protected $fillable = [
        'varient_name',
        'item_id',
        'additional_price',
        'item_attribute',
        'status',
        'workspace',
        'created_by'
    ];

    public function itemAttr(){
        return $this->hasOne(RestaurantSystemSet::class,'id','item_attribute');
    }
}
