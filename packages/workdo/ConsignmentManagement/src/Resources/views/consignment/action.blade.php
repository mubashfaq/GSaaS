@permission('consignment show')
    <div class="action-btn me-2">
        <a class="btn btn-sm  align-items-center bg-warning" href="{{ route('consignment.show', $consignment->id) }}"
            data-bs-toggle="tooltip" data-bs-original-title="{{ __('Detail') }}">
            <i class="ti ti-eye text-white"></i>
        </a>
    </div>
@endpermission
@permission('consignment edit')
    <div class="action-btn me-2">
        <a class="btn btn-sm align-items-center bg-info " href="{{ route('consignment.edit', $consignment->id) }}"
            data-bs-toggle="tooltip" title="{{ __('Edit') }}" data-original-title="{{ __('Edit') }}">
            <i class="ti ti-pencil text-white"></i>
        </a>
    </div>
@endpermission
@permission('consignment delete')
    <div class="action-btn">
        {{ Form::open(['route' => ['consignment.destroy', $consignment->id], 'class' => 'm-0']) }}
        @method('DELETE')
        <a class="mx-3 btn btn-sm align-items-center bs-pass-para show_confirm bg-danger" data-bs-toggle="tooltip" title=""
            data-bs-original-title="Delete" aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
            data-confirm-yes="delete-form-{{ $consignment->id }}"><i class="ti ti-trash text-white text-white"></i></a>
        {{ Form::close() }}
    </div>
@endpermission
