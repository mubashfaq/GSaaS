<div class="action-btn me-2">
    <a data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Click to copy link') }}"
        class="mx-3 btn btn-sm align-items-center cp_link bg-primary" data-link="{{ route('form.view', $form->code) }}"
        data-toggle="tooltip" data-original-title="{{ __('Click to copy link') }}"><i
            class="ti ti-file text-white"></i></a>
</div>

<div class="action-btn me-2">
    <a href="{{ route('form_builder.show', $form->id) }}" data-bs-toggle="tooltip" data-bs-placement="top"
        title="{{ __('Edit/View Form field') }}" class="btn btn-icon btn-sm bg-warning" data-toggle="tooltip"
        data-original-title="{{ __('Edit/View Form field') }}"><i class="ti ti-table text-white"></i></a>
</div>

<div class="action-btn me-2">
    <a href="{{ route('form.response', $form->id) }}" data-bs-toggle="tooltip" data-bs-placement="top"
        title="{{ __('View Response') }}" class="btn btn-icon btn-sm bg-warning" data-toggle="tooltip"
        data-original-title="{{ __('View Response') }}"><i class="ti ti-eye text-white"></i></a>
</div>

<div class="action-btn me-2">
    <a class="btn btn-icon btn-sm edit-icon bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Convert To') }}"
        data-url="{{ route('form.field.bind', $form->id) }}" data-ajax-popup="true" data-title="{{ __('Convert To') }}" data-toggle="tooltip" data-original-title="{{ __('Convert To') }}"><i
            class="ti ti-exchange text-white"></i></a>
</div>

<div class="action-btn me-2">
    <a data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit Form') }}"
        data-url="{{ URL::to('form_builder/' . $form->id . '/edit') }}" data-ajax-popup="true"
        data-title="{{ __('Edit Form') }}" class="btn btn-icon btn-sm bg-info"><i class="ti ti-pencil text-white"></i></a>
</div>
<div class="action-btn">
    {!! Form::open(['method' => 'DELETE', 'route' => ['form_builder.destroy', $form->id]]) !!}
    <a href="#!" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Delete Form') }}"
        class="mx-3 btn btn-sm align-items-center show_confirm bg-danger" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}">
        <span class="text-white"> <i class="ti ti-trash"></i></span></a>
        {!! Form::close() !!}
</div>
