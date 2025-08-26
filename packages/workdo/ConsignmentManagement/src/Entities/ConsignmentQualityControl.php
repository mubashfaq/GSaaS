<?php

namespace Workdo\ConsignmentManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsignmentQualityControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignment_id',
        'product_id',
        'check_date',
        'status',
        'inspector',
        'remarks',
    ];

    public static $status = [
        'Passed' =>'Passed',
        'Failed' =>'Failed',
    ];

    public function Consignment(){
        return $this->hasOne(Consignment::class ,'id','consignment_id');
    }
}
