<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\School\Events\UpdateSchoolHomework;

class UpdateSchoolHomeworkLis
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
    public function handle(UpdateSchoolHomework $event)
    {
        if (module_is_active('ActivityLog')) {
            $homework = $event->homework;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'School & Institute';
            $activity['sub_module']     = 'Home work';
            $activity['description']    = __('Homework Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $homework->workspace;
            $activity['created_by']     = $homework->created_by;
            $activity->save();
        }
    }
}
