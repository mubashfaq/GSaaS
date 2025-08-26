<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Hrm\Entities\Employee;
use Workdo\Hrm\Events\UpdateAllowance;

class UpdateAllowanceLis
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
    public function handle(UpdateAllowance $event)
    {
        if (module_is_active('ActivityLog')) {
            $allowance = $event->allowance;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'HRM';
            $activity['sub_module']     = 'Payroll';
            $activity['description']    = __('Allowance Updated of employee ') . Employee::employeeIdFormat($allowance->employee_id) . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $allowance->workspace;
            $activity['created_by']     = $allowance->created_by;
            $activity->save();
        }
    }
}
