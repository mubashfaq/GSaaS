<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\InnovationCenter\Events\UpdateCreativity;

class UpdateCreativityLis
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
    public function handle(UpdateCreativity $event)
    {
        if (module_is_active('ActivityLog')) {
            $Creativitys = $event->Creativitys;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Innovation Center';
            $activity['sub_module']     = 'New Creativity';
            $activity['description']    = __('Creativity Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $Creativitys->workspace;
            $activity['created_by']     = $Creativitys->created_by;
            $activity->save();
        }
    }
}
