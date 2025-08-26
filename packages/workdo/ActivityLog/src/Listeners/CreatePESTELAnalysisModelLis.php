<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\PESTELAnalysisModel\Events\CreatePESTELAnalysisModel;

class CreatePESTELAnalysisModelLis
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
    public function handle(CreatePESTELAnalysisModel $event)
    {
        if (module_is_active('ActivityLog')) {
            $pestelanalysis = $event->pestelanalysis;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'PESTEL Analysis Model';
            $activity['description']    =  __('New PESTEL Analysis Model created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $pestelanalysis['workspace'];
            $activity['created_by']     = $pestelanalysis['created_by'];
            $activity->save();
        }
    }
}
