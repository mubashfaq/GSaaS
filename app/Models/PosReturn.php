<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosReturn extends Model
{
    use HasFactory;
     protected $fillable = [
        'return_id',
        'pos_id',
        'customer_id',
        'warehouse_id',
        'return_date',
        'note',
        'workspace',
        'created_by',
    ];

    public function pos()
    {
        return $this->belongsTo(\Workdo\Pos\Entities\Pos::class, 'pos_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function returnProducts()
    {
        return $this->hasMany(PosReturnProduct::class, 'return_id', 'id');
    }

    public function returnPayment()
    {
        return $this->hasOne(PosReturnPayment::class, 'return_id', 'id');
    }
    
    public static function returnNumberFormat($number)
    {
       $prefix = !empty(company_setting('pos_return_prefix')) ? company_setting('pos_return_prefix') : '#RTN0000';
        return $prefix . sprintf("%05d", $number);
    }
    public function getTotal()
    {
        $subtotals = 0;
        foreach($this->items as $item)  //PosProduct
        {

            $subtotals += ($item->price * $item->quantity);

        }

        return $subtotals;
    }
     public function items()
    {
        return $this->hasMany(\Workdo\Pos\Entities\PosProduct::class, 'pos_id', 'id');
    }
}
