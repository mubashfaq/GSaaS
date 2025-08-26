<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Hrm\Entities\Branch;
use Workdo\Recruitment\Events\UpdateJob;

class UpdateJobLis
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
    public function handle(UpdateJob $event)
    {
        if (module_is_active('ActivityLog')) {
            $job = $event->request;
            $branchs = Branch::find($job->branch);
            $branch = $branchs->name ?? '';

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Recruitment';
            $activity['sub_module']     = 'Jobs';
            $activity['description']    = __('Job ') . $job->title . __(' Updated in branch ') . $branch . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $job->workspace;
            $activity['created_by']     = $job->created_by;
            $activity->save();
        }
    }
}
