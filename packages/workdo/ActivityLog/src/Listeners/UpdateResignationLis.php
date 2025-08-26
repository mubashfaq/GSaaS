<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Hrm\Entities\Employee;
use Workdo\Hrm\Events\UpdateResignation;

class UpdateResignationLis
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
    public function handle(UpdateResignation $event)
    {
        if (module_is_active('ActivityLog')) {
            $resignation = $event->resignation;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'HRM';
            $activity['sub_module']     = 'HR Admin';
            $activity['description']    = __('Resignation Updated for employee ') . Employee::employeeIdFormat($resignation->employee_id) . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $resignation->workspace;
            $activity['created_by']     = $resignation->created_by;
            $activity->save();
        }
    }
}
