<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\BeautySpaManagement\Events\UpdateWorkingHours;

class UpdateWorkingHoursLis
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
    public function handle(UpdateWorkingHours $event)
    {
        if (module_is_active('ActivityLog')) {
            $data = $event->data;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Beauty Spa';
            $activity['sub_module']     = 'Working Hours';
            $activity['description']    = __('Working Hours Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $data['workspace'];
            $activity['created_by']     = $data['created_by'];
            $activity->save();
        }
    }
}
