
@permission('consignment shipping edit')
    <div class="action-btn me-2">
        <a class="btn btn-sm align-items-center bg-info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Edit')}}" data-ajax-popup="true" data-size="lg" data-title="{{__('Edit Shipping')}}" data-url="{{route('consignment-shipping.edit' ,$shipping->id)}}"><i class="ti ti-pencil text-white"></i></a>
    </div>
@endpermission
@permission('consignment shipping delete')
    <div class="action-btn">
        {{ Form::open(['route' => ['consignment-shipping.destroy', $shipping->id], 'class' => 'm-0']) }}
        @method('DELETE')
        <a class="btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger" data-bs-toggle="tooltip" title=""
            data-bs-original-title="Delete" aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
            data-confirm-yes="delete-form-{{ $shipping->id }}"><i class="ti ti-trash text-white text-white"></i></a>
        {{ Form::close() }}
    </div>
@endpermission
