<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\RentalManagement\Events\DuplicateRental;

class DuplicateRentalLis
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
    public function handle(DuplicateRental $event)
    {
        if (module_is_active('ActivityLog')) {
            $duplicateRental = $event->duplicateRental;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Rental';
            $activity['sub_module']     = '--';
            $activity['description']    = __('Duplicate Rental Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $duplicateRental->workspace;
            $activity['created_by']     = $duplicateRental->created_by;
            $activity->save();
        }
    }
}
