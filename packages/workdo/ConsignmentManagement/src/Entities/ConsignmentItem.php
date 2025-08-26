<?php

namespace Workdo\ConsignmentManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Workdo\ProductService\Entities\ProductService;

class ConsignmentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignment_id',
        'product_id',
        'quantity',
        'price',
        'tax',
    ];

    public function product(){
        return $this->hasOne(ProductService::class,'id','product_id');
    }
}
