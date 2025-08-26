<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\FixEquipment\Events\UpdateLicence;

class UpdateLicenceLis
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
    public function handle(UpdateLicence $event)
    {
        if (module_is_active('ActivityLog')) {
            $license = $event->license;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Fix Equipment';
            $activity['sub_module']     = 'Licenses';
            $activity['description']    = __('License Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $license->workspace;
            $activity['created_by']     = $license->created_by;
            $activity->save();
        }
    }
}
