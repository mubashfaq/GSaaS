<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\DairyCattleManagement\Events\CreateMilkInventory;

class CreateMilkInventoryLis
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
    public function handle(CreateMilkInventory $event)
    {
        if (module_is_active('ActivityLog')) {
            $milkinventory = $event->milkinventory;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Dairy Cattle';
            $activity['sub_module']     = 'Milk Inventory';
            $activity['description']    = __('New Milk Inventory created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $milkinventory['workspace'];
            $activity['created_by']     = $milkinventory['created_by'];
            $activity->save();
        }
    }
}
