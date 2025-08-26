@permission('project create')
    <div class="action-btn me-2">
        <a data-size="md"
            data-url="{{ route('project-template.create', ['project_id' => $project->id, 'type' => 'project']) }}"
            class="btn bg-primary btn-sm  align-items-center text-white " data-ajax-popup="true" data-bs-toggle="tooltip"
            data-title="{{ __('Convert to project') }}" title="{{ __('Convert to project') }}"><i
                class="ti ti-replace"></i></a>
    </div>
@endpermission
@permission('project template show')
    <div class="action-btn me-2">
        <a href="{{ route('projects.show', $project->id) }}" data-bs-toggle="tooltip" title="{{ __('Details') }}"
            data-title="{{ __('Project Details') }}" class="mx-3 btn btn-sm  align-items-center text-white bg-warning">
            <i class="ti ti-eye"></i>
        </a>
    </div>
@endpermission
@permission('project template delete')
    <div class="action-btn">
        {!! Form::open(['method' => 'DELETE', 'route' => ['projects.destroy', $project->id]]) !!}
        <a href="#!" class="bg-danger btn btn-sm   align-items-center text-white show_confirm" data-bs-toggle="tooltip"
            title='{{__('Delete')}}'>
            <i class="ti ti-trash"></i>
        </a>
        {!! Form::close() !!}
    </div>
@endpermission
