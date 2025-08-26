<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\ChildcareManagement\Entities\Child;
use Workdo\ChildcareManagement\Events\CreateFee;

class CreateFeeLis
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
    public function handle(CreateFee $event)
    {
        if (module_is_active('ActivityLog')) {
            $childFee = $event->childFee;
            $child = Child::find($childFee->child_id);
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Childcare';
            $activity['sub_module']     = 'Fee';
            $activity['description']    = __('New Fee Created for child ') . $child->first_name . __(' ') . $child->last_name . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $childFee->workspace;
            $activity['created_by']     = $childFee->created_by;
            $activity->save();
        }
    }
}
