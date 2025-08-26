<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Commission\Events\CreateCommissionPlan;

class CreateCommissionPlanLis
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
    public function handle(CreateCommissionPlan $event)
    {
        if (module_is_active('ActivityLog')) {
            $commissionPlan = $event->commissionPlan;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Commission';
            $activity['sub_module']     = 'Commission Plan';
            $activity['description']    = __('New Commission Plan Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $commissionPlan->workspace;
            $activity['created_by']     = $commissionPlan->created_by;
            $activity->save();
        }
    }
}
