<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\DrivingSchool\Entities\DrivingClass;
use Workdo\DrivingSchool\Events\UpdateDrivingClass;

class UpdateDrivingClassLis
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
    public function handle(UpdateDrivingClass $event)
    {
        if (module_is_active('ActivityLog')) {
            $class = $event->class;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Driving School';
            $activity['sub_module']     = 'Class';
            $activity['description']    = __('Class ') . DrivingClass::classNumberFormat($class->driving_class_id) . __(' updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $class['workspace'];
            $activity['created_by']     = $class['created_by'];
            $activity->save();
        }
    }
}
