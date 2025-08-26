<?php

namespace Workdo\ProductService\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    // protected $fillable = [];
     protected $fillable = [
        'name',
        'created_by',
        'workspace_id',
    ];
    protected static function newFactory()
    {
        return \Workdo\ProductService\Database\factories\UnitFactory::new();
    }
}
