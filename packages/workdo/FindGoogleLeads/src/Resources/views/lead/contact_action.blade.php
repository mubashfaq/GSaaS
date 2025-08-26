@if ($leadContant->is_sync != 1)
    @permission('findgooglelead contact convert')
        <div class="action-btn me-2">
            <a class="bg-success btn btn-sm align-items-center convert-to-lead" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ __('Convert to lead') }}" data-ajax-popup="true" data-size="lg"
                data-title="{{ __('Convert to lead') }}" data-id="{{ $leadContant->id }}"
                data-url="{{ route('leads.create') }}"><i class="ti ti-exchange text-white"></i></a>
            </a>
        </div>
    @endpermission
@endif
@permission('findgooglelead contact delete')
    <div class="action-btn">
        {!! Form::open(['method' => 'DELETE', 'route' => ['findgooglelead.contact.destroy', $leadContant->id]]) !!}
        <a href="#!" class="bg-danger btn btn-sm d-inline-flex align-items-center show_confirm" data-bs-toggle="tooltip"
            data-bs-placement="top" title="{{ __('Delete') }}">
            <span class="text-white"> <i class="ti ti-trash"></i></span></a>
            {!! Form::close() !!}
    </div>
@endpermission
