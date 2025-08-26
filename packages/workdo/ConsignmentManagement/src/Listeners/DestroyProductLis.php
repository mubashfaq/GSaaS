<?php

namespace Workdo\ConsignmentManagement\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\ProductService\Events\DestroyProduct;
use Workdo\ConsignmentManagement\Entities\ConsignmentWeight;

class DestroyProductLis
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

    public function handle(DestroyProduct $event)
    {
        $productService = $event->productService;
        if (module_is_active('ConsignmentManagement') && $productService->type == "consignment") {
            $consignmentItemsWeight = ConsignmentWeight::where('item_id',$productService->id)->where('created_by', '=', creatorId())->where('workspace', '=', getActiveWorkSpace())->first();;
            $consignmentItemsWeight->delete();
        }
    }
}
