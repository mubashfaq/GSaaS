<?php

namespace Workdo\ConsignmentManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'vendor',
        'commission',
        'date',
        'subtotal',
        'totalamount',
        'taxamount',
        'created_by',
        'workspace_id',
    ];

    public function item(){
        return $this->hasMany(ConsignmentItem::class,'consignment_id','id')->with('product');
    }
}
