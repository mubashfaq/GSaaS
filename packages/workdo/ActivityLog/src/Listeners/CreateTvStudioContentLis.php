<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\TVStudio\Events\CreateTvStudioContent;

class CreateTvStudioContentLis
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
    public function handle(CreateTvStudioContent $event)
    {
        if (module_is_active('ActivityLog')) {
            $content = $event->content;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Movie & TV Studio';
            $activity['sub_module']     = 'Content';
            $activity['description']    = __('New Content created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $content['workspace_id'];
            $activity['created_by']     = $content['created_by'];
            $activity->save();
        }
    }
}
