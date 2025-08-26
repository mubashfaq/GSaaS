<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\RoadMapCentral\Events\CreateRoadmapIdeas;

class CreateRoadmapIdeasLis
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
    public function handle(CreateRoadmapIdeas $event)
    {
        if (module_is_active('ActivityLog')) {
            $RoadmapIdeas = $event->RoadmapIdeas;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'RoadMap Central';
            $activity['sub_module']     = 'Ideas';
            $activity['description']    =  __('New Idea created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $RoadmapIdeas['workspace'];
            $activity['created_by']     = $RoadmapIdeas['created_by'];
            $activity->save();
        }
    }
}
