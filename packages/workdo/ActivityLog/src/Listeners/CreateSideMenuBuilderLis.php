<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\SideMenuBuilder\Events\CreateSideMenuBuilder;

class CreateSideMenuBuilderLis
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
    public function handle(CreateSideMenuBuilder $event)
    {
        if (module_is_active('ActivityLog')) {
            $menu_builder = $event->menu_builder;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Side Menu Builder';
            $activity['sub_module']     = '--';
            $activity['description']    = __('New Side Menu Builder Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $menu_builder->workspace;
            $activity['created_by']     = $menu_builder->created_by;
            $activity->save();
        }
    }
}
