<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\PropertyManagement\Events\UpdateDocumentType;

class UpdateDocumentTypeLis
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
    public function handle(UpdateDocumentType $event)
    {
        if (module_is_active('ActivityLog')) {
            $document_type = $event->document_type;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Property Manage';
            $activity['sub_module']     = 'Document Type';
            $activity['description']    = __('Document Type Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $document_type->workspace;
            $activity['created_by']     = $document_type->created_by;
            $activity->save();
        }
    }
}
