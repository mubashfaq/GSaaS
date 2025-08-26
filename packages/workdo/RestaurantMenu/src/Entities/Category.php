<?php

namespace Workdo\RestaurantMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'color',
        'image',
        'created_by',
        'workspace_id'
    ];

}
