<?php

namespace Workdo\ConsignmentManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class ConsignmentCompliance extends Model
{
    protected $fillable = [
        'related_entity',
        'compliance_type',
        'status',
        'report_date',
        'remarks'
    ];

    public static $status = [
        'Compliant'     => 'Compliant',
        'Non-Compliant' => 'Non-Compliant'
    ];
}
