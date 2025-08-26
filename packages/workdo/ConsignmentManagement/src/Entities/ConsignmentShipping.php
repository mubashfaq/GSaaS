<?php

namespace Workdo\ConsignmentManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsignmentShipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignment_id',
        'shipping_company',
        'tracking_number',
        'status',
        'shipping_date',
        'estimated_delivery_date',
        'workspace',
        'created_by',
    ];


    public static $status = [
        'Pending' => 'Pending',
        'Shipped' =>'Shipped',
        'Delivered' => 'Delivered',
    ];

    public function consignment(){
        return $this->hasOne(Consignment::class ,'id','consignment_id');
    }
}
