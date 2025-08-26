<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CleaningManagement\Events\UpdateCleaningBooking;

class UpdateCleaningBookingLis
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
    public function handle(UpdateCleaningBooking $event)
    {
        if (module_is_active('ActivityLog')) {
            $booking = $event->booking;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Cleaning';
            $activity['sub_module']     = 'Booking Request';
            $activity['description']    = __('Booking Request Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $booking->workspace;
            $activity['created_by']     = $booking->created_by;
            $activity->save();
        }
    }
}
