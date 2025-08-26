<?php

namespace Workdo\RestaurantMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Workdo\ProductService\Entities\ProductService;

class RestaurantCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'type',
        'color',
        'food_image',
        'created_by',
        'workspace_id'
    ];


    public function items(){
        return $this->hasMany(ProductService::class,'category_id','id');
    }
}
