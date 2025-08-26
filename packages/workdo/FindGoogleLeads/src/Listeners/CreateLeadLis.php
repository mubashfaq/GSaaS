<?php

namespace Workdo\FindGoogleLeads\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\Lead\Events\CreateLead;
use Workdo\FindGoogleLeads\Entities\GoogleLeadContact;
use Workdo\Lead\Entities\Lead;

class CreateLeadLis
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
    public function handle(CreateLead $event)
    {
        if(module_is_active('FindGoogleLeads'))
        {
            if(company_setting('finsgoogleleads_lead_stages') && company_setting('finsgoogleleads_pipelines'))
            {
                if (isset($event->request->google_contact_lead_id)) {

                    $contact = GoogleLeadContact::where('id', $event->request->google_contact_lead_id)->first();
                    $contact->lead_id = 1;
                    $contact->is_sync = 1;
                    $contact->save();
                }
                $lead = Lead::where('id', $event->lead->id)->first();
                if (isset($event->request->website) && !empty($event->request->website) && $event->request->website != '-') {
        
                    $lead->website = $event->request->website;
                }
                $lead->stage_id = company_setting('finsgoogleleads_lead_stages');
                $lead->pipeline_id = company_setting('finsgoogleleads_pipelines');
                $lead->save();
            }
            
        }
       
    }
}
