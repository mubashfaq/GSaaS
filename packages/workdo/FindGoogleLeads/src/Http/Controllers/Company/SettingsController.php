<?php
// This file use for handle company setting page

namespace Workdo\FindGoogleLeads\Http\Controllers\Company;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\Lead\Entities\Pipeline;
use Workdo\Lead\Entities\LeadStage;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($settings)
    {
        $creatorId          = creatorId();
        $getActiveWorkSpace = getActiveWorkSpace();

        $pipelines = Pipeline::where('created_by' ,$creatorId)->where('workspace_id' ,$getActiveWorkSpace)->pluck('name','id');
        $pipeline_id = Pipeline::where('created_by' ,$creatorId)->where('workspace_id' ,$getActiveWorkSpace)->first();
        $lead_stages = LeadStage::where('pipeline_id',$pipeline_id->id)->where('created_by' ,$creatorId)->where('workspace_id' ,$getActiveWorkSpace)->pluck('name','id');
        return view('findgoogleleads::company.settings.index',compact('settings' ,'pipelines' ,'lead_stages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
}
