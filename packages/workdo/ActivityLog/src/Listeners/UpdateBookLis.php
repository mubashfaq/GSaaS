<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Internalknowledge\Events\UpdateBook;

class UpdateBookLis
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
    public function handle(UpdateBook $event)
    {
        if (module_is_active('ActivityLog')) {
            $book = $event->book;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Internalknowledge';
            $activity['sub_module']     = 'Book';
            $activity['description']    = __('Book Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $book->workspace;
            $activity['created_by']     = $book->created_by;
            $activity->save();
        }
    }
}
