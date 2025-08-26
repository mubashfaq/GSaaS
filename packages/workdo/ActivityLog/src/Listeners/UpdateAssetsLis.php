<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Assets\Events\UpdateAssets;

class UpdateAssetsLis
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
    public function handle(UpdateAssets $event)
    {
        if (module_is_active('ActivityLog')) {
            $asset = $event->asset;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Assets';
            $activity['sub_module']     = '--';
            $activity['description']    = __('Asset Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $asset->workspace_id;
            $activity['created_by']     = $asset->created_by;
            $activity->save();
        }
    }
}
