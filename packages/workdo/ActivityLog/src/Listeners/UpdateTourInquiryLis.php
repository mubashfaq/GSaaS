<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\TourTravelManagement\Events\UpdateTourInquiry;

class UpdateTourInquiryLis
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
    public function handle(UpdateTourInquiry $event)
    {
        if (module_is_active('ActivityLog')) {
            $tour = $event->tour;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Tour & Travel';
            $activity['sub_module']     = 'Tourist Inquiry';
            $activity['description']    = __('Tourist Inquiry Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $tour->workspace;
            $activity['created_by']     = $tour->created_by;
            $activity->save();
        }
    }
}
