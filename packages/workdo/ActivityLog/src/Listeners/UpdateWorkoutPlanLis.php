<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\GymManagement\Events\UpdateWorkoutPlan;

class UpdateWorkoutPlanLis
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
    public function handle(UpdateWorkoutPlan $event)
    {
        if (module_is_active('ActivityLog')) {
            $workoutplan = $event->workoutplan;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'GYM Management';
            $activity['sub_module']     = 'Workout Plan';
            $activity['description']    = __('Workout Plan Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $workoutplan->workspace;
            $activity['created_by']     = $workoutplan->created_by;
            $activity->save();
        }
    }
}
