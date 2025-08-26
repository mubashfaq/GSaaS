<?php

namespace Workdo\RestaurantMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantSystemSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'workspace',
        'created_by'
    ];

}
