<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\LMS\Events\UpdateCourse;

class UpdateCourseLis
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
    public function handle(UpdateCourse $event)
    {
        if (module_is_active('ActivityLog')) {
            $course = $event->course;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'LMS';
            $activity['sub_module']     = 'Course';
            $activity['description']    = __('Course Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $course->workspace_id;
            $activity['created_by']     = $course->created_by;
            $activity->save();
        }
    }
}
