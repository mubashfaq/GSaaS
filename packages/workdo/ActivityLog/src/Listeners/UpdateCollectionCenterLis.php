<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\BeverageManagement\Events\UpdateCollectionCenter;

class UpdateCollectionCenterLis
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
    public function handle(UpdateCollectionCenter $event)
    {
        if (module_is_active('ActivityLog')) {
            $collection_center = $event->collection_center;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Beverage';
            $activity['sub_module']     = 'Collection Center';
            $activity['description']    = __('Collection Center Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $collection_center->workspace;
            $activity['created_by']     = $collection_center->created_by;
            $activity->save();
        }
    }
}
