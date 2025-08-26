@if ($business->status != 'locked')
    <div class="action-btn  me-2">
        {{ Form::open(['route' => ['business.duplicate', $business->id], 'class' => 'm-0']) }}
        @method('POST')
        <a class="btn btn-sm  align-items-center bs-pass-para show_confirm bg-dark" data-bs-toggle="tooltip" title=""
            data-bs-original-title="{{__('Business duplicate')}}" data-confirm="{{ __('You want to confirm this action') }}"
            data-text="{{ __('Press Yes to continue or No to go back.') }}"
            data-confirm-yes="duplicate-form-{{ $business->id }}"><i class="ti ti-copy text-white text-white"></i></a>
        {!! Form::close() !!}

    </div>
    <div class="action-btn   me-2">
        <a href="#" class="btn btn-sm d-inline-flex align-items-center bg-secondary"
            data-link="{{ route('get.vcard', ['slug' => $business->slug]) }}" data-bs-toggle="tooltip"
            data-bs-original-title="{{ __('Click to copy card link') }}" onclick="copyToClipboard(this)">
            <span class="text-white"> <i class="ti ti-link text-white"></i></span></a>
    </div>
    @permission('card appointment calendar')
        <div class="action-btn   me-2">
            <a href="{{ route('appointment.calendar', ['business' => $business->id]) }}"
                class="bg-primary btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Appointment Calendar') }}">
                <span class="text-white"> <i class="ti ti-calendar text-white"></i></span></a>
        </div>
    @endpermission
    @permission('card contact manage')
        <div class="action-btn  me-2">
            <a href="{{ route('business.contacts.show', $business->id) }}"
                class="bg-warning  btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Business Contacts') }}"> <span class="text-white"> <i
                        class="ti ti-phone text-white"></i></span></a>
        </div>
    @endpermission
    @permission('business edit')
        <div class="action-btn   me-2">
            <a href="{{ route('business.edit', $business->id) }}" class="bg-info btn btn-sm d-inline-flex align-items-center"
                data-bs-toggle="tooltip" data-bs-original-title="{{ __('Business Edit') }}"> <span class="text-white"> <i
                        class="ti ti-pencil text-white"></i></span></a>
        </div>
    @endpermission
    <div class="action-btn  me-2">
        {{ Form::open(['route' => ['business.status', $business->id], 'class' => 'm-0']) }}
        @method('POST')
        <a class="bg-dark btn btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip" title=""
            data-bs-original-title="{{__('Business lock')}}" aria-label="Business lock" data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can business lock. Do you want to continue?') }}"
            data-confirm-yes="delete-form-{{ $business->id }}"><i class="ti ti-lock text-white text-white"></i></a>
        {!! Form::close() !!}
    </div>
    @permission('business delete')
        <div class="action-btn  me-2">
            {{ Form::open(['route' => ['business.destroy', $business->id], 'class' => 'm-0']) }}
            @method('DELETE')
            <a class="bg-danger btn btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip" title=""
                data-bs-original-title="{{__('Delete')}}" aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                data-confirm-yes="delete-form-{{ $business->id }}"><i class="ti ti-trash text-white text-white"></i></a>
            {!! Form::close() !!}
        </div>
    @endpermission
@else
    <div class="action-btn ">
        {{ Form::open(['route' => ['business.status', $business->id], 'class' => 'm-0']) }}
        @method('POST')
        <a class="bg-dark btn btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip" title=""
            data-bs-original-title="{{__('Business Unlock')}}" aria-label="Business Unlock"
            data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can business unlock. Do you want to continue?') }}"
            data-confirm-yes="delete-form-{{ $business->id }}">
            <i class="ti ti-lock-open"></i></a>

        {!! Form::close() !!}
    </div>
@endif
