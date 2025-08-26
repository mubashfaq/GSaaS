<?php

namespace Workdo\RestaurantMenu\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\ProductService\Events\CreateProduct;
use Workdo\RestaurantMenu\Entities\RestaurantVarient;

class CreateProductLis
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CreateProduct $event)
    {
        if (module_is_active('RestaurantMenu')) {
        $productService = $event->productService;
        $request        = $event->request;
            $varient                   = new RestaurantVarient();
            $varient->item_id          = $request->id;
            $varient->varient_name     = $productService->varient_name;
            $varient->additional_price = $productService->additional_price;
            $varient->item_attribute   = $productService->item_attribute;
            $varient->status           = $productService->status;
            $varient->created_by       = creatorId();
            $varient->workspace        = getActiveWorkSpace();
            $varient->save();
        }
    }
}
