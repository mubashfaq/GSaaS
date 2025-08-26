<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fbr extends Model
{
    use HasFactory;
    protected $fillable = ['workspace', 'fbr_pos_id', 'created_by'];
}
