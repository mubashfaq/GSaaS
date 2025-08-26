<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\RentalManagement\Events\CreateRental;

class CreateRentalLis
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
    public function handle(CreateRental $event)
    {
        if (module_is_active('ActivityLog')) {
            $rental = $event->rental;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Rental';
            $activity['sub_module']     = '--';
            $activity['description']    = __('New Rental Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $rental->workspace;
            $activity['created_by']     = $rental->created_by;
            $activity->save();
        }
    }
}
