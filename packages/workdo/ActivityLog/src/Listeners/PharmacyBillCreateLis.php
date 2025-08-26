<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\PharmacyManagement\Events\PharmacyBillCreate;

class PharmacyBillCreateLis
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
    public function handle(PharmacyBillCreate $event)
    {
        if (module_is_active('ActivityLog')) {
            $PharmacyBill = $event->PharmacyBill;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Pharmacy';
            $activity['sub_module']     = 'Bill';
            $activity['description']    = __('New Bill Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $PharmacyBill->workspace_id;
            $activity['created_by']     = $PharmacyBill->created_by;
            $activity->save();
        }
    }
}
