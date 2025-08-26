<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MovieShowBookingSystem\Events\UpdateMovieShow;

class UpdateMovieShowLis
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
    public function handle(UpdateMovieShow $event)
    {
        if (module_is_active('ActivityLog')) {
            $movieshow = $event->movieshow;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Movie Show Booking';
            $activity['sub_module']     = 'Manage Movie Show';
            $activity['description']    = __('Movie Show updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $movieshow['workspace'];
            $activity['created_by']     = $movieshow['created_by'];
            $activity->save();
        }
    }
}
