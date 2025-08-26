<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\GymManagement\Entities\GymMember;
use Workdo\GymManagement\Events\UpdateGymMember;

class UpdateGymMemberLis
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
    public function handle(UpdateGymMember $event)
    {
        if (module_is_active('ActivityLog')) {
            $gymmember = $event->gymmember;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'GYM Management';
            $activity['sub_module']     = 'Member';
            $activity['description']    = __('Member ') . GymMember::gymmemberNumberFormat($gymmember->member_id) . __(' Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $gymmember->workspace;
            $activity['created_by']     = $gymmember->created_by;
            $activity->save();
        }
    }
}
