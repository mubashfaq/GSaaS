<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\PESTAnalysisModel\Events\UpdatePESTAnalysisModel;

class UpdatePESTAnalysisModelLis
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
    public function handle(UpdatePESTAnalysisModel $event)
    {
        if (module_is_active('ActivityLog')) {
            $Pestanalysis = $event->Pestanalysis;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'PEST Analysis Model';
            $activity['description']    =  __('PEST Analysis Model updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $Pestanalysis['workspace'];
            $activity['created_by']     = $Pestanalysis['created_by'];
            $activity->save();
        }
    }
}
