<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Bookings\Entities\BookingsAppointment;
use Workdo\Bookings\Events\CreateBookingsAppointment;

class CreateBookingsAppointmentLis
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
    public function handle(CreateBookingsAppointment $event)
    {
        if (module_is_active('ActivityLog')) {
            $bookingsappointment = $event->bookingsappointment;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Bookings';
            $activity['sub_module']     = 'Appointments';
            $activity['description']    = __('New Appointment ') . BookingsAppointment::appointmentNumberFormat($bookingsappointment->appointment_id) . __(' created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $bookingsappointment['workspace'];
            $activity['created_by']     = $bookingsappointment['created_by'];
            $activity->save();
        }
    }
}
