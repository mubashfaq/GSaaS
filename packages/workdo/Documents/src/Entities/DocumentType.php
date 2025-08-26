<?php

namespace Workdo\Documents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'documents_types';

    protected $fillable = [
        'name',
        'workspace_id',
        'created_by',
    ];

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
