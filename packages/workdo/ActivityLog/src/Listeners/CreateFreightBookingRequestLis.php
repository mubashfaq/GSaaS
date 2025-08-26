<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\FreightManagementSystem\Events\CreateFreightBookingRequest;

class CreateFreightBookingRequestLis
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
    public function handle(CreateFreightBookingRequest $event)
    {
        if (module_is_active('ActivityLog')) {
            $booking_request = $event->booking_request;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Freight';
            $activity['sub_module']     = 'Booking';
            $activity['description']    = __('New Booking Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $booking_request->workspace;
            $activity['created_by']     = $booking_request->created_by;
            $activity->save();
        }
    }
}
