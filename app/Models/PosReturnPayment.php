<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosReturnPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'return_id',
        'date',
        'amount',
        'discount',
        'discount_amount',
        'payment_method',
        'reference',
        'description',
        'workspace',
        'created_by',
    ];

    public function return()
    {
        return $this->belongsTo(PosReturn::class, 'return_id', 'id');
    }
}
