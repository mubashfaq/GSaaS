<?php

namespace Workdo\ProductService\Entities;

use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\WarehouseProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DB;
use Carbon\Carbon;
use Workdo\ProductService\Entities\Discount;
class ProductService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','sku','low_stock_limit','sale_price','purchase_price','tax_id','category_id','brand_id','description','type', 'icon', 'parent_id', 'sort_order', 'route', 'is_visible','quantity', 'permissions', 'module','image','unit_id' ,'discount_id','sale_chartaccount_id','expense_chartaccount_id','workspace_id','created_by'
    ];
    public static $product_type =
    [
        'product'    => 'Products',
        'service'    => 'Services', 
        'parts'      => 'Parts',
    ];
    protected $appends = ['discount_data'];

    protected static function newFactory()
    {
        return \Workdo\ProductService\Database\factories\ProductServiceFactory::new();
    }

      public function collectionProducts()
    {
        return $this->hasMany('Workdo\ProductService\Entities\CollectionProduct::class', 'product_id');
    }
    public function discount()
    {
        return $this->belongsTo('Workdo\ProductService\Entities\Discount', 'discount_id');
    }
    public function units()
    {
        return $this->belongsTo('Workdo\ProductService\Entities\Unit', 'unit_id');
    }

    public function categorys()
    {
        return $this->belongsTo('Workdo\ProductService\Entities\Category', 'category_id');
    }
    
    public function brands()
    {
        return $this->belongsTo('Workdo\ProductService\Entities\Category', 'brand_id');
    }
    public function taxes()
    {
        return $this->hasOne('Workdo\ProductService\Entities\Tax', 'id', 'tax_id')->first();
    }

    public function unit()
    {
        return $this->hasOne('Workdo\ProductService\Entities\Unit', 'id', 'unit_id')->first();
    }

    public function category()
    {
        return $this->hasOne('Workdo\ProductService\Entities\Category', 'id', 'category_id');
    }
    public function taxRate($taxes)
    {
        $taxArr  = explode(',', $taxes);
        $taxRate = 0;
        foreach ($taxArr as $tax) {
            $tax     = Tax::find($tax);
            $taxRate += $tax->rate;
        }

        return $taxRate;
    }
    public function tax($taxes)
    {
        $taxArr = explode(',', $taxes);

        $taxes  = [];
        foreach ($taxArr as $tax) {
            $taxes[] = Tax::find($tax);
        }

        return $taxes;
    }
    public function getTotalProductQuantity()
    {
        if(module_is_active('Pos'))
        {
            $totalquantity = $purchasedquantity = $posquantity = 0;
            $authuser = \Auth::user();
            $product_id = $this->id;
            $purchases = Purchase::where('created_by', creatorId())->where('workspace',getActiveWorkSpace());
            if ($this->isUser())
            {
                $purchases = $purchases->where('warehouse_id', $authuser->warehouse_id);
            }
            foreach($purchases->get() as $purchase)
            {
                $purchaseditem = PurchaseProduct::select('quantity')->where('purchase_id', $purchase->id)->where('product_id', $product_id)->first();
                $purchasedquantity += $purchaseditem != null ? $purchaseditem->quantity : 0;
            }

            $poses = \Workdo\Pos\Entities\Pos::where('created_by', creatorId())->where('workspace',getActiveWorkSpace());
            if ($this->isUser())
            {
                $pos = $poses->where('warehouse_id', $authuser->warehouse_id);
            }

            foreach($poses->get() as $pos)
            {
                $positem = \Workdo\Pos\Entities\PosProduct::select('quantity')->where('pos_id', $pos->id)->where('product_id', $product_id)->first();
                $posquantity += $positem != null ? $positem->quantity : 0;
            }

            $totalquantity = $purchasedquantity - $posquantity;
            return $totalquantity;
        }

    }
    public function isUser()
    {
        return $this->type === 'user' ? 1 : 0;
    }

    public function warehouseProduct($product_id,$warehouse_id){
        if(module_is_active('Pos'))
        {
            $product=WarehouseProduct::where('warehouse_id',$warehouse_id)
                ->where('product_id',$product_id)
                ->where('workspace',getActiveWorkSpace())->first();

            return !empty($product)?$product->quantity:0;
        }
    }


    public static function addProductStock($product_id, $quantity, $type, $description,$type_id)
    {
        $stocks                 = new \Workdo\Account\Entities\StockReport();
        $stocks->product_id     = $product_id;
        $stocks->quantity	    = $quantity;
        $stocks->type           = $type;
        $stocks->type_id        = $type_id;
        $stocks->description    = $description;
        $stocks->created_by     = creatorId();
        $stocks->workspace      = getActiveWorkSpace();
        $stocks->save();
    }



    public function getProductQuantity()
    {
        if(module_is_active('Pos'))
        {
            $totalquantity  = $posquantity = 0;
            $authuser = \Auth::user();

            $product_id = $this->id;

            $quotations = \Workdo\Quotation\Entities\Quotation::where('created_by', creatorId())->where('workspace',getActiveWorkSpace());


            if ($this->isUser())
            {
                $quotation = $quotations->where('warehouse_id', $authuser->warehouse_id);
            }

            foreach($quotations->get() as $quotation)
            {
                $positem = \Workdo\Quotation\Entities\QuotationProduct::select('quantity')->where('quotation_id', $quotation->id)->where('product_id', $product_id)->first();
                $totalquantity += $positem != null ? $positem->quantity : 0;
            }

            return $totalquantity;
        }
    }
    
    
    public function getDiscountData()
    {
        $discount = Discount::find($this->discount_id);
        if ($discount) {
            $currentDate = Carbon::now();
            $fromDate = Carbon::parse($discount->from_date);
            $endDate = Carbon::parse($discount->end_date);
             // Check if discount is expired
            if ($currentDate->greaterThanOrEqualTo($endDate) ) {
                // Don't update the database, just return null for this calculation
                return null;
            }
            if ($currentDate->between($fromDate, $endDate) ) {
                // $priceMeta = $this->productMeta->firstWhere('option', '_price');
                 $price = $this->sale_price ?? 0;
                // $price = 0; // $priceMeta ? $priceMeta->value : 0;
                $discountType = $discount->discount_type;
                $discountValue = $discount->discount_value;
                if ($discountType == 1) { // Fixed amount
                    $discountedPrice = max(0, $price - $discountValue);
                } elseif ($discountType == 0) {
                    $discountedPrice = max(0, $price * (1 - $discountValue / 100));
                } else {
                    $discountedPrice = $price;
                }
                return [
                    'product_id' => $this->id,
                    'original_price' => round($price, 2),
                    'discounted_price' => round($discountedPrice, 2),
                    'discount_type' => $discountType,
                    'discount_value' => $discountValue
                ];
            }
        }
        return null;
    }
    
    public function getCollectionDiscountData()
    {
      
        $collectionProducts = CollectionProduct::where('product_id', $this->id)->get();
        foreach ($collectionProducts as $collectionProduct) {
            $collection = $collectionProduct->collection;
            $discount = $collection->discount()->first();
            if ($discount && $discount->active == 1) {
                $currentDate = Carbon::now();
                $fromDate = Carbon::parse($discount->from_date);
                $endDate = Carbon::parse($discount->end_date);
                if ($currentDate->greaterThanOrEqualTo($endDate) ) {
                    continue;
                }
                if ($currentDate->between($fromDate, $endDate) ) {
                    // $priceMeta = $this->productMeta->firstWhere('option', '_price');
                    // $price = $priceMeta ? $priceMeta->value : 0;
                    $price = $this->sale_price ?? 0;
                    $discountType = $discount->discount_type;
                    $discountValue = $discount->discount_value;
                    if ($discountType == 1) { // Fixed amount
                        $discountedPrice = max(0, $price - $discountValue);
                    } elseif ($discountType == 0) { // Percentage
                        $discountedPrice = max(0, $price * (1 - $discountValue / 100));
                    } else {
                        $discountedPrice = $price;
                    }
                    return [
                        'product_id' => $this->id,
                        'collection_id' => $collection->id,
                        'original_price' => round($price, 2),
                        'collection_name' => $collection->title,
                        'discounted_price' => round($discountedPrice, 2),
                        'discount_type' => $discountType,
                        'discount_value' => $discountValue
                    ];
                }
            }
        }
        return null;
    }
    
    public function getDiscountDataAttribute()
    { 
        $discountData = $this->getDiscountData();
        $collectionDiscountData = $this->getCollectionDiscountData();

        if ($discountData && $collectionDiscountData) {
            // Combine both data sets, with collection discount data having priority
            $combinedDiscountData = array_merge($discountData, $collectionDiscountData);
            return $combinedDiscountData;
        } elseif ($collectionDiscountData) {
            return $collectionDiscountData;
        } elseif ($discountData) {
            return $discountData;
        }

        return null;
    }
}
