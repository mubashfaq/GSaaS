<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CMMS\Events\UpdateComponent;

class UpdateComponentLis
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
    public function handle(UpdateComponent $event)
    {
        if (module_is_active('ActivityLog')) {
            $component = $event->request;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'CMMS';
            $activity['sub_module']     = 'Components';
            $activity['description']    = __('Component Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $component->workspace;
            $activity['created_by']     = $component->created_by;
            $activity->save();
        }
    }
}
