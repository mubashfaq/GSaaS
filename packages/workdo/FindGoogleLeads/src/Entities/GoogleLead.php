<?php

namespace Workdo\FindGoogleLeads\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoogleLead extends Model
{
    use HasFactory;
    protected $table ='findgooglelead_founded_leads';    
    protected $fillable = [
        'name',
        'keywords',
        'address',
        'contact',
        'workspace',
        'created_by',
    ];
    
    protected static function newFactory()
    {
        return \Workdo\FindGoogleLeads\Database\factories\GoogleLeadFactory::new();
    }
}
