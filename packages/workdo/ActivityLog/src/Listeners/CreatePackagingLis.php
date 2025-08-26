<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\BeverageManagement\Events\CreatePackaging;

class CreatePackagingLis
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
    public function handle(CreatePackaging $event)
    {
        if (module_is_active('ActivityLog')) {
            $packaging = $event->packaging;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Beverage';
            $activity['sub_module']     = 'Packaging';
            $activity['description']    = __('New Packaging Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $packaging->workspace;
            $activity['created_by']     = $packaging->created_by;
            $activity->save();
        }
    }
}
