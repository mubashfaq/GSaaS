<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\LegalCaseManagement\Events\CreateCaseInitiator;

class CreateCaseInitiatorLis
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
    public function handle(CreateCaseInitiator $event)
    {
        if (module_is_active('ActivityLog')) {
            $caseInitiator = $event->caseInitiator;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Legal Case';
            $activity['sub_module']     = 'Case Initiator';
            $activity['description']    = __('New Case Initiator Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $caseInitiator->workspace_id;
            $activity['created_by']     = $caseInitiator->created_by;
            $activity->save();
        }
    }
}
