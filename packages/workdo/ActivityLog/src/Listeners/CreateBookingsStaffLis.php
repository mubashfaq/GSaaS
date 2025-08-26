<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Bookings\Events\CreateBookingsStaff;

class CreateBookingsStaffLis
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
    public function handle(CreateBookingsStaff $event)
    {
        if (module_is_active('ActivityLog')) {
            $bookingstaffs = $event->bookingstaffs;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Bookings';
            $activity['sub_module']     = 'Staff';
            $activity['description']    = __('New Staff created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $bookingstaffs['workspace'];
            $activity['created_by']     = $bookingstaffs['created_by'];
            $activity->save();
        }
    }
}
