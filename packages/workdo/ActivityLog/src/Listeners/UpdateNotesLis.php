<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Notes\Events\UpdateNotes;

class UpdateNotesLis
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
    public function handle(UpdateNotes $event)
    {
        if (module_is_active('ActivityLog')) {
            $note = $event->note;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Notes';
            $activity['sub_module']     = '--';
            $activity['description']    = __('Note Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $note->workspace_id;
            $activity['created_by']     = $note->created_by;
            $activity->save();
        }
    }
}
