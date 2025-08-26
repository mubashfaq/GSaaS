<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\PESTAnalysisModel\Events\CreatePESTAnalysisModel;

class CreatePESTAnalysisModelLis
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
    public function handle(CreatePESTAnalysisModel $event)
    {
        if (module_is_active('ActivityLog')) {
            $pestanalysis = $event->pestanalysis;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'PEST Analysis Model';
            $activity['description']    =  __('New PEST Analysis Model created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $pestanalysis['workspace'];
            $activity['created_by']     = $pestanalysis['created_by'];
            $activity->save();
        }
    }
}
