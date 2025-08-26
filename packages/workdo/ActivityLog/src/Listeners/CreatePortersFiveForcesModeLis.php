<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\PortersFiveForcesModel\Events\CreatePortersFiveForcesMode;

class CreatePortersFiveForcesModeLis
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
    public function handle(CreatePortersFiveForcesMode $event)
    {
        if (module_is_active('ActivityLog')) {
            $PortersModel = $event->PortersModel;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'Porter’s Five Forces Model';
            $activity['description']    =  __('New Porter’s Five Forces Model created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $PortersModel['workspace'];
            $activity['created_by']     = $PortersModel['created_by'];
            $activity->save();
        }
    }
}
