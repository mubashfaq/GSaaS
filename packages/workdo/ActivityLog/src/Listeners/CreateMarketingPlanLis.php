<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MarketingPlan\Events\CreateMarketingPlan;

class CreateMarketingPlanLis
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
    public function handle(CreateMarketingPlan $event)
    {
        if (module_is_active('ActivityLog')) {
            $MarketingPlan = $event->MarketingPlan;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'Marketing Plan';
            $activity['description']    =  __('New Marketing Plan created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $MarketingPlan['workspace'];
            $activity['created_by']     = $MarketingPlan['created_by'];
            $activity->save();
        }
    }
}
