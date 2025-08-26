<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\School\Events\UpdateSubject;

class UpdateSubjectLis
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
    public function handle(UpdateSubject $event)
    {
        if (module_is_active('ActivityLog')) {
            $subject = $event->subject;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'School & Institute';
            $activity['sub_module']     = 'Subject';
            $activity['description']    = __('Subject Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $subject->workspace;
            $activity['created_by']     = $subject->created_by;
            $activity->save();
        }
    }
}
