<?php

namespace Workdo\Xero\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class XeroPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'xero_payment_id',
        'workspace',
        'created_by',
    ];

}
