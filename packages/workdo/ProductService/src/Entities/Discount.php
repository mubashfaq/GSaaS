<?php

namespace Workdo\ProductService\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount_type',
        'discount_value',
        'limited',
        'from_date',
        'end_date',
        'badge',
        'badge_text',
        'badge_color',
        'badge_image',
        'active',
        'created_by',
        'discount_for',
        'workspace_id',
    ];
    
    protected static function newFactory()
    {
        return \Workdo\ProductService\Database\factories\UnitFactory::new();
    }
}