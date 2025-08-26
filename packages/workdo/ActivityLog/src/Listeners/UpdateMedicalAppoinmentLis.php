<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MedicalLabManagement\Entities\Patient;
use Workdo\MedicalLabManagement\Events\UpdateMedicalAppoinment;

class UpdateMedicalAppoinmentLis
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
    public function handle(UpdateMedicalAppoinment $event)
    {
        if (module_is_active('ActivityLog')) {
            $labAppoinments = $event->labAppoinments;
            $patient = Patient::find($labAppoinments->patient_id);
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Medical Lab';
            $activity['sub_module']     = 'Appointment';
            $activity['description']    = __('Appointment Updated of Patient ') . $patient->first_name . __(' ') . $patient->last_name . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $labAppoinments->workspace_id;
            $activity['created_by']     = $labAppoinments->created_by;
            $activity->save();
        }
    }
}
