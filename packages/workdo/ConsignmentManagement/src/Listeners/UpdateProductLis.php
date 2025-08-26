<?php

namespace Workdo\ConsignmentManagement\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\ProductService\Events\UpdateProduct;
use Workdo\ConsignmentManagement\Entities\ConsignmentWeight;

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

    public function handle(UpdateProduct $event)
    {
        $productService = $event->productService;
        $request        = $event->request;

        if (module_is_active('ConsignmentManagement') && $request->type == "consignment") {
            $weight = ConsignmentWeight::where('item_id', $productService->id)->first();
            if ($weight) {
                $weight->weight = $request->weight;
                $weight->save();
            }
        }
    }
}
