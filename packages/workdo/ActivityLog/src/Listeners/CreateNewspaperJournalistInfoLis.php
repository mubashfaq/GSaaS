<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Newspaper\Events\CreateNewspaperJournalistInfo;

class CreateNewspaperJournalistInfoLis
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
    public function handle(CreateNewspaperJournalistInfo $event)
    {
        if (module_is_active('ActivityLog')) {
            $information = $event->information;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Newspaper';
            $activity['sub_module']     = 'Journalist information';
            $activity['description']    = __('New Journalist information Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $information->workspace;
            $activity['created_by']     = $information->created_by;
            $activity->save();
        }
    }
}
