<?php

namespace Workdo\ConsignmentManagement\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignment_id',
        'vendor_id',
        'date',
        'subtotal',
        'commission',
        'totalamount',
        'is_convert_purchase',
        'converted_purchase_id',
        'workspace_id',
        'created_by',
    ];

    public function consignment(){
        return $this->hasOne(Consignment::class,'id','consignment_id');
    }
    public function vendor(){
        return $this->hasOne(User::class,'id','vendor_id');
    }
}
