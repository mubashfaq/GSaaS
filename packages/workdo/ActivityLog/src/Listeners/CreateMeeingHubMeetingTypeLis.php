<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MeetingHub\Events\CreateMeeingHubMeetingType;

class CreateMeeingHubMeetingTypeLis
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
    public function handle(CreateMeeingHubMeetingType $event)
    {
        if (module_is_active('ActivityLog')) {
            $meetingtype = $event->meetingtype;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Meeting Hub';
            $activity['sub_module']     = 'Meeting Type';
            $activity['description']    =  __('New Meeting Type created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $meetingtype['workspace'];
            $activity['created_by']     = $meetingtype['created_by'];
            $activity->save();
        }
    }
}
