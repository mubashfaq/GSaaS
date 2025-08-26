<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MachineRepairManagement\Events\CreateDiagnosis;

class CreateDiagnosisLis
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
    public function handle(CreateDiagnosis $event)
    {
        if (module_is_active('ActivityLog')) {
            $invoice = $event->invoice;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Machine Repair';
            $activity['sub_module']     = 'Diagnosis';
            $activity['description']    = __('New Diagnosis Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $invoice->workspace;
            $activity['created_by']     = $invoice->created_by;
            $activity->save();
        }
    }
}
