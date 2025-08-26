<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Newspaper\Events\CreateNewspaperJournalist;

class CreateNewspaperJournalistLis
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
    public function handle(CreateNewspaperJournalist $event)
    {
        if (module_is_active('ActivityLog')) {
            $journalistDetails = $event->journalistDetails;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Newspaper';
            $activity['sub_module']     = 'Journalist';
            $activity['description']    = __('New Journalist Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $journalistDetails->workspace;
            $activity['created_by']     = $journalistDetails->created_by;
            $activity->save();
        }
    }
}
