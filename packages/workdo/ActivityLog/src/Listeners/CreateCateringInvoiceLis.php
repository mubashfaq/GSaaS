<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CateringManagement\Events\CreateCateringInvoice;

class CreateCateringInvoiceLis
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
    public function handle(CreateCateringInvoice $event)
    {
        if (module_is_active('ActivityLog')) {
            $cateringinvoice = $event->cateringinvoice;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Catering';
            $activity['sub_module']     = 'Catering Invoice';
            $activity['description']    = __('New Catering Invoice Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $cateringinvoice->workspace_id;
            $activity['created_by']     = $cateringinvoice->created_by;
            $activity->save();
        }
    }
}
