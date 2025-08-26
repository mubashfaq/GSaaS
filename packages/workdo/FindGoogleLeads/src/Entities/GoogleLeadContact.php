<?php

namespace Workdo\FindGoogleLeads\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoogleLeadContact extends Model
{
    use HasFactory;

    protected $table ='findgooglelead_founded_lead_contacts';    
    protected $fillable = [
        'founded_lead_id',
        'name',
        'email',
        'phone_no',
        'website',
        'address',
        'workspace',
        'created_by',
    ];
    
    protected static function newFactory()
    {
        return \Workdo\FindGoogleLeads\Database\factories\GoogleLeadContactFactory::new();
    }
}
