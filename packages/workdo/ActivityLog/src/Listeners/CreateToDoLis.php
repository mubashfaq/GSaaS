<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\ToDo\Events\CreateToDo;

class CreateToDoLis
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
    public function handle(CreateToDo $event)
    {
        if (module_is_active('ActivityLog')) {
            $toDo = $event->toDo;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'To Do';
            $activity['sub_module']     = '--';
            $activity['description']    =  __('New To Do created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $toDo['workspace_id'];
            $activity['created_by']     = $toDo['created_by'];
            $activity->save();
        }
    }
}
