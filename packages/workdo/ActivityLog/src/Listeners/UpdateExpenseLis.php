<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\LegalCaseManagement\Events\UpdateExpense;

class UpdateExpenseLis
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
    public function handle(UpdateExpense $event)
    {
        if (module_is_active('ActivityLog')) {
            $expense = $event->expense;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Legal Case';
            $activity['sub_module']     = 'Expense';
            $activity['description']    = __('Expense Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $expense->workspace;
            $activity['created_by']     = $expense->created_by;
            $activity->save();
        }
    }
}
