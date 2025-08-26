<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use App\Models\Purchase;
use App\Events\CreatePaymentPurchase;

class CreatePaymentPurchaseLis
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
    public function handle(CreatePaymentPurchase $event)
    {
        if (module_is_active('ActivityLog')) {
            $payment = $event->payment;
            $purchase = $event->purchase;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Purchases';
            $activity['sub_module']     = 'Purchase';
            $activity['description']    = __('New Payment Add in purchase ') . Purchase::purchaseNumberFormat($payment->purchase_id) . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $purchase->workspace;
            $activity['created_by']     = $purchase->created_by;
            $activity->save();
        }
    }
}
