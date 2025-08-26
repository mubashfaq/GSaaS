<?php

namespace Workdo\ConsignmentManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Workdo\ProductService\Entities\ProductService;

class ConsignmentReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_order_id',
        'product_id',
        'consignment_id',
        'quantity',
        'return_reason',
        'return_date',
        'status',
        'workspace',
        'created_by',
    ];

    public static $status =[
       'Pending' => 'Pending',
       'Approved' => 'Approved',
       'Rejected' => 'Rejected',
    ];

     public function saleorder(){
        return $this->hasOne(SaleOrder::class ,'sale_order_id','sale_order_id');
     }

     public function Product(){
        return $this->hasOne(ProductService::class ,'id','product_id');
     }
 }
