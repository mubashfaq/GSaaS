<?php

namespace Workdo\ConsignmentManagement\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\ProductService\Events\CreateProduct;
use Workdo\ConsignmentManagement\Entities\ConsignmentWeight;

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

    public function handle(CreateProduct $event)
    {
        $productService = $event->productService;
        $request        = $event->request;
        if (module_is_active('ConsignmentManagement') && $request->type == "consignment") {
            $weight                   = new ConsignmentWeight();
            $weight->item_id          = $request->id;
            $weight->weight           = $productService->weight;
            $weight->created_by       = creatorId();
            $weight->workspace        = getActiveWorkSpace();
            $weight->save();
        }
    }
}
