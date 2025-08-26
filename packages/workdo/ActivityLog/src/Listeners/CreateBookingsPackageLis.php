<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Bookings\Events\CreateBookingsPackage;

class CreateBookingsPackageLis
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
    public function handle(CreateBookingsPackage $event)
    {
        if (module_is_active('ActivityLog')) {
            $bookingspackage = $event->bookingspackage;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Bookings';
            $activity['sub_module']     = 'Package';
            $activity['description']    = __('New Package created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $bookingspackage['workspace'];
            $activity['created_by']     = $bookingspackage['created_by'];
            $activity->save();
        }
    }
}
