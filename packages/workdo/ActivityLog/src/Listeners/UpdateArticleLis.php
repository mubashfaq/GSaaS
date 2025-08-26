<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Internalknowledge\Events\UpdateArticle;

class UpdateArticleLis
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
    public function handle(UpdateArticle $event)
    {
        if (module_is_active('ActivityLog')) {
            $article = $event->article;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Internalknowledge';
            $activity['sub_module']     = 'Article';
            $activity['description']    = __('Article Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $article->workspace;
            $activity['created_by']     = $article->created_by;
            $activity->save();
        }
    }
}
