<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MusicInstitute\Events\CreateMusicTeacher;

class CreateMusicTeacherLis
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
    public function handle(CreateMusicTeacher $event)
    {
        if (module_is_active('ActivityLog')) {
            $teacher = $event->teacher;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Music Institute';
            $activity['sub_module']     = 'Teacher';
            $activity['description']    = __('New Teacher Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $teacher->workspace;
            $activity['created_by']     = $teacher->created_by;
            $activity->save();
        }
    }
}
