<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Sales\Events\CreateChangeOrder;

class CreateChangeOrderLis
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
    public function handle(CreateChangeOrder $event)
    {
        if (module_is_active('ActivityLog')) {
            $opportunities = $event->opportunities;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Sales';
            $activity['sub_module']     = 'Opportunities';
            $activity['description']    = __('Opportunity Moved by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $opportunities->workspace;
            $activity['created_by']     = $opportunities->created_by;
            $activity->save();
        }
    }
}
