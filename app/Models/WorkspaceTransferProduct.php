<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkspaceTransferProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'workspace_transfer_id',
        'product_id',
        'quantity',
        'status',
        'received_date',
        'received_by'
    ];
    protected $casts = [
        'received_date' => 'date',
    ];
    public function workspaceTransfer()
    {
        return $this->belongsTo(WorkspaceTransfer::class);
    }

    public function product()
    {
      return $this->hasOne(\Workdo\ProductService\Entities\ProductService::class, 'id', 'product_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
