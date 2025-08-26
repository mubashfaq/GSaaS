<?php

namespace Workdo\Xero\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class XeroContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'xero_contact_id',
        'workspace',
        'created_by',
    ];

   
}
