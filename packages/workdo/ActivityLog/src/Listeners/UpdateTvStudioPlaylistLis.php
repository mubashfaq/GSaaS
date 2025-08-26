<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\TVStudio\Events\UpdateTvStudioPlaylist;

class UpdateTvStudioPlaylistLis
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
    public function handle(UpdateTvStudioPlaylist $event)
    {
        if (module_is_active('ActivityLog')) {
            $playlist = $event->playlist;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Movie & TV Studio';
            $activity['sub_module']     = 'Playlist';
            $activity['description']    = __('Playlist updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $playlist['workspace_id'];
            $activity['created_by']     = $playlist['created_by'];
            $activity->save();
        }
    }
}
