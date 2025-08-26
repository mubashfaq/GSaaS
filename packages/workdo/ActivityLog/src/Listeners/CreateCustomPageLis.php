<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\LMS\Events\CreateCustomPage;

class CreateCustomPageLis
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
    public function handle(CreateCustomPage $event)
    {
        if (module_is_active('ActivityLog')) {
            $pageOption = $event->pageOption;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'LMS';
            $activity['sub_module']     = 'Custom Page';
            $activity['description']    = __('New Custom Page Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $pageOption->workspace_id;
            $activity['created_by']     = $pageOption->created_by;
            $activity->save();
        }
    }
}
