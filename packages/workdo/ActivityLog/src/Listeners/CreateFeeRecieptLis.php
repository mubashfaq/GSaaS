<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\LegalCaseManagement\Events\CreateFeeReciept;

class CreateFeeRecieptLis
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
    public function handle(CreateFeeReciept $event)
    {
        if (module_is_active('ActivityLog')) {
            $feeReciept = $event->feeReciept;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Legal Case';
            $activity['sub_module']     = 'Fee/Bills';
            $activity['description']    = __('New Fee Reciept Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $feeReciept->workspace;
            $activity['created_by']     = $feeReciept->created_by;
            $activity->save();
        }
    }
}
