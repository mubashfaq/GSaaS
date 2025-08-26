<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\LaundryManagement\Events\LundaryRequestInvoiceCreate;

class LundaryRequestInvoiceCreateLis
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
    public function handle(LundaryRequestInvoiceCreate $event)
    {
        if (module_is_active('ActivityLog')) {
            $invoice = $event->invoic;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Laundry';
            $activity['sub_module']     = 'Laundry Request';
            $activity['description']    = __('Laundry Request Status Accept And New Invoice Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $invoice->workspace_id;
            $activity['created_by']     = $invoice->created_by;
            $activity->save();
        }
    }
}
