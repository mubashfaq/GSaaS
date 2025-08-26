<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Hrm\Entities\Branch;
use Workdo\Recruitment\Events\CreateJob;

class CreateJobLis
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
    public function handle(CreateJob $event)
    {
        if (module_is_active('ActivityLog')) {
            $job = $event->job;
            $branchs = Branch::find($job->branch);
            $branch = $branchs->name ?? '';
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Recruitment';
            $activity['sub_module']     = 'Jobs';
            $activity['description']    = __('New Job ') . $job->title . __(' created in branch ') . $branch . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $job->workspace;
            $activity['created_by']     = $job->created_by;
            $activity->save();
        }
    }
}
