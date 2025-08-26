<?php

namespace Workdo\VCard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PixelFields extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'platform',
        'pixel_id',
        'created_by'    
    ];
    
    protected static function newFactory()
    {
        return \Workdo\VCard\Database\factories\PixelFieldsFactory::new();
    }
}
