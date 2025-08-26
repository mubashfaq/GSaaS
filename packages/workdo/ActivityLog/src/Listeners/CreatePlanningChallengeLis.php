<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Planning\Events\CreateChallenge;

class CreatePlanningChallengeLis
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
    public function handle(CreateChallenge $event)
    {
        if (module_is_active('ActivityLog')) {
            $Challenges = $event->Challenges;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'Challenges';
            $activity['description']    =  __('New Challenge created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $Challenges['workspace'];
            $activity['created_by']     = $Challenges['created_by'];
            $activity->save();
        }
    }
}
