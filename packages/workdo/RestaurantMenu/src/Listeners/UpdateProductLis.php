<?php

namespace Workdo\RestaurantMenu\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\ProductService\Events\UpdateProduct;
use Workdo\RestaurantMenu\Entities\RestaurantVarient;

class UpdateProductLis
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
    public function handle(UpdateProduct $event)
    {
        if (module_is_active('RestaurantMenu')) {
            $productService = $event->productService;
            $request        = $event->request;
            $varient = RestaurantVarient::where('item_id', $productService->id)->first();

            if ($varient) {
                $varient->varient_name = $request->varient_name;
                $varient->additional_price = $request->additional_price;
                $varient->item_attribute = $request->item_attribute;
                $varient->status = $request->status;
                $varient->save();
            }
        }
    }
}
