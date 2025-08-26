<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\DoubleEntry\Events\UpdateJournalAccount;

class UpdateJournalAccountLis
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
    public function handle(UpdateJournalAccount $event)
    {
        if (module_is_active('ActivityLog')) {
            $journalEntry = $event->journalEntry;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'DoubleEntry';
            $activity['sub_module']     = 'Journal Account';
            $activity['description']    = __('Journal Entry Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $journalEntry->workspace;
            $activity['created_by']     = $journalEntry->created_by;
            $activity->save();
        }
    }
}
