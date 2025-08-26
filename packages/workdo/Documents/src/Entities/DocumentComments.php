<?php

namespace Workdo\Documents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentComments extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'user_id',
        'comment',
        'workspace_id',
        'created_by',
    ];
}
