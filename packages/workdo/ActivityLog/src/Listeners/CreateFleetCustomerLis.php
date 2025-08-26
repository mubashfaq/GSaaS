<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Fleet\Events\CreateFleetCustomer;

class CreateFleetCustomerLis
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
    public function handle(CreateFleetCustomer $event)
    {
        if (module_is_active('ActivityLog')) {
            $customer = $event->customers;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Fleet';
            $activity['sub_module']     = 'Customer';
            $activity['description']    = __('New Customer Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $customer->workspace;
            $activity['created_by']     = $customer->created_by;
            $activity->save();
        }
    }
}
