<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\TVStudio\Events\UpdateTvStudioCustomPage;

class UpdateTvStudioCustomPageLis
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
    public function handle(UpdateTvStudioCustomPage $event)
    {
        if (module_is_active('ActivityLog')) {
            $custom_page = $event->custom_page;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Movie & TV Studio';
            $activity['sub_module']     = 'Custom Pages';
            $activity['description']    = __('Custom Page updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $custom_page['workspace_id'];
            $activity['created_by']     = $custom_page['created_by'];
            $activity->save();
        }
    }
}
