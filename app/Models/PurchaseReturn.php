<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'return_id',
        'purchase_id',
        'vender_id',
        'user_id',
        'vender_name',
        'warehouse_id',
        'return_date',
        'return_number',
        'return_reason',
        'status',
        'category_id',
        'purchase_module',
        'total_amount',
        'total_tax',
        'final_amount',
        'workspace',
        'created_by',
    ];

    public static $statues = [
        0 => 'Pending',
        1 => 'Approved',
        2 => 'Rejected',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

    public function vender()
    {
        if (module_is_active('Account')) {
              return $this->hasOne(\Workdo\Account\Entities\Vender::class, 'user_id', 'vender_id');
            // return $this->hasOne(\Workdo\Account\Entities\Vender::class, 'id', 'vender_id');
        }
        return null;
    }

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class, 'id', 'warehouse_id');
    }

    public function returnProducts()
    {
        return $this->hasMany(PurchaseReturnProduct::class, 'return_id', 'id');
    }

    // Format return number with prefixes
    public static function returnNumberFormat($number)
    {
        $settings = getCompanyAllSetting();
        
        $purchase_prefix = !empty($settings['purchase_return_prefix']) ? $settings['purchase_return_prefix'] : 'PR';
        return $purchase_prefix . sprintf("%05d", $number);
    }

    // Get formatted return number
    public function getReturnNumberAttribute()
    {
        return self::returnNumberFormat($this->return_id);
    }

    // Get status badge with appropriate color
    public function getStatusBadgeAttribute()
    {
        $colors = [
            0 => 'warning',   // Pending
            1 => 'success',   // Approved
            2 => 'danger',    // Rejected
        ];

        $status = self::$statues[$this->status];
        $color = $colors[$this->status];

        return '<span class="badge bg-' . $color . '">' . $status . '</span>';
    }
    
    // Get total amount with proper formatting
    public function getFormattedTotalAttribute()
    {
        return $this->final_amount;
    }
    
      public static function userBalance($users, $id, $amount, $type)
    {
        $user = [];
        if (module_is_active('Account')) {
            if ($users == 'customer') {
                $user = \Workdo\Account\Entities\Customer::find($id);
            } else {
                $user = \Workdo\Account\Entities\Vender::find($id);
            }
        }

        if (!empty($user)) {
            if ($type == 'credit') {
                $oldBalance = $user->balance;
                $user->balance = $oldBalance + $amount;
                $user->save();
            } elseif ($type == 'debit') {
                $oldBalance = $user->balance;
                $user->balance = $oldBalance - $amount;
                $user->save();
            }
        }
    }
    public static function bankAccountBalance($id, $amount, $type)
    {
        if (module_is_active('Account')) {
            $bankAccount = \Workdo\Account\Entities\BankAccount::find($id);
            if ($bankAccount) {
                if ($type == 'credit') {
                    $oldBalance = $bankAccount->opening_balance;
                    $bankAccount->opening_balance = $oldBalance + $amount;
                    $bankAccount->save();
                } elseif ($type == 'debit') {
                    $oldBalance = $bankAccount->opening_balance;
                    $bankAccount->opening_balance = $oldBalance - $amount;
                    $bankAccount->save();
                }
            }
        }
    }
}
