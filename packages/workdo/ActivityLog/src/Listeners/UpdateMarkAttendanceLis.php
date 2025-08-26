<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Hrm\Entities\Employee;
use Workdo\Hrm\Events\UpdateMarkAttendance;

class UpdateMarkAttendanceLis
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
    public function handle(UpdateMarkAttendance $event)
    {
        if (module_is_active('ActivityLog')) {
            $attendance = $event->attendance;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'HRM';
            $activity['sub_module']     = 'Leave Management';
            $activity['description']    = __('Attendance Updated of employee ') . Employee::employeeIdFormat($attendance->employee_id) . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $attendance->workspace;
            $activity['created_by']     = $attendance->created_by;
            $activity->save();
        }
    }
}
