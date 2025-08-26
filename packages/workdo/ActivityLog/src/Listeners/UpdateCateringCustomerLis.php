<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CateringManagement\Events\UpdateCateringCustomer;

class UpdateCateringCustomerLis
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
    public function handle(UpdateCateringCustomer $event)
    {
        if (module_is_active('ActivityLog')) {
            $CateringCustomer = $event->CateringCustomer;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Catering';
            $activity['sub_module']     = 'Catering Customer';
            $activity['description']    = __('Catering Customer Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $CateringCustomer->workspace_id;
            $activity['created_by']     = $CateringCustomer->created_by;
            $activity->save();
        }
    }
}
