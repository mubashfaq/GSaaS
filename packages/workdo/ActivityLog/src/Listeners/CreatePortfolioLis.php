<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Portfolio\Events\CreatePortfolio;

class CreatePortfolioLis
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
    public function handle(CreatePortfolio $event)
    {
        if (module_is_active('ActivityLog')) {
            $portfolio = $event->portfolio;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Portfolio';
            $activity['sub_module']     = 'Portfolio';
            $activity['description']    = __('New Portfolio Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $portfolio->workspace;
            $activity['created_by']     = $portfolio->created_by;
            $activity->save();
        }
    }
}
