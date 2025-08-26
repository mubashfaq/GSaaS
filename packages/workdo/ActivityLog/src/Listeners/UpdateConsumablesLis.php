<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\FixEquipment\Events\UpdateConsumables;

class UpdateConsumablesLis
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
    public function handle(UpdateConsumables $event)
    {
        if (module_is_active('ActivityLog')) {
            $consumables = $event->consumables;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Fix Equipment';
            $activity['sub_module']     = 'Consumables';
            $activity['description']    = __('Consumables Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $consumables->workspace;
            $activity['created_by']     = $consumables->created_by;
            $activity->save();
        }
    }
}
