<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\SideMenuBuilder\Events\UpdateSideMenuBuilder;

class UpdateSideMenuBuilderLis
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
    public function handle(UpdateSideMenuBuilder $event)
    {
        if (module_is_active('ActivityLog')) {
            $sidemenubuilder = $event->sidemenubuilder;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Side Menu Builder';
            $activity['sub_module']     = '--';
            $activity['description']    = __('Side Menu Builder Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $sidemenubuilder->workspace;
            $activity['created_by']     = $sidemenubuilder->created_by;
            $activity->save();
        }
    }
}
