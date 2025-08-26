<?php

namespace Workdo\ProductService\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'collection_id',
        'product_id',
        'active',
    ];

    public function product()
    {
        //  return $this->belongsTo('Workdo\ProductService\Entities\ProductService', 'id');
        return $this->belongsTo(ProductService::class, 'product_id');
    }

    public function collection(){
        return $this->belongsTo(Collection::class, 'collection_id');
    }
}
