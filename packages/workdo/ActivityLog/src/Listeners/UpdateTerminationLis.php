<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Hrm\Entities\Employee;
use Workdo\Hrm\Events\UpdateTermination;

class UpdateTerminationLis
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
    public function handle(UpdateTermination $event)
    {
        if (module_is_active('ActivityLog')) {
            $termination = $event->termination;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'HRM';
            $activity['sub_module']     = 'HR Admin';
            $activity['description']    = __('Termination Updated of employee ') . Employee::employeeIdFormat($termination->employee_id)  . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $termination->workspace;
            $activity['created_by']     = $termination->created_by;
            $activity->save();
        }
    }
}
