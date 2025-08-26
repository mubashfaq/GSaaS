<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Account\Events\UpdateBankTransfer;

class UpdateBankTransferLis
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
    public function handle(UpdateBankTransfer $event)
    {
        if (module_is_active('ActivityLog')) {
            $transfer = $event->transfer;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Accounting';
            $activity['sub_module']     = 'Banking';
            $activity['description']    = __('Bank Balance Transfer Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $transfer->workspace;
            $activity['created_by']     = $transfer->created_by;
            $activity->save();
        }
    }
}
