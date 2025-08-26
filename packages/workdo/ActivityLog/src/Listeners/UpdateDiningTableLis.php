<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\RestaurantMenu\Events\UpdateDiningTable;

class UpdateDiningTableLis
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
    public function handle(UpdateDiningTable $event)
    {
        if (module_is_active('ActivityLog')) {
            $diningTable = $event->diningTable;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Restaurant';
            $activity['sub_module']     = 'Dining Table';
            $activity['description']    =  __('Dining Table updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $diningTable['workspace'];
            $activity['created_by']     = $diningTable['created_by'];
            $activity->save();
        }
    }
}
