<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\PropertyManagement\Events\CreatePropertyUnit;

class CreatePropertyUnitLis
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
    public function handle(CreatePropertyUnit $event)
    {
        if (module_is_active('ActivityLog')) {
            $propertyUnit = $event->propertyUnit;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Property Manage';
            $activity['sub_module']     = 'Units';
            $activity['description']    = __('New Unit Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $propertyUnit->workspace;
            $activity['created_by']     = $propertyUnit->created_by;
            $activity->save();
        }
    }
}
