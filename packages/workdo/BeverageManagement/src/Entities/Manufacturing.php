<?php

namespace Workdo\BeverageManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manufacturing extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Workdo\BeverageManagement\Database\factories\ManufacturingFactory::new();
    }

    public function billOfMaterial()
    {
        return $this->hasOne(BillOfMaterial::class, 'id', 'bill_of_material_id');
    }

    public function collectionCenter()
    {
        return $this->hasOne(CollectionCenter::class, 'id', 'collection_center_id');
    }

    public function productService()
    {
        return $this->belongsTo(
            \Workdo\ProductService\Entities\ProductService::class,
            'item_id',  // foreign key in BillOfMaterial
            'id'        // primary key in ProductService
        );
    }
    
}
