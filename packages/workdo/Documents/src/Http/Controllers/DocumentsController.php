<?php

namespace Workdo\Documents\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Workdo\Documents\DataTables\DocumentsDatatable;
use Workdo\Documents\Entities\Document;
use Workdo\Documents\Entities\DocumentAttechment;
use Workdo\Documents\Entities\DocumentComments;
use Workdo\Documents\Entities\DocumentNote;
use Workdo\Documents\Entities\DocumentType;
use Workdo\Documents\Events\CopyDocuments;
use Workdo\Documents\Events\CreateDocuments;
use Workdo\Documents\Events\DeleteDocuments;
use Workdo\Documents\Events\StatusChangeDocument;
use Workdo\Documents\Events\UpdateDocument;
use Workdo\Taskly\Entities\Project;
use Carbon\Carbon;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(DocumentsDatatable $dataTable)
    {
        if (Auth::user()->isAbleTo('documents manage')) {
            return $dataTable->render('documents::documents.index');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        return view('documents::documents.index');
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($pro_id = null)
    {
        if (Auth::user()->isAbleTo('documents create')) {
            if (module_is_active('Taskly')) {
                $project_id     = isset($pro_id) && $pro_id != null ? $pro_id : null;
                if (Auth::user()->hasRole('client')) {
                    $projects = Project::select('projects.*')->join('client_projects', 'projects.id', '=', 'client_projects.project_id')->projectonly()->where('client_projects.client_id', '=', Auth::user()->id)->where('projects.workspace', '=', getActiveWorkSpace())->get()->pluck('name', 'id');
                } else {
                    $projects = Project::select('projects.*')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->projectonly()->where('user_projects.user_id', '=', Auth::user()->id)->where('projects.workspace', '=', getActiveWorkSpace())->get()->pluck('name', 'id');
                }
            } else {
                $project_id = null;
                $projects = null;
            }
            $user           = User::where('workspace_id', getActiveWorkSpace())->where('created_by', creatorId())->get()->pluck('name', 'id');
            $documentType   = DocumentType::where('created_by', creatorId())->Orwhere('workspace_id', getActiveWorkSpace())->get()->pluck('name', 'id');
           
            return view('documents::documents.create', compact('documentType', 'user', 'project_id', 'projects'));
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (Auth::user()->isAbleTo('documents create')) {
            $document  = self::storeData($request);
            event(new CreateDocuments($request, $document));
            return redirect()->back()->with('success', __('The documents has been created successfully'));
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
        if (Auth::user()->isAbleTo('documents show')) {
            $relation = array_merge(['Type', 'user', 'attachments', 'comments', 'notes'], module_is_active('Taskly') ? ['Project'] : []);
            $document  = Document::with($relation)->where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->find($id);
            if ($document != null) {
                return view('documents::documents.show', compact('document'));
            } else {
                return redirect()->back()->with('error', __('Document Note Found.'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id, $pro_id = null)
    {
        if (Auth::user()->isAbleTo('documents edit')) {
            $relation       = array_merge(['Type', 'user'], module_is_active('Taskly') ? ['Project'] : []);
            $documents      = Document::with($relation)->where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->find($id);
            $user           = User::where('workspace_id', getActiveWorkSpace())->where('created_by', creatorId())->get()->pluck('name', 'id');
            $documentType   = DocumentType::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->get()->pluck('name', 'id');
            if (module_is_active('Taskly')) {
                $project_id = isset($pro_id) && $pro_id != null ? $pro_id : null;
                if (Auth::user()->hasRole('client')) {
                    $projects = Project::select('projects.*')->join('client_projects', 'projects.id', '=', 'client_projects.project_id')->projectonly()->where('client_projects.client_id', '=', Auth::user()->id)->where('projects.workspace', '=', getActiveWorkSpace())->get()->pluck('name', 'id');
                } else {
                    $projects = Project::select('projects.*')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->projectonly()->where('user_projects.user_id', '=', Auth::user()->id)->where('projects.workspace', '=', getActiveWorkSpace())->get()->pluck('name', 'id');
                }
            } else {
                $projects = null;
                $project_id = null;
            }
            if (module_is_active('CustomField')) {
                $customFields =  \Workdo\CustomField\Entities\CustomField::where('workspace_id', getActiveWorkSpace())->where('module', 'Documents')->where('sub_module', 'Documents')->get();
            } else {
                $customFields = null;
            }

            return view('documents::documents.edit', compact('documents', 'documentType', 'user', 'customFields', 'projects', 'project_id'));
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
        if (Auth::user()->isAbleTo('documents create')) {
            $document  = self::storeData($request, $id);
            event(new UpdateDocument($request, $document));
            return redirect()->back()->with('success', __('The documents are updated successfully'));
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
        if (Auth::user()->isAbleTo('documents delete')) {
            $document = Document::find($id);
            $document->delete();
            event(new DeleteDocuments($document));
            return redirect()->back()->with('success', __('The documents has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    // Document Copy
    public function copyDoc($id)
    {
        $relation = array_merge(['Type', 'user'], module_is_active('Taskly') ? ['Project'] : []);
        $documents      = Document::with($relation)->where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->find($id);
        $user           = User::where('workspace_id', getActiveWorkSpace())->where('created_by', creatorId())->get()->pluck('name', 'id');
        $documentType   = DocumentType::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->get()->pluck('name', 'id');
        if (module_is_active('Taskly')) {
            $project_id = isset($pro_id) && $pro_id != null ? $pro_id : null;
            if (Auth::user()->hasRole('client')) {
                $projects = Project::select('projects.*')->join('client_projects', 'projects.id', '=', 'client_projects.project_id')->projectonly()->where('client_projects.client_id', '=', Auth::user()->id)->where('projects.workspace', '=', getActiveWorkSpace())->get()->pluck('name', 'id');
            } else {
                $projects = Project::select('projects.*')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->projectonly()->where('user_projects.user_id', '=', Auth::user()->id)->where('projects.workspace', '=', getActiveWorkSpace())->get()->pluck('name', 'id');
            }
        } else {
            $projects = null;
            $project_id = null;
        }
        return view('documents::documents.duplicate', compact('documents', 'documentType', 'project_id', 'projects', 'user'));
    }

    public function copyDocStore(Request $request, $id)
    {
        if (Auth::user()->isAbleTo('documents create')) {
            $validator = Validator::make($request->all(), ['subject' => 'required|max:255', 'type' => 'required']);
            $duplicate = [];
            $document                     = Document::with(['Type', 'user', 'Project', 'Attachments', 'Comments', 'Notes'])->where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->find($id);
            $copy_document                = $document->replicate();
            $copy_document->subject       = $request->subject ?? '';
            $copy_document->type          = $request->type ?? 0;
            $copy_document->description   = $request->description ?? 0;
            $copy_document->document_id   = Document::getId('document');
            $copy_document->created_at    = Carbon::now();
            $copy_document->save();
            $duplicate['document']         = (object) $copy_document;
            // Comment
            $comments = DocumentComments::where('document_id', $document->id)->get();
            if ($comments->isNotEmpty()) {
                foreach ($comments as $key => $comment) {
                    $copy_comment = $comment->replicate();
                    $copy_comment->document_id = $copy_document->id;
                    $copy_comment->created_at = Carbon::now();
                    $copy_comment->save();
                    $duplicate['comment'][$key] = (object) $copy_comment;
                }
            }
            // Notes
            $notes = DocumentNote::where('document_id', $document->id)->get();
            if ($notes->isNotEmpty()) {
                foreach ($notes as $key => $note) {
                    $copy_note = $note->replicate();
                    $copy_note->document_id = $copy_document->id;
                    $copy_note->created_at = Carbon::now();
                    $copy_note->save();
                    $duplicate['notes'][$key] = (object) $copy_note;
                }
            }
            event(new CopyDocuments($request, $document));
            return redirect()->back()->with('success', __('The document has been created successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function descriptionStore($id, Request $request)
    {
        if (Auth::user()->type == 'company') {
            $validator = Validator::make($request->all(), ['description' => 'required']);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->getMessageBag()->first());
            }
            $document = Document::find($id);
            $document->description = $request->description ?? '';
            $document->additional_description = $request->additional_description ?? '';
            $document->save();

            return redirect()->back()->with('success', __('The description has been saved successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission denied'));
        }
    }

    public function fileUpload($id, Request $request)
    {
        $document = Document::find($id);
        if ($document->created_by == creatorId() && $document->workspace_id == getActiveWorkSpace()) {
            $request->validate(['file' => 'required']);
            $files  = 'DOC' . date('YmdHis');
            $path   = upload_file($request, 'file', $files, 'documents_file');
            if ($path['flag'] == 1) {
                $file = $path['url'];
            } else {
                return redirect()->back()->with('error', __($path['msg']));
            }
            $file = DocumentAttechment::create([
                'document_id'   => $request->document_id,
                'user_id'       => Auth::user()->id,
                'workspace_id'  => getActiveWorkSpace(),
                'files'         => $file,
            ]);
            $return               = [];
            $return['is_success'] = true;
            $return['download']   = route('documents.file.download', [$document->id, $file->id,]);
            $return['delete']     = route('documents.file.delete', [$document->id, $file->id,]);

            return response()->json([
                'is_success' => true,
                'success' => __('Status successfully updated!'),
            ], 200);
        } else {
            return response()->json([
                'is_success' => false,
                'error' => __('Permission Denied.'),
            ], 401);
        }
    }

    public function fileDownload($id, $file_id)
    {
        $document = Document::find($id);
        if ($document->created_by == creatorId() && $document->workspace_id == getActiveWorkSpace()) {
            $file = DocumentAttechment::find($file_id);
            if ($file) {
                $file_path = get_base_file($file->files);
                return \Response::download(
                    $file_path,
                    $file->files,
                    ['Content-Length: ' . get_size($file_path)]
                );
            } else {
                return redirect()->back()->with('error', __('File is not exist.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function fileDelete($id, $file_id)
    {
        $document = Document::find($id);
        $file = DocumentAttechment::find($file_id);
        if ($file) {
            $path = get_base_file($file->files);
            if (file_exists($path)) {
                \File::delete($path);
            }
            $file->delete();
            return redirect()->back()->with('success', __('Attechment successfully delete.'));
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('File is not exist.'),
                ],
                200
            );
        }
    }

    public function commentStore(Request $request, $id)
    {
        if (Auth::user()->isAbleTo('documents comment create')) {
            $validator = Validator::make($request->all(), ['comment' => 'required',]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->getMessageBag()->first());
            }
            $document              = new DocumentComments();
            $document->comment     = $request->comment;
            $document->document_id  = $id;
            $document->workspace_id = getActiveWorkSpace();
            $document->user_id     = Auth::user()->id;
            $document->save();

            return redirect()->back()->with('success', __('comments successfully created!') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''))->with('status', 'comments');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function commentDestroy($id)
    {
        if (Auth::user()->isAbleTo('documents comment delete')) {
            $document = DocumentComments::find($id);
            $document->delete();
            return redirect()->back()->with('success', __('The comment has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function noteStore($id, Request $request)
    {
        if (Auth::user()->isAbleTo('documents note create')) {
            $document              = Document::find($id);
            $notes                 = new DocumentNote();
            $notes->document_id     = $document->id;
            $notes->note           = $request->note;
            $notes->user_id        = Auth::user()->id;
            $notes['workspace_id'] = getActiveWorkSpace();
            $notes->created_by     = creatorId();
            $notes->save();
            return redirect()->back()->with('success', __('The note has been created successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission denied'));
        }
    }


    public function noteDestroy($id)
    {
        if (Auth::user()->isAbleTo('documents note delete')) {
            $document = DocumentNote::find($id);
            if ($document->created_by == creatorId() && $document->workspace_id == getActiveWorkSpace()) {
                $document->delete();
                return redirect()->back()->with('success', __('The note has been deleted'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied'));
        }
    }

    public function printDoc($id)
    {
       
        $relation       = array_merge(['Type', 'user'], module_is_active('Taskly') ? ['Project'] : []);
        $document       = Document::with($relation)->where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->find($id);
        $dark_logo      = get_file(sidebar_logo());
        $img            = (!empty($dark_logo) ? $dark_logo : get_file('uploads/logo/logo_dark.png'));
        $company_id     = $document->created_by;
        $workspace_id   = $document->workspace_id;
        return view('documents::documents.print', compact('document', 'img', 'company_id', 'workspace_id'));
    }

    public function pdfFromDoc($document_id)
    {
        $id             = \Illuminate\Support\Facades\Crypt::decrypt($document_id);
        $document       = Document::findOrFail($id);
        $document_type  = Document::where('id', $document->id)->first();
        $usr            = Auth::check() ? Auth::user() : User::where('id', $document->created_by)->first();
        $dark_logo      = get_file(sidebar_logo());
        $img            = (!empty($dark_logo) ? $dark_logo : get_file('uploads/logo/logo_dark.png'));
        $company_id     = $document->created_by;
        $workspace_id   = $document->workspace_id;
        return view('documents::documents.template', compact('document', 'usr', 'document_type', 'img', 'company_id', 'workspace_id'));
    }

    public function setting(Request $request)
    {
        $validator = Validator::make($request->all(), ['documents_prefix' => 'required',]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        } else {
            $document = [];
            $document['documents_prefix'] =  $request->documents_prefix ?? '#DOC';
            foreach ($document as $key => $value) {
                $data = ['key' => $key, 'workspace' => getActiveWorkSpace(), 'created_by' => creatorId(),];
                Setting::updateOrInsert($data, ['value' => $value]);
            }
            comapnySettingCacheForget();
            return redirect()->back()->with('success', __('The document setting has been created successfully'));
        }
    }

    public function DocStatus(Request $request, $id)
    {
        $document = Document::find($id);
        $document->status  = $request->status ?? 'pending';
        $document->save();
        event(new StatusChangeDocument($request, $document));
        return ['status' => 'true', 'message' =>  __('The status are updated successfully')];
    }

    public function storeData($request, $id = null)
    {
        if (Auth::user()->isAbleTo(['documents create', 'documents edit'])) {
            $validator = Validator::make($request->all(), ['subject' => 'required|max:255', 'type' => 'required', 'user_id' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('documents.index')->with('error', $validator->getMessageBag()->first());
            }
            if ($id != null) {
                $document            = Document::find($id);
            } else {
                $document               = new Document();
                $document->document_id  = Document::getId('document');
            }
            $document->subject      = $request->subject ?? '';
            $document->type         = $request->type ?? '';
            $document->user_id      = (Auth::user()->type == 'company') ? $request->user_id : Auth::user()->id;
            $document->notes        = $request->notes ?? '';
            $document->project_id   = $request->project_id ?? '';
            $document->workspace_id = getActiveWorkSpace();
            $document->created_by   = creatorId();
            $document->save();

            if (module_is_active('CustomField')) {
                \Workdo\CustomField\Entities\CustomField::saveData($document, $request->customField);
            }
            return $document;
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
