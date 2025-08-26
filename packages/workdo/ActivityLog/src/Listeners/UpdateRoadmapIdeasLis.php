<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\RoadMapCentral\Events\UpdateRoadmapIdeas;

class UpdateRoadmapIdeasLis
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
    public function handle(UpdateRoadmapIdeas $event)
    {
        if (module_is_active('ActivityLog')) {
            $ideas = $event->ideas;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'RoadMap Central';
            $activity['sub_module']     = 'Ideas';
            $activity['description']    =  __('Idea updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $ideas['workspace'];
            $activity['created_by']     = $ideas['created_by'];
            $activity->save();
        }
    }
}
