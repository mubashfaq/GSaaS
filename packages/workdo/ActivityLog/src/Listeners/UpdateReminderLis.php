<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Reminder\Events\UpdateReminder;

class UpdateReminderLis
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
    public function handle(UpdateReminder $event)
    {
        if (module_is_active('ActivityLog')) {
            $reminder = $event->reminder;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Reminder';
            $activity['sub_module']     = '--';
            $activity['description']    =  __('Reminder updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $reminder['workspace'];
            $activity['created_by']     = $reminder['created_by'];
            $activity->save();
        }
    }
}
