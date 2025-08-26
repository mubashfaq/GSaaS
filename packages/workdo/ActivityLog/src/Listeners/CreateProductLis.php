<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\ProductService\Events\CreateProduct;

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
        if (module_is_active('ActivityLog')) {
            $productService = $event->request;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Product & Service';
            $activity['sub_module']     = $productService->type;
            $activity['description']    = __('New ') . $productService->type . __(' created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $productService->workspace_id;
            $activity['created_by']     = $productService->created_by;
            $activity->save();
        }
    }
}
