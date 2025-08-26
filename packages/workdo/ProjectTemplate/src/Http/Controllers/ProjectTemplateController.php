<?php

namespace Workdo\ProjectTemplate\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\ProjectTemplate\DataTables\ProjectTemplateDataTable;
use Workdo\Taskly\Entities\BugComment;
use Workdo\Taskly\Entities\BugFile;
use Workdo\Taskly\Entities\BugReport;
use Workdo\Taskly\Entities\ClientProject;
use Workdo\Taskly\Entities\Comment;
use Workdo\Taskly\Entities\Milestone;
use Workdo\Taskly\Entities\Project;
use Workdo\Taskly\Entities\ProjectFile;
use Workdo\Taskly\Entities\SubTask;
use Workdo\Taskly\Entities\Task;
use Workdo\Taskly\Entities\TaskFile;
use Workdo\Taskly\Entities\UserProject;

class ProjectTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('project template manage')) {
            $projects = Project::where('type', 'template')->where('projects.workspace', '=', getActiveWorkSpace())->get();
            return view('project-template::project-template.index', compact('projects'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        if (!empty($request['project_id'])) {
            if (Auth::user()->isAbleTo('project template create')) {
                $projectId = $request['project_id'];
                $type = $request['type'];
                return view('project-template::project-template.create', compact('projectId', 'type'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Something went wrong.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $id = $request->project_id;
        if (!empty($id)) {
            if (Auth::user()->isAbleTo('project template create')) {
                $project = Project::find($id);
                if ($project) {
                    $duplicate = new Project();
                    $duplicate['name'] = !empty($request->name) ? $request->name : $project->name;
                    $duplicate['status'] = $project->status;
                    $duplicate['image'] = $project->image;
                    $duplicate['description'] = $project->description;
                    $duplicate['start_date'] = date('Y-m-d');
                    $duplicate['end_date'] = date('Y-m-d');
                    $duplicate['is_active'] = $project->is_active;
                    $duplicate['type'] = $request->type;
                    $duplicate['currency'] = $project->currency;
                    $duplicate['project_progress'] = $project->project_progress;
                    $duplicate['progress'] = $project->progress;
                    $duplicate['task_progress'] = $project->task_progress;
                    $duplicate['tags'] = $project->tags;
                    $duplicate['estimated_hrs'] = $project->estimated_hrs;
                    $duplicate['workspace'] = getActiveWorkSpace();
                    $duplicate['created_by'] = creatorId();
                    $duplicate->save();


                    $users = UserProject::where('project_id', $project->id)->get();
                    foreach ($users as $user) {
                        $users = new UserProject();
                        $users['user_id'] = $user->user_id;
                        $users['project_id'] = $duplicate->id;
                        $users->save();
                    }

                    $tasks = Task::where('project_id', $project->id)->get();
                    foreach ($tasks as $task) {
                        $project_task = new Task();
                        $project_task['title'] = $task->title;
                        $project_task['priority'] = $task->priority;
                        $project_task['project_id'] = $duplicate->id;
                        $project_task['description'] = $task->description;
                        $project_task['start_date'] = $task->start_date;
                        $project_task['due_date'] = $task->due_date;
                        $project_task['milestone_id'] = $task->milestone_id;
                        $project_task['status'] = $task->status;
                        $project_task['assign_to'] = $task->assign_to;
                        $project_task['workspace'] = getActiveWorkSpace();
                        $project_task->save();

                        if ($request->type == 'project') {

                            $sub_tasks = SubTask::where('task_id', $task->id)->get();
                            foreach ($sub_tasks as $sub_task) {
                                $subtask = new SubTask();
                                $subtask['name'] = $sub_task->name;
                                $subtask['due_date'] = $sub_task->due_date;
                                $subtask['task_id'] = $project_task->id;
                                $subtask['user_type'] = $sub_task->user_type;
                                $subtask['created_by'] = $sub_task->created_by;
                                $subtask['status'] = $sub_task->status;
                                $subtask->save();
                            }

                            $task_comments = Comment::where('task_id', $task->id)->get();
                            foreach ($task_comments as $task_comment) {
                                $comment = new Comment();
                                $comment['comment'] = $task_comment->comment;
                                $comment['created_by'] = $task_comment->created_by;
                                $comment['task_id'] = $project_task->id;
                                $comment['user_type'] = $task_comment->user_type;
                                $comment->save();
                            }

                            $task_files = TaskFile::where('task_id', $task->id)->get();
                            foreach ($task_files as $task_file) {
                                $file = new TaskFile();
                                $file['file'] = $task_file->file;
                                $file['name'] = $task_file->name;
                                $file['extension'] = $task_file->extension;
                                $file['file_size'] = $task_file->file_size;
                                $file['created_by'] = $task_file->created_by;
                                $file['task_id'] = $project_task->id;
                                $file['user_type'] = $task_file->user_type;
                                $file->save();
                            }
                        }
                    }

                    $bugs = BugReport::where('project_id', $project->id)->get();
                    foreach ($bugs as $bug) {
                        $project_bug = new BugReport();
                        $project_bug['title'] = $bug->title;
                        $project_bug['priority'] = $bug->priority;
                        $project_bug['description'] = $bug->description;
                        $project_bug['assign_to'] = $bug->assign_to;
                        $project_bug['project_id'] = $duplicate->id;
                        $project_bug['status'] = $bug->status;
                        $project_bug['order'] = $bug->order;
                        $project_bug->save();

                        if ($request->type == 'project') {

                            $bug_comments = BugComment::where('bug_id', $bug->id)->get();
                            foreach ($bug_comments as $bug_comment) {
                                $bugcomment = new BugComment();
                                $bugcomment['comment'] = $bug_comment->comment;
                                $bugcomment['created_by'] = $bug_comment->created_by;
                                $bugcomment['bug_id'] = $project_bug->id;
                                $bugcomment['user_type'] = $bug_comment->user_type;
                                $bugcomment->save();
                            }

                            $bug_files = BugFile::where('bug_id', $bug->id)->get();
                            foreach ($bug_files as $bug_file) {
                                $bugfile = new BugFile();
                                $bugfile['file'] = $bug_file->file;
                                $bugfile['name'] = $bug_file->name;
                                $bugfile['extension'] = $bug_file->extension;
                                $bugfile['file_size'] = $bug_file->file_size;
                                $bugfile['created_by'] = $bug_file->created_by;
                                $bugfile['bug_id'] = $project_bug->id;
                                $bugfile['user_type'] = $bug_file->user_type;
                                $bugfile->save();
                            }
                        }
                    }
                    $milestones = Milestone::where('project_id', $project->id)->get();
                    foreach ($milestones as $milestone) {
                        $post = new Milestone();
                        $post['project_id'] = $duplicate->id;
                        $post['title'] = $milestone->title;
                        $post['status'] = $milestone->status;
                        $post['cost'] = $milestone->cost;
                        $post['summary'] = $milestone->summary;
                        $post['progress'] = $milestone->progress;
                        $post['start_date'] = $milestone->start_date;
                        $post['end_date'] = $milestone->end_date;
                        $post->save();
                    }

                    $project_files = ProjectFile::where('project_id', $project->id)->get();
                    foreach ($project_files as $project_file) {
                        $name = base_path('uploads/projects/' . $project_file->file_name);
                        if (file_exists($name)) {
                            $file_name = base_path('uploads/projects/' . time() . $project_file->file_name);
                            \File::copy($name, $file_name);
                            chmod($file_name, 0777);
                        }
                        if (file_exists($file_name)) {

                            $ProjectFile = new ProjectFile();
                            $ProjectFile['project_id'] = $duplicate->id;
                            $ProjectFile['file_name'] = $file_name;
                            $ProjectFile['file_path'] = $project_file->file_path;
                            $ProjectFile->save();
                        }

                    }
                    if ($request->type == 'template') {

                        return redirect()->route('project-template.index')->with('success', __('The project template has been created successfully!'));
                    } else {
                        return redirect()->route('projects.index')->with('success', __('The project has been created successfully!'));
                    }
                } else {
                    return redirect()->back()->with('error', 'The project is not found');
                }
            } else {
                return redirect()->back()->with('error', 'Permission denied');
            }
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('project-template::edit');
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
    public function destroy($projectID)
    {
        if (Auth::user()->isAbleTo('project template delete')) {
            $objUser = Auth::user();
            $project = Project::find($projectID);
            if ($project) {
                if ($project->created_by == $objUser->id) {
                    Task::where('project_id', '=', $project->id)->delete();
                    BugReport::where('project_id', '=', $project->id)->delete();
                    UserProject::where('project_id', '=', $projectID)->delete();

                    $ProjectFiles = ProjectFile::where('project_id', '=', $projectID)->get();
                    foreach ($ProjectFiles as $ProjectFile) {

                        delete_file($ProjectFile->file_path);
                        $ProjectFile->delete();
                    }

                    Milestone::where('project_id', '=', $projectID)->delete();
                    $project->delete();
                    return redirect()->back()->with('success', __('The project template has been deleted.'));
                } else {
                    return redirect()->route('projects.index')->with('error', __("You can't delete this project."));
                }
            } else {
                return redirect()->back()->with('error', 'The project template is not found');
            }

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function List(ProjectTemplateDataTable $dataTable)
    {
        if (Auth::user()->isAbleTo('project template manage')) {
            return $dataTable->render('project-template::project-template.list');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
