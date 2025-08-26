<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\TVStudio\Events\CreateTvStudioCoupon;

class CreateTvStudioCouponLis
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
    public function handle(CreateTvStudioCoupon $event)
    {
        if (module_is_active('ActivityLog')) {
            $tv_coupon = $event->tv_coupon;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Movie & TV Studio';
            $activity['sub_module']     = 'Coupon';
            $activity['description']    = __('New Coupon created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $tv_coupon['workspace_id'];
            $activity['created_by']     = $tv_coupon['created_by'];
            $activity->save();
        }
    }
}
