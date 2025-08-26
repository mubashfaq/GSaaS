<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CleaningManagement\Events\CreateCleaningTeam;

class CreateCleaningTeamLis
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
    public function handle(CreateCleaningTeam $event)
    {
        if (module_is_active('ActivityLog')) {
            $cleaning_team = $event->cleaning_team;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Cleaning';
            $activity['sub_module']     = 'Cleaning Team';
            $activity['description']    = __('New Cleaning Team Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $cleaning_team->workspace;
            $activity['created_by']     = $cleaning_team->created_by;
            $activity->save();
        }
    }
}
