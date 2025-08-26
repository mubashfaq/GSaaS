<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\Account\Entities\Bill;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Account\Events\CreatePaymentBill;

class CreatePaymentBillLis
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
    public function handle(CreatePaymentBill $event)
    {
        if (module_is_active('ActivityLog')) {
            $bill = $event->bill;
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Accounting';
            $activity['sub_module']     = 'Expense';
            $activity['description']    = __('New Payment Add in bill') . Bill::billNumberFormat($bill->bill_id) . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $bill->workspace;
            $activity['created_by']     = $bill->created_by;
            $activity->save();
        }
    }
}
