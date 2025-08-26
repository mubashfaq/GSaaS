<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\VideoHub\Events\CreateVideoHubComment;

class CreateVideoHubCommentLis
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
    public function handle(CreateVideoHubComment $event)
    {
        if (module_is_active('ActivityLog')) {
            $comments = $event->comments;
            $video = $event->video;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Video Hub';
            $activity['sub_module']     = '--';
            $activity['description']    = __('New Comment Add in video ') . $video->title . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $comments->workspace;
            $activity['created_by']     = $comments->comment_by;
            $activity->save();
        }
    }
}
