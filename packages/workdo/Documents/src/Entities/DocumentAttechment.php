<?php

namespace Workdo\Documents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentAttechment extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'user_id',
        'workspace_id',
        'files',
        'created_by',
    ];

}
