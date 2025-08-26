<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\DairyCattleManagement\Events\UpdateHealth;

class UpdateHealthLis
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
    public function handle(UpdateHealth $event)
    {
        if (module_is_active('ActivityLog')) {
            $health = $event->health;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Dairy Cattle';
            $activity['sub_module']     = 'Health';
            $activity['description']    = __('Health updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $health['workspace'];
            $activity['created_by']     = $health['created_by'];
            $activity->save();
        }
    }
}
