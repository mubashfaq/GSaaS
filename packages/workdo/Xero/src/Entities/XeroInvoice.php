<?php

namespace Workdo\Xero\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class XeroInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'xero_invoice_id',
        'workspace',
        'created_by',
    ];


}
