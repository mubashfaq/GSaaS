<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CateringManagement\Events\CreateMenuSelection;

class CreateMenuSelectionLis
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
    public function handle(CreateMenuSelection $event)
    {
        if (module_is_active('ActivityLog')) {
            $menusection = $event->menusection;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Catering';
            $activity['sub_module']     = 'Menu Selections';
            $activity['description']    = __('New Menu Selection Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $menusection->workspace_id;
            $activity['created_by']     = $menusection->created_by;
            $activity->save();
        }
    }
}
