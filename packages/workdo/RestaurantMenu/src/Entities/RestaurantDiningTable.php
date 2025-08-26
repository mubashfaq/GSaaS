<?php

namespace Workdo\RestaurantMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantDiningTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'status',
        'workspace',
        'created_by'
    ];

}
