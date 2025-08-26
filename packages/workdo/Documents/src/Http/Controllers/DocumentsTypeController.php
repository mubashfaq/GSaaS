<?php

namespace Workdo\Documents\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Workdo\Documents\Entities\Document;
use Workdo\Documents\Entities\DocumentType;
use Workdo\Documents\Events\CreateDocumentsType;
use Workdo\Documents\Events\DeleteDocumentsType;
use Workdo\Documents\Events\UpdateDocumentsType;

class DocumentsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('documents type manage')) {
            $documentTypes = DocumentType::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->get();
            return view('documents::document_type.index', compact('documentTypes'));
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
        if (Auth::user()->isAbleTo('documents type manage')) {
            return view('documents::document_type.create');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (Auth::user()->isAbleTo('documents type create')) {
            $validator = Validator::make($request->all(), ['name' => 'required|max:50',]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->getMessageBag()->first());
            }
            $documentType               = new DocumentType();
            $documentType->name         = $request->name;
            $documentType->workspace_id = getActiveWorkSpace();
            $documentType->created_by   = creatorId();
            $documentType->save();
            event(new CreateDocumentsType($request, $documentType));
            return redirect()->back()->with('success', __('The document type has been created successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return self::index();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $documentType = DocumentType::find($id);
        if (Auth::user()->isAbleTo('documents type edit')) {
            if ($documentType->created_by == creatorId()) {
                return view('documents::document_type.edit', compact('documentType'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->isAbleTo('documents type edit')) {
            $validator = Validator::make($request->all(), ['name' => 'required|max:50',]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->getMessageBag()->first());
            }

            $documentType               = DocumentType::find($id);
            $documentType->name         = $request->name;
            $documentType->workspace_id = getActiveWorkSpace();
            $documentType->created_by   = creatorId();
            $documentType->save();

            event(new UpdateDocumentsType($request, $documentType));
            return redirect()->back()->with('success', __('The document type has been created successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (Auth::user()->isAbleTo('documents type delete')) {
            $documentType               = DocumentType::find($id);
            if ($documentType->created_by == creatorId()) {
                $contract = Document::where('type', $documentType->id)->where('created_by', $documentType->created_by)->count();
                if ($contract == 0) {
                    event(new DeleteDocumentsType($documentType));
                    $documentType->delete();
                    return redirect()->back()->with('success', __('The document type has been deleted!'));
                } else {
                    return redirect()->back()->with('error', __('This document type is Used on Document.'));
                }
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
