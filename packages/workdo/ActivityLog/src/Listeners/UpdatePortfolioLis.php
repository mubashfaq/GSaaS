<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Portfolio\Events\UpdatePortfolio;

class UpdatePortfolioLis
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
    public function handle(UpdatePortfolio $event)
    {
        if (module_is_active('ActivityLog')) {
            $portfolio = $event->portfolio;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Portfolio';
            $activity['sub_module']     = 'Portfolio';
            $activity['description']    = __('Portfolio Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $portfolio->workspace;
            $activity['created_by']     = $portfolio->created_by;
            $activity->save();
        }
    }
}
