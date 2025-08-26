<?php

namespace Workdo\ShopifySync\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\ProductService\Events\DestroyProduct;
use Workdo\ShopifySync\Entities\ShopifyConection;


class DestroyShopifyproduct
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
    public function handle(DestroyProduct $event)
    {
        $sp_connection = ShopifyConection::where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('type','product')->where('original_id' ,$event->productService->id)->first();
        if($sp_connection){

            $sp_connection->delete();
        }
    }
}
