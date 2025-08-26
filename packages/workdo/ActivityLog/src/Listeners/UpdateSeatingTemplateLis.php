<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MovieShowBookingSystem\Events\UpdateSeatingTemplate;

class UpdateSeatingTemplateLis
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
    public function handle(UpdateSeatingTemplate $event)
    {
        if (module_is_active('ActivityLog')) {
            $seatingtemplate = $event->seatingtemplate;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Movie Show Booking';
            $activity['sub_module']     = 'Seating Layout';
            $activity['description']    = __('Seating Layout updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $seatingtemplate['workspace'];
            $activity['created_by']     = $seatingtemplate['created_by'];
            $activity->save();
        }
    }
}
