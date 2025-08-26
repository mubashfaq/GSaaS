<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\Account\Events\CreateRevenue;
use Workdo\ActivityLog\Entities\AllActivityLog;

class CreateRevenueLis
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
    public function handle(CreateRevenue $event)
    {
        if (module_is_active('ActivityLog')) {
            $revenue = $event->revenue;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Accounting';
            $activity['sub_module']     = 'Income';
            $activity['description']    = __('New Revenue created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $revenue->workspace;
            $activity['created_by']     = $revenue->created_by;
            $activity->save();
        }
    }
}
