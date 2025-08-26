<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\DairyCattleManagement\Events\CreateBreeding;

class CreateBreedingLis
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
    public function handle(CreateBreeding $event)
    {
        if (module_is_active('ActivityLog')) {
            $breeding = $event->breeding;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Dairy Cattle';
            $activity['sub_module']     = 'Breeding';
            $activity['description']    = __('New Breeding created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $breeding['workspace'];
            $activity['created_by']     = $breeding['created_by'];
            $activity->save();
        }
    }
}
