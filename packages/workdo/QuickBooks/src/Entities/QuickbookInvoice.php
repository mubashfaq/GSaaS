<?php

namespace Workdo\QuickBooks\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuickbookInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'quickbook_invoice_id',
        'workspace',
        'created_by',
    ];

   
}
