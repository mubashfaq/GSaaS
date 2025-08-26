<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Performance\Events\UpdateAppraisal;

class UpdateAppraisalLis
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
    public function handle(UpdateAppraisal $event)
    {
        if (module_is_active('ActivityLog')) {
            $appraisal = $event->appraisal;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'HRM';
            $activity['sub_module']     = 'Performance';
            $activity['description']    = __('Appraisal Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $appraisal->workspace;
            $activity['created_by']     = $appraisal->created_by;
            $activity->save();
        }
    }
}
