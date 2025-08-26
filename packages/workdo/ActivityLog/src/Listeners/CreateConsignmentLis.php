<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\ConsignmentManagement\Events\CreateConsignment;

class CreateConsignmentLis
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
    public function handle(CreateConsignment $event)
    {
        if (module_is_active('ActivityLog')) {
            $consignment = $event->consignment;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Consignment';
            $activity['sub_module']     = 'Consignment';
            $activity['description']    = __('New Consignment Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $consignment->workspace_id;
            $activity['created_by']     = $consignment->created_by;
            $activity->save();
        }
    }
}
