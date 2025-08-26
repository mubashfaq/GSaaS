<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\FixEquipment\Events\UpdatePreDefinedKit;

class UpdatePreDefinedKitLis
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
    public function handle(UpdatePreDefinedKit $event)
    {
        if (module_is_active('ActivityLog')) {
            $kit = $event->kit;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Fix Equipment';
            $activity['sub_module']     = 'Pre Defined Kit';
            $activity['description']    = __('Pre Defined Kit Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $kit->workspace;
            $activity['created_by']     = $kit->created_by;
            $activity->save();
        }
    }
}
