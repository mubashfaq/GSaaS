<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\VCard\Events\UpdateBusiness;

class UpdateBusinessLis
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
    public function handle(UpdateBusiness $event)
    {
        if (module_is_active('ActivityLog')) {
            $business = $event->request;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'vCard';
            $activity['sub_module']     = 'Businesss';
            $activity['description']    = __('Business ') . $business->title . __(' Details Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $business->workspace;
            $activity['created_by']     = $business->created_by;
            $activity->save();
        }
    }
}
