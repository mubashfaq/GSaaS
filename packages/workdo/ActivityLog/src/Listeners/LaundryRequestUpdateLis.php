<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\LaundryManagement\Events\LaundryRequestUpdate;

class LaundryRequestUpdateLis
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
    public function handle(LaundryRequestUpdate $event)
    {
        if (module_is_active('ActivityLog')) {
            $laundryrequest = $event->laundryrequest;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Laundry';
            $activity['sub_module']     = 'Laundry Request';
            $activity['description']    = __('Laundry Request Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $laundryrequest->workspace_id;
            $activity['created_by']     = $laundryrequest->created_by;
            $activity->save();
        }
    }
}
