<?php

namespace Workdo\ActivityLog\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Workdo\ActivityLog\DataTables\ActivityLogDataTable;
use Workdo\ActivityLog\Entities\AllActivityLog;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ActivityLogDataTable $dataTable)
    {
        if(module_is_active('ActivityLog'))
        {
            if (Auth::user()->isAbleTo('activitylog manage')) {
                $creatorId = creatorId();
                $getActiveWorkSpace = getActiveWorkSpace();

                $modules = AllActivityLog::select('module')
                            ->where('created_by', '=', $creatorId)
                            ->where('workspace', '=', $getActiveWorkSpace)
                            ->groupBy('module')
                            ->get()
                            ->pluck('module')
                            ->toArray();
                        
                $staffs = User::where('created_by', '=', $creatorId)->where('workspace_id', '=', $getActiveWorkSpace)->orWhere('id',$creatorId)->get();

                return $dataTable->render('activity-log::index', compact('modules' , 'staffs'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('activity-log::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return redirect()->route('activitylog.index')->with('error', __('Permission Denied.'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('activity-log::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (Auth::user()->isAbleTo('activitylog delete')) {
            $activity = AllActivityLog::find($id);
            $activity->delete();

            return redirect()->back()->with('success', __('The activity has been deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
