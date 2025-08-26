<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\GymManagement\Events\CreateMembershipPlan;

class CreateMembershipPlanLis
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
    public function handle(CreateMembershipPlan $event)
    {
        if (module_is_active('ActivityLog')) {
            $membershipplan = $event->membershipplan;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'GYM Management';
            $activity['sub_module']     = 'Membership Plan';
            $activity['description']    = __('New Membership Plan Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $membershipplan->workspace;
            $activity['created_by']     = $membershipplan->created_by;
            $activity->save();
        }
    }
}
