<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\ChildcareManagement\Events\UpdateInquiry;

class UpdateInquiryLis
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
    public function handle(UpdateInquiry $event)
    {
        if (module_is_active('ActivityLog')) {
            $inquiry = $event->inquiry;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Childcare';
            $activity['sub_module']     = 'Inquiry';
            $activity['description']    = __('Inquiry Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $inquiry->workspace;
            $activity['created_by']     = $inquiry->created_by;
            $activity->save();
        }
    }
}
