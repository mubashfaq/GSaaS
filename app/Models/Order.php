<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'card_number',
        'card_exp_month',
        'card_exp_year',
        'plan_name',
        'plan_id',
        'price',
        'price_currency',
        'txn_id',
        'payment_status',
        'payment_type',
        'receipt',
        'user_id',
    ];

    public static function total_orders()
    {
        $user = Auth::user();
        return Order::select('orders.*', 'users.name as user_name')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->when($user->type != 'super admin', function($query) use ($user) {
                $query->where('orders.user_id', $user->id);
            })
            ->count();
        // return Order::count();
    }

    public static function total_orders_price()
    {
        $user = Auth::user();
        return Order::select('orders.*', 'users.name as user_name')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->when($user->type != 'super admin', function($query) use ($user) {
                $query->where('orders.user_id', $user->id);
            })
            ->sum('price');
        // return Order::sum('price');
    }

    public function total_coupon_used()
    {
        return $this->hasOne(UserCoupon::class, 'order', 'order_id');
    }
}
