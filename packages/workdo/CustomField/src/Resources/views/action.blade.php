@permission('customfield edit')
    <div class="action-btn me-2">
        <a href="#" class="btn btn-sm bg-info align-items-center" data-url="{{ route('custom-field.edit', $customField->id) }}"
            data-ajax-popup="true" data-title="{{ __('Edit Custom Field') }}" data-bs-toggle="tooltip"
            title="{{ __('Edit') }}" data-original-title="{{ __('Edit') }}">
            <i class="ti ti-pencil text-white"></i>
        </a>
    </div>
@endpermission
@permission('customfield delete')
    <div class="action-btn">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['custom-field.destroy', $customField->id],
            'id' => 'delete-form-' . $customField->id,
        ]) !!}
        <a href="#" class="btn btn-sm bg-danger align-items-center show_confirm" data-bs-toggle="tooltip"
            title="{{ __('Delete') }}" data-original-title="{{ __('Delete') }}" data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
            data-confirm-yes="document.getElementById('delete-form-{{ $customField->id }}').submit();">
            <i class="ti ti-trash text-white"></i>
        </a>
        {!! Form::close() !!}
    </div>
@endpermission
