<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\DairyCattleManagement\Events\CreateDailyMilkSheet;

class CreateDailyMilkSheetLis
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
    public function handle(CreateDailyMilkSheet $event)
    {
        if (module_is_active('ActivityLog')) {
            $dailymilksheet = $event->dailymilksheet;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Dairy Cattle';
            $activity['sub_module']     = 'Daily Milk Sheet';
            $activity['description']    = __('New Daily Milk Sheet created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $dailymilksheet['workspace'];
            $activity['created_by']     = $dailymilksheet['created_by'];
            $activity->save();
        }
    }
}
