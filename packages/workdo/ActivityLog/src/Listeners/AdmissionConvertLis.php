<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\School\Entities\Admission;
use Workdo\School\Events\AdmissionConvert;

class AdmissionConvertLis
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
    public function handle(AdmissionConvert $event)
    {
        if (module_is_active('ActivityLog')) {
            $admission = $event->admission;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'School & Institute';
            $activity['sub_module']     = 'Admission';
            $activity['description']    =  __('Admission ') . Admission::admissionNumberFormat($admission->admission_id) . __(' Converted to Student by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $admission->workspace;
            $activity['created_by']     = $admission->created_by;
            $activity->save();
        }
    }
}
