<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Hrm\Entities\Employee;
use Workdo\Hrm\Events\CreateMarkAttendance;

class CreateMarkAttendanceLis
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
    public function handle(CreateMarkAttendance $event)
    {
        if (module_is_active('ActivityLog')) {
            $employeeAttendance = $event->employeeAttendance;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'HRM';
            $activity['sub_module']     = 'Leave Management';
            $activity['description']    = __('New Attendance created of employee ') . Employee::employeeIdFormat($employeeAttendance->employee_id) . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $employeeAttendance->workspace;
            $activity['created_by']     = $employeeAttendance->created_by;
            $activity->save();
        }
    }
}
