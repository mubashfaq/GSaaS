<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Hrm\Entities\Branch;
use Workdo\Training\Events\CreateTrainer;

class CreateTrainerLis
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
    public function handle(CreateTrainer $event)
    {
        if (module_is_active('ActivityLog')) {
            $trainer = $event->trainer;
            $branch = Branch::find($trainer->branch);

            $activity                   = new AllActivityLog();
            $activity['module']         = 'HRM';
            $activity['sub_module']     = 'Training';
            $activity['description']    = __('New Trainer created in branch ') . $branch->name . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $trainer->workspace;
            $activity['created_by']     = $trainer->created_by;
            $activity->save();
        }
    }
}
