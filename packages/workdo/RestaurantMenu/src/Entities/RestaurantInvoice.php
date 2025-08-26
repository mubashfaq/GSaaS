<?php

namespace Workdo\RestaurantMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantInvoice extends Model
{
    use HasFactory;

    protected $fillable = [];

    public static function total_quantity($type, $quantity, $product_id)
    {
        if(module_is_active('ProductService'))
        {
            $product      = \Workdo\ProductService\Entities\ProductService::find($product_id);
            if(!empty($product)){
                if(($product->type == 'product'))
                {
                    $pro_quantity = $product->quantity;
                    if($type == 'minus')
                    {
                        $product->quantity = $pro_quantity - $quantity;
                    }
                    else
                    {
                        $product->quantity = $pro_quantity + $quantity;
                    }
                    $product->save();
                }
            }
        }
    }
}
