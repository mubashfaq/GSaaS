<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\GymManagement\Events\UpdateMeasurement;

class UpdateMeasurementLis
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
    public function handle(UpdateMeasurement $event)
    {
        if (module_is_active('ActivityLog')) {
            $measurement = $event->measurement;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'GYM Management';
            $activity['sub_module']     = 'Measurement';
            $activity['description']    = __('Measurement Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $measurement->workspace;
            $activity['created_by']     = $measurement->created_by;
            $activity->save();
        }
    }
}
