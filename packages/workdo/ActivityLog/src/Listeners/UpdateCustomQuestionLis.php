<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Recruitment\Events\UpdateCustomQuestion;

class UpdateCustomQuestionLis
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
    public function handle(UpdateCustomQuestion $event)
    {
        if (module_is_active('ActivityLog')) {
            $customQuestion = $event->customQuestion;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Recruitment';
            $activity['sub_module']     = 'Custom Question';
            $activity['description']    = __('Custom Question Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $customQuestion->workspace;
            $activity['created_by']     = $customQuestion->created_by;
            $activity->save();
        }
    }
}
