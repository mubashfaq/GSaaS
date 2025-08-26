<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\AgricultureManagement\Events\UpdateAgricultureEquipment;

class UpdateAgricultureEquipmentLis
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
    public function handle(UpdateAgricultureEquipment $event)
    {
        if (module_is_active('ActivityLog')) {
            $agricultureequipment = $event->agricultureequipment;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Agriculture';
            $activity['sub_module']     = 'Agriculture Equipment';
            $activity['description']    = __('Agriculture Equipment Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $agricultureequipment->workspace;
            $activity['created_by']     = $agricultureequipment->created_by;
            $activity->save();
        }
    }
}
