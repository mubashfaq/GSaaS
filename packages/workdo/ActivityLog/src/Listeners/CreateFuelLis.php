<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Fleet\Entities\Vehicle;
use Workdo\Fleet\Events\CreateFuel;

class CreateFuelLis
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
    public function handle(CreateFuel $event)
    {
        if (module_is_active('ActivityLog')) {
            $fuel = $event->fuel;
            $vehicle = Vehicle::find($fuel->vehicle_name);
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Fleet';
            $activity['sub_module']     = 'Fuel History';
            $activity['description']    = __('Fuel Created of vehicle ') . $vehicle->name . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $fuel->workspace;
            $activity['created_by']     = $fuel->created_by;
            $activity->save();
        }
    }
}
