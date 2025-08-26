<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Recruitment\Events\CreateJobCandidate;

class CreateJobCandidateLis
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
    public function handle(CreateJobCandidate $event)
    {
        if (module_is_active('ActivityLog')) {
            $job_candidate = $event->job_candidate;
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Recruitment';
            $activity['sub_module']     = 'Job Candidate';
            $activity['description']    = __('New Job Candidate created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $job_candidate->workspace;
            $activity['created_by']     = $job_candidate->created_by;
            $activity->save();
        }
    }
}
