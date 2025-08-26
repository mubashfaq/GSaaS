<?php

namespace Workdo\ConsignmentManagement\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignment_id',
        'sale_order_id',
        'customer_id',
        'date',
        'subtotal',
        'commission',
        'totalamount',
        'is_convert_invoice',
        'converted_invoice_id',
        'workspace_id',
        'created_by',
    ];

    public function consignment(){
        return $this->hasOne(Consignment::class,'id','consignment_id');
    }
    public function customer(){
        return $this->hasOne(User::class,'id','customer_id');
    }

    public static function saleOrderNumberFormat($number)
    {

        $data = '#SAL0';

        return $data. sprintf("%05d", $number);
    }
}
