<?php

namespace Workdo\QuickBooks\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuickbookCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'quickbook_customer_id',
        'workspace',
        'created_by',
    ];


}
