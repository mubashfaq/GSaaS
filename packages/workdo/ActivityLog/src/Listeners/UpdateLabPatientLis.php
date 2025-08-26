<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MedicalLabManagement\Events\UpdateLabPatient;

class UpdateLabPatientLis
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
    public function handle(UpdateLabPatient $event)
    {
        if (module_is_active('ActivityLog')) {
            $patient = $event->patient;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Medical Lab';
            $activity['sub_module']     = 'Patients';
            $activity['description']    = __('Patient Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $patient->workspace_id;
            $activity['created_by']     = $patient->created_by;
            $activity->save();
        }
    }
}
