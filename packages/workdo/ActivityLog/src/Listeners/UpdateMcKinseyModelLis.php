<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\McKinseyModel\Events\UpdateMcKinseyModel;

class UpdateMcKinseyModelLis
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
    public function handle(UpdateMcKinseyModel $event)
    {
        if (module_is_active('ActivityLog')) {
            $Mckinsey = $event->Mckinsey;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'McKinsey 7-S Model';
            $activity['description']    =  __('McKinsey 7-S Model updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $Mckinsey['workspace'];
            $activity['created_by']     = $Mckinsey['created_by'];
            $activity->save();
        }
    }
}
