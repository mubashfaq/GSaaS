<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Quotation\Entities\Quotation;
use Workdo\Quotation\Events\CreateQuotation;

class CreateQuotationLis
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
    public function handle(CreateQuotation $event)
    {
        if (module_is_active('ActivityLog')) {
            $quotation = $event->quotation;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Quotation';
            $activity['sub_module']     = '--';
            $activity['description']    = __('New Quotation ') . Quotation::quotationNumberFormat($quotation->quotation_id) . __(' created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $quotation['workspace'];
            $activity['created_by']     = $quotation['created_by'];
            $activity->save();
        }
    }
}
