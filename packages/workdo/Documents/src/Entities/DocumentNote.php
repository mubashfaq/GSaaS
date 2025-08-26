<?php

namespace Workdo\Documents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'user_id',
        'note',
        'workspace_id',
        'created_by',
    ];

}
