@permission('card contact add note')
    <div class="action-btn  me-2">
        <a href="#" class="bg-success mx-3 btn btn-sm d-inline-flex align-items-center cp_link" data-toggle="modal"
            data-target="#commonModal" data-ajax-popup="true" data-size="lg"
            data-url="{{ route('contact.add-note', $contactsDetails->id) }}" data-title="{{ __('Add Note & Change Status') }}"
            data-bs-toggle="tooltip" data-bs-original-title="{{ __('Add Note & Change Status') }}">
            <span class="text-white"><i class="ti ti-note"></i></span></a>
    </div>
@endpermission
@permission('card contact delete')
    <div class="action-btn  me-2">
        {{ Form::open(['route' => ['contacts.destroy', $contactsDetails->id], 'class' => 'm-0']) }}
        <a class="bg-danger mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip" title=""
            data-bs-original-title="Delete" aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
            data-confirm-yes="delete-form-{{ $contactsDetails->id }}"><i class="ti ti-trash text-white text-white"></i></a>
        {!! Form::close() !!}
    </div>
@endpermission
