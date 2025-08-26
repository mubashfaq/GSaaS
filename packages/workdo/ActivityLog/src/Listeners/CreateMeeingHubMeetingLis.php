<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MeetingHub\Events\CreateMeeingHubMeeting;

class CreateMeeingHubMeetingLis
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
    public function handle(CreateMeeingHubMeeting $event)
    {
        if (module_is_active('ActivityLog')) {
            $meeting = $event->meeting;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Meeting Hub';
            $activity['sub_module']     = 'Meeting List';
            $activity['description']    =  __('New Meeting created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $meeting['workspace_id'];
            $activity['created_by']     = $meeting['created_by'];
            $activity->save();
        }
    }
}
