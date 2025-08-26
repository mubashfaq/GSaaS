@permission('restaurant_customer edit')
    <div class="action-btn me-2">
        <a href="#" class="btn btn-sm d-inline-flex align-items-center bg-info"
         data-url="{{ route('restaurant-customer.edit', \Crypt::encrypt($customer->id)) }}"
             data-bs-toggle="tooltip" data-ajax-popup="true"
            data-title="{{ __('Edit Customer') }}" title="{{ __('Edit') }}"><span class="text-white"><i class="ti ti-pencil"></i></a>
    </div>
@endpermission
@permission('restaurant_customer delete')
    <div class="action-btn">
        {{ Form::open(['route' => ['restaurant-customer.destroy', $customer->id], 'class' => 'm-0']) }}
        @method('DELETE')
        <a href="#" class="btn btn-sm d-inline-flex align-items-center bs-pass-para show_confirm bg-danger" data-bs-toggle="tooltip"
            title="" data-bs-original-title="Delete" aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
            data-confirm-yes="delete-form-{{ $customer->id }}">
            <span class="text-white"><i class="ti ti-trash text-white text-white"></i>
        </a>
        {{ Form::close() }}
    </div>
@endpermission
