<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\FixEquipment\Events\UpdateAccessories;

class UpdateAccessoriesLis
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
    public function handle(UpdateAccessories $event)
    {
        if (module_is_active('ActivityLog')) {
            $accessories = $event->accessories;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Fix Equipment';
            $activity['sub_module']     = 'Accessories';
            $activity['description']    = __('Accessories Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $accessories->workspace;
            $activity['created_by']     = $accessories->created_by;
            $activity->save();
        }
    }
}
