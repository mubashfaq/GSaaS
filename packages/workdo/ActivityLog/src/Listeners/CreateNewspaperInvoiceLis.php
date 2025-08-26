<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Newspaper\Events\CreateNewspaperInvoice;

class CreateNewspaperInvoiceLis
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
    public function handle(CreateNewspaperInvoice $event)
    {
        if (module_is_active('ActivityLog')) {
            $invoice = $event->invoice;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Newspaper';
            $activity['sub_module']     = 'Invoice';
            $activity['description']    = __('New Invoice Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $invoice->workspace;
            $activity['created_by']     = $invoice->created_by;
            $activity->save();
        }
    }
}
