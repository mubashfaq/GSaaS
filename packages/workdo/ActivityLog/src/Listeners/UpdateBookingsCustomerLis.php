<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Bookings\Events\UpdateBookingsCustomer;

class UpdateBookingsCustomerLis
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
    public function handle(UpdateBookingsCustomer $event)
    {
        if (module_is_active('ActivityLog')) {
            $bookingscustomer = $event->bookingscustomer;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Bookings';
            $activity['sub_module']     = 'Customers';
            $activity['description']    = __('Customer updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $bookingscustomer['workspace'];
            $activity['created_by']     = $bookingscustomer['created_by'];
            $activity->save();
        }
    }
}
