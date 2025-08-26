<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Recruitment\Events\CreateJobApplicationStageChange;

class CreateJobApplicationStageChangeLis
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
    public function handle(CreateJobApplicationStageChange $event)
    {
        if (module_is_active('ActivityLog')) {
            $application = $event->application;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Recruitment';
            $activity['sub_module']     = 'Job Application';
            $activity['description']    = __('Job Application Status updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $application->workspace;
            $activity['created_by']     = $application->created_by;
            $activity->save();
        }
    }
}
