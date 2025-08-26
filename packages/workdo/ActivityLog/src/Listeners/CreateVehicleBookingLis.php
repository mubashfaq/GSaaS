<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Fleet\Entities\Vehicle;
use Workdo\VehicleBookingManagement\Events\CreateVehicleBooking;

class CreateVehicleBookingLis
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
    public function handle(CreateVehicleBooking $event)
    {
        if (module_is_active('ActivityLog')) {
            $booking = $event->booking;
            $vehicle = Vehicle::find($booking->vehicle_id);
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Vehicle Booking';
            $activity['sub_module']     = 'Vehicle Bookings';
            $activity['description']    = __('New Booking Created of vehicle ') . $vehicle->name . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $booking->workspace;
            $activity['created_by']     = $booking->created_by;
            $activity->save();
        }
    }
}
