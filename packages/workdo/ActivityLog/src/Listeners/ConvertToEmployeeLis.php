<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Recruitment\Entities\JobApplication;
use Workdo\Recruitment\Events\ConvertToEmployee;

class ConvertToEmployeeLis
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
    public function handle(ConvertToEmployee $event)
    {
        if (module_is_active('ActivityLog')) {
            $employee = $event->employee;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Recruitment';
            $activity['sub_module']     = 'Job On-boarding';
            $activity['description']    = __('Candidate Converted to employee ') . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $employee->workspace;
            $activity['created_by']     = $employee->created_by;
            $activity->save();
        }
    }
}
