<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Retainer\Events\RetainerConvertToInvoice;

class RetainerConvertToInvoiceLis
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
    public function handle(RetainerConvertToInvoice $event)
    {
        if (module_is_active('ActivityLog')) {
            $convertInvoice = $event->convertInvoice;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Retainer';
            $activity['sub_module']     = '--';
            $activity['description']    = __('Retainer Converted to Invoice by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $convertInvoice->workspace;
            $activity['created_by']     = $convertInvoice->created_by;
            $activity->save();
        }
    }
}
