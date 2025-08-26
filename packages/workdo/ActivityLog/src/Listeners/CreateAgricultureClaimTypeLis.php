<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\AgricultureManagement\Events\CreateAgricultureClaimType;

class CreateAgricultureClaimTypeLis
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
    public function handle(CreateAgricultureClaimType $event)
    {
        if (module_is_active('ActivityLog')) {
            $claimtype = $event->claimtype;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Agriculture';
            $activity['sub_module']     = 'Claim Type';
            $activity['description']    = __('New Claim Type Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $claimtype->workspace;
            $activity['created_by']     = $claimtype->created_by;
            $activity->save();
        }
    }
}
