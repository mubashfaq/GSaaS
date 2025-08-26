<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\AgricultureManagement\Events\UpdateAgricultureCrop;

class UpdateAgricultureCropLis
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
    public function handle(UpdateAgricultureCrop $event)
    {
        if (module_is_active('ActivityLog')) {
            $agriculturecrop = $event->agriculturecrop;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Agriculture';
            $activity['sub_module']     = 'Agriculture Crop';
            $activity['description']    = __('Agriculture Crop Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $agriculturecrop->workspace;
            $activity['created_by']     = $agriculturecrop->created_by;
            $activity->save();
        }
    }
}
