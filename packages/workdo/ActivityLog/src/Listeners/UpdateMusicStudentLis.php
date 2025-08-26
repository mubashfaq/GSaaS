<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MusicInstitute\Events\UpdateMusicStudent;

class UpdateMusicStudentLis
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
    public function handle(UpdateMusicStudent $event)
    {
        if (module_is_active('ActivityLog')) {
            $student = $event->student;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Music Institute';
            $activity['sub_module']     = 'Student';
            $activity['description']    = __('Student Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $student->workspace;
            $activity['created_by']     = $student->created_by;
            $activity->save();
        }
    }
}
