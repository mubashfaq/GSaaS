<?php

namespace Workdo\ConsignmentManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsignmentWeight extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'weight',
        'workspace',
        'created_by',
    ];
}
