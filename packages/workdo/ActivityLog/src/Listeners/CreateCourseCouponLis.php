<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\LMS\Events\CreateCourseCoupon;

class CreateCourseCouponLis
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
    public function handle(CreateCourseCoupon $event)
    {
        if (module_is_active('ActivityLog')) {
            $coursecoupon = $event->coursecoupon;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'LMS';
            $activity['sub_module']     = 'Course Coupon';
            $activity['description']    = __('New Course Coupon Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $coursecoupon->workspace_id;
            $activity['created_by']     = $coursecoupon->created_by;
            $activity->save();
        }
    }
}
