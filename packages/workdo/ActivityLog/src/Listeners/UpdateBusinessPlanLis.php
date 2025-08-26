<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\BusinessPlan\Events\UpdateBusinessPlan;

class UpdateBusinessPlanLis
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
    public function handle(UpdateBusinessPlan $event)
    {
        if (module_is_active('ActivityLog')) {
            $businessplan = $event->businessplan;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'Business Plan';
            $activity['description']    =  __('Business Plan updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $businessplan['workspace'];
            $activity['created_by']     = $businessplan['created_by'];
            $activity->save();
        }
    }
}
