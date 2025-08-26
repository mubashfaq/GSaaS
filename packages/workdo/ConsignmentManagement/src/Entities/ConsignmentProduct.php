<?php

namespace Workdo\ConsignmentManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsignmentProduct extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','weight','unit_price','quantity','created_by','workspace_id'];
}
