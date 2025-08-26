<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\HospitalManagement\Entities\Patient;
use Workdo\HospitalManagement\Events\UpdateHospitalAppointment;

class UpdateHospitalAppointmentLis
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
    public function handle(UpdateHospitalAppointment $event)
    {
        if (module_is_active('ActivityLog')) {
            $hospitalappointment = $event->hospitalappointment;
            $patient = Patient::find($hospitalappointment->patient_id);
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Hospital';
            $activity['sub_module']     = 'Appointments';
            $activity['description']    = __('Appointment Updated of patient ') . $patient->name . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $hospitalappointment->workspace;
            $activity['created_by']     = $hospitalappointment->created_by;
            $activity->save();
        }
    }
}
