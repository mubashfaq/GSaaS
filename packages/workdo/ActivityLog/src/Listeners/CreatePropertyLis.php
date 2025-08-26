<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\PropertyManagement\Events\CreateProperty;

class CreatePropertyLis
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
    public function handle(CreateProperty $event)
    {
        if (module_is_active('ActivityLog')) {
            $property = $event->property;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Property Manage';
            $activity['sub_module']     = 'Property';
            $activity['description']    = __('New Property Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $property->workspace;
            $activity['created_by']     = $property->created_by;
            $activity->save();
        }
    }
}
