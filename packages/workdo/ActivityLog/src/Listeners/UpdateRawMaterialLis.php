<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\BeverageManagement\Events\UpdateRawMaterial;

class UpdateRawMaterialLis
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
    public function handle(UpdateRawMaterial $event)
    {
        if (module_is_active('ActivityLog')) {
            $raw_material = $event->raw_material;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Beverage';
            $activity['sub_module']     = 'Raw Material';
            $activity['description']    = __('Raw Material Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $raw_material->workspace;
            $activity['created_by']     = $raw_material->created_by;
            $activity->save();
        }
    }
}
