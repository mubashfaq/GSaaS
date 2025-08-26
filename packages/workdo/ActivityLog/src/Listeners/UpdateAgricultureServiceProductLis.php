<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\AgricultureManagement\Events\UpdateAgricultureServiceProduct;

class UpdateAgricultureServiceProductLis
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
    public function handle(UpdateAgricultureServiceProduct $event)
    {
        if (module_is_active('ActivityLog')) {
            $serviceproduct = $event->serviceproduct;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Agriculture';
            $activity['sub_module']     = 'Agriculture Service Product';
            $activity['description']    = __('Agriculture Service Product Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $serviceproduct->workspace;
            $activity['created_by']     = $serviceproduct->created_by;
            $activity->save();
        }
    }
}
