<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\RoadMapCentral\Events\UpdateRoadmap;

class UpdateRoadmapLis
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
    public function handle(UpdateRoadmap $event)
    {
        if (module_is_active('ActivityLog')) {
            $Roadmap = $event->Roadmap;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'RoadMap Central';
            $activity['sub_module']     = 'RoadMap';
            $activity['description']    =  __('RoadMap updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $Roadmap['workspace'];
            $activity['created_by']     = $Roadmap['created_by'];
            $activity->save();
        }
    }
}
