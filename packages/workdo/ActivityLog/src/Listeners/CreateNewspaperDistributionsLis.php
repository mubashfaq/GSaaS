<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Newspaper\Events\CreateNewspaperDistributions;

class CreateNewspaperDistributionsLis
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
    public function handle(CreateNewspaperDistributions $event)
    {
        if (module_is_active('ActivityLog')) {
            $distribution = $event->distribution;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Newspaper';
            $activity['sub_module']     = 'Distribution Center';
            $activity['description']    = __('New Distribution Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $distribution->workspace;
            $activity['created_by']     = $distribution->created_by;
            $activity->save();
        }
    }
}
