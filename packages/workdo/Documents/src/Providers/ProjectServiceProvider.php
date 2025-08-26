<?php

namespace Workdo\Documents\Providers;

use Illuminate\Support\ServiceProvider;
use Workdo\Documents\Entities\Document;

class ProjectServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['taskly::projects.*'], function ($view) {
            try {
                $project_id =  \Request::segment(2);
                if (!is_numeric($project_id)) {
                    $projectId = \Request::segment(4);
                    $project_id = \Illuminate\Support\Facades\Crypt::decrypt($projectId);
                }
                $documents = Document::with(['type', 'user', 'project', 'attachments', 'comments', 'notes'])->where('project_id', $project_id)->where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->get();
                $view->getFactory()->startPush('DocumentSection', view('documents::push.project_document_section', compact('documents', 'project_id')));
                $view->getFactory()->startPush('DocumentShareSection', view('documents::push.project_share_section', compact('documents', 'project_id')));
            } catch (\Throwable $th) {
            }
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
