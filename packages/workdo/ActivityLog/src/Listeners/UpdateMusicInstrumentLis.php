<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MusicInstitute\Events\UpdateMusicInstrument;

class UpdateMusicInstrumentLis
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
    public function handle(UpdateMusicInstrument $event)
    {
        if (module_is_active('ActivityLog')) {
            $instrument = $event->instrument;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Music Institute';
            $activity['sub_module']     = 'Instrument';
            $activity['description']    = __('Instrument Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $instrument->workspace;
            $activity['created_by']     = $instrument->created_by;
            $activity->save();
        }
    }
}
