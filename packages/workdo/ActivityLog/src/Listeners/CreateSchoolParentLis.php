<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\School\Events\CreateSchoolParent;

class CreateSchoolParentLis
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
    public function handle(CreateSchoolParent $event)
    {
        if (module_is_active('ActivityLog')) {
            $parent = $event->parent;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'School & Institute';
            $activity['sub_module']     = 'Parent';
            $activity['description']    = __('New Parent Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $parent->workspace;
            $activity['created_by']     = $parent->created_by;
            $activity->save();
        }
    }
}
