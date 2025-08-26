<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'opening_balance',
        'closing_balance',
        'opening_note',
        'closing_note',
        'opened_at',
        'closed_at',
        'workspace',
        'created_by',
        
    ];
    
    public function transactions()
    {
        return $this->hasMany(RegisterTransaction::class);
    }

    public function isOpen()
    {
        return is_null($this->closed_at);
    }
}
