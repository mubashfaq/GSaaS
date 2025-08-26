<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\SWOTAnalysisModel\Events\UpdateSWOTAnalysismodel;

class UpdateSWOTAnalysismodelLis
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
    public function handle(UpdateSWOTAnalysismodel $event)
    {
        if (module_is_active('ActivityLog')) {
            $swotanalysismodel = $event->swotanalysismodel;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'SWOT Analysis Model';
            $activity['description']    =  __('SWOT Analysis Model updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $swotanalysismodel['workspace'];
            $activity['created_by']     = $swotanalysismodel['created_by'];
            $activity->save();
        }
    }
}
