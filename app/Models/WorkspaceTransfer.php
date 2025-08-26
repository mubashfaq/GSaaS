<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkspaceTransfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'token',
        'from_warehouse',
        'to_workspace',
        'to_warehouse',
        'date',
        'status',
        'notes',
        'created_by',
        'workspace',
        'completed_date',
    ];
    protected $casts = [
        'date' => 'date',
        'completed_date' => 'datetime',
    ];
    public function transferProducts()
    {
        return $this->hasMany(WorkspaceTransferProduct::class);
    }

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
