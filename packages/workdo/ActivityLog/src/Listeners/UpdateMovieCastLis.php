<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MovieShowBookingSystem\Events\UpdateMovieCast;

class UpdateMovieCastLis
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
    public function handle(UpdateMovieCast $event)
    {
        if (module_is_active('ActivityLog')) {
            $moviecast = $event->moviecast;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Movie Show Booking';
            $activity['sub_module']     = 'Movie Cast';
            $activity['description']    = __('Movie Cast updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $moviecast['workspace'];
            $activity['created_by']     = $moviecast['created_by'];
            $activity->save();
        }
    }
}
