<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Bookings\Events\UpdateBookingsPackage;

class UpdateBookingsPackageLis
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
    public function handle(UpdateBookingsPackage $event)
    {
        if (module_is_active('ActivityLog')) {
            $bookingextraservice = $event->bookingextraservice;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Bookings';
            $activity['sub_module']     = 'Package';
            $activity['description']    = __('Package updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $bookingextraservice['workspace'];
            $activity['created_by']     = $bookingextraservice['created_by'];
            $activity->save();
        }
    }
}
