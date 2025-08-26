<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MusicInstitute\Entities\MusicClass;
use Workdo\MusicInstitute\Events\UpdateMusicClass;

class UpdateMusicClassLis
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
    public function handle(UpdateMusicClass $event)
    {
        if (module_is_active('ActivityLog')) {
            $class = $event->class;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Music Institute';
            $activity['sub_module']     = 'Class';
            $activity['description']    = __('Class ') . MusicClass::classNumberFormat($class->music_class_id) . __(' Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = Auth::user()->workspace_id;
            $activity['created_by']     = Auth::user()->id;
            $activity->save();
        }
    }
}
