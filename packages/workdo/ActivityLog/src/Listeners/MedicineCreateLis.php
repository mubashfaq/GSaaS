<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\PharmacyManagement\Events\MedicineCreate;

class MedicineCreateLis
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
    public function handle(MedicineCreate $event)
    {
        if (module_is_active('ActivityLog')) {
            $medicine = $event->medicine;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Pharmacy';
            $activity['sub_module']     = 'Medicine';
            $activity['description']    = __('New Medicine Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $medicine->workspace_id;
            $activity['created_by']     = $medicine->created_by;
            $activity->save();
        }
    }
}
