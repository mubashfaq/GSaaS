<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterTransaction extends Model
{
    use HasFactory;
     protected $fillable = [
        'register_log_id',
        'amount',
        'type',
        'description'
    ];

    public function registerLog()
    {
        return $this->belongsTo(RegisterLog::class);
    }
}
