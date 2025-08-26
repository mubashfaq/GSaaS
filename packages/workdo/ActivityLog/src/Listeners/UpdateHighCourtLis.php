<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\LegalCaseManagement\Events\UpdateHighCourt;

class UpdateHighCourtLis
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
    public function handle(UpdateHighCourt $event)
    {
        if (module_is_active('ActivityLog')) {
            $highCourt = $event->highCourt;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Legal Case';
            $activity['sub_module']     = 'High Courts';
            $activity['description']    = __('High Court Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $highCourt->workspace;
            $activity['created_by']     = $highCourt->created_by;
            $activity->save();
        }
    }
}
