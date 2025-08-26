<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Performance\Events\CreateIndicator;

class CreateIndicatorLis
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
    public function handle(CreateIndicator $event)
    {
        if (module_is_active('ActivityLog')) {
            $indicator = $event->indicator;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'HRM';
            $activity['sub_module']     = 'Performance';
            $activity['description']    = __('New Indicator created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $indicator->workspace;
            $activity['created_by']     = $indicator->created_by;
            $activity->save();
        }
    }
}
