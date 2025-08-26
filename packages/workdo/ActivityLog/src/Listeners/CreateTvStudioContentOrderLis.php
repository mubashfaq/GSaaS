<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\TVStudio\Events\CreateTvStudioContentOrder;

class CreateTvStudioContentOrderLis
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
    public function handle(CreateTvStudioContentOrder $event)
    {
        if (module_is_active('ActivityLog')) {
            $contentOrderSummary = $event->contentOrderSummary;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Movie & TV Studio';
            $activity['sub_module']     = 'Orders';
            $activity['description']    = __('New Order ') . $contentOrderSummary->order_id . __(' created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $contentOrderSummary['workspace'];
            $activity['created_by']     = $contentOrderSummary['created_by'];
            $activity->save();
        }
    }
}
