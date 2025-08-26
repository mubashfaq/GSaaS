<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\TourTravelManagement\Events\CreateTour;

class CreateTourLis
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
    public function handle(CreateTour $event)
    {
        if (module_is_active('ActivityLog')) {
            $tour = $event->tour;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Tour & Travel';
            $activity['sub_module']     = 'Tour';
            $activity['description']    = __('New Tour Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $tour->workspace;
            $activity['created_by']     = $tour->created_by;
            $activity->save();
        }
    }
}
