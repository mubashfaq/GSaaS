
@permission('findgooglelead show')
    <div class="action-btn  me-2">
        <a class="mx-3 btn btn-sm align-items-center bg-warning" href="{{ route('find-google-leads.show', $lead->id) }}"
            title="{{ __('Show Detail') }}" data-bs-toggle="tooltip">
            <i class="ti ti-eye text-white"></i>
        </a>
    </div>
@endpermission
@permission('findgooglelead delete')
    <div class="action-btn ">
        {!! Form::open(['method' => 'DELETE', 'route' => ['find-google-leads.destroy', $lead->id]]) !!}
        <a href="#!" class="bg-danger btn btn-sm d-inline-flex align-items-center show_confirm" data-bs-toggle="tooltip"
            data-bs-placement="top" title="{{ __('Delete') }}">
            <span class="text-white"> <i class="ti ti-trash"></i></span></a>
            {!! Form::close() !!}
    </div>
@endpermission
