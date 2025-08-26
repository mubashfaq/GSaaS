<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\BusinessModel\Events\CreateBusinessModel;

class CreateBusinessModelLis
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
    public function handle(CreateBusinessModel $event)
    {
        if (module_is_active('ActivityLog')) {
            $Charter = $event->Charter;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'Business Model';
            $activity['description']    =  __('New Business Model created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $Charter['workspace'];
            $activity['created_by']     = $Charter['created_by'];
            $activity->save();
        }
    }
}
