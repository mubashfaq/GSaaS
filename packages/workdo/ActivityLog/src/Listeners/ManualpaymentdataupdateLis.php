<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CourierManagement\Events\Manualpaymentdataupdate;

class ManualpaymentdataupdateLis
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
    public function handle(Manualpaymentdataupdate $event)
    {
        if (module_is_active('ActivityLog')) {
            $paymentDetails = $event->paymentDetails;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Courier';
            $activity['sub_module']     = 'Create Courier';
            $activity['description']    = __('Payment Details Updated in Courier ') . $paymentDetails->tracking_id . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $paymentDetails->workspace_id;
            $activity['created_by']     = $paymentDetails->created_by;
            $activity->save();
        }
    }
}
