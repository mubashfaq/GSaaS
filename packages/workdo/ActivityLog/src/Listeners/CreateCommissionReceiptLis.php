<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Commission\Events\CreateCommissionReceipt;

class CreateCommissionReceiptLis
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
    public function handle(CreateCommissionReceipt $event)
    {
        if (module_is_active('ActivityLog')) {
            $commissionReceipt = $event->commissionReceipt;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Commission';
            $activity['sub_module']     = 'Commission Receipt';
            $activity['description']    = __('New Commission Receipt Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $commissionReceipt->workspace;
            $activity['created_by']     = $commissionReceipt->created_by;
            $activity->save();
        }
    }
}
