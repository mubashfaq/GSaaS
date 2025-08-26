<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\VCard\Events\UpdateContact;

class VcardUpdateContactLis
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
    public function handle(UpdateContact $event)
    {
        if (module_is_active('ActivityLog')) {
            $contact = $event->request;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'vCard';
            $activity['sub_module']     = 'Contact';
            $activity['description']    = __('Contact Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $contact->workspace;
            $activity['created_by']     = $contact->created_by;
            $activity->save();
        }
    }
}
