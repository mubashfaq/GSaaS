<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Spreadsheet\Events\UpdateSpreadsheet;

class UpdateSpreadsheetLis
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
    public function handle(UpdateSpreadsheet $event)
    {
        if (module_is_active('ActivityLog')) {
            $spreadsheets = $event->spreadsheets;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Spreadsheet';
            $activity['sub_module']     = '--';
            $activity['description']    = __('Folder Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $spreadsheets->workspace;
            $activity['created_by']     = $spreadsheets->created_by;
            $activity->save();
        }
    }
}
