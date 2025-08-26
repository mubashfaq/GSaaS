<?php

namespace Workdo\QuickBooks\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuickbookPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'quickbook_payment_id',
        'workspace',
        'created_by',
    ];

  
}
