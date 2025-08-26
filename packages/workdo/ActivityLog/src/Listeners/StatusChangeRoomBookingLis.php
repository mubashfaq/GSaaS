<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Holidayz\Entities\RoomBooking;
use Workdo\Holidayz\Events\StatusChangeRoomBooking;

class StatusChangeRoomBookingLis
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
    public function handle(StatusChangeRoomBooking $event)
    {
        if (module_is_active('ActivityLog')) {
            $booking = $event->booking;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Hotel&Room';
            $activity['sub_module']     = 'Booking';
            $activity['description']    = __('Booking ') . RoomBooking::bookingNumberFormat($booking->booking_number) . __(' status changed by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $booking->workspace;
            $activity['created_by']     = $booking->created_by;
            $activity->save();
        }
    }
}
