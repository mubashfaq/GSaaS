<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\TVStudio\Events\CreateTvStudioCustomer;

class CreateTvStudioCustomerLis
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
    public function handle(CreateTvStudioCustomer $event)
    {
        if (module_is_active('ActivityLog')) {
            $customer = $event->customer;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Movie & TV Studio';
            $activity['sub_module']     = 'Customer';
            $activity['description']    = __('New Customer created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $customer['store_id'];
            $activity['created_by']     = Auth::user()->id;
            $activity->save();
        }
    }
}
