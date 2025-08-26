<?php

namespace Workdo\ShopifySync\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\ProductService\Events\DestroyCategory;
use Workdo\ShopifySync\Entities\ShopifyConection;


class DestroyShopifycategory
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
    public function handle(DestroyCategory $event)
    {
        $sp_connection = ShopifyConection::where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('type','category')->where('original_id' ,$event->category->id)->first();
        if($sp_connection){

            $sp_connection->delete();
        }
    }
}
