@if ($purchaseOrder->is_convert_purchase == 0)
    @permission('purchase order convert to Purchase')
        <div class="action-btn me-2">
            <a data-size="md" data-url="{{ route('purchase.order.popup', \Crypt::encrypt($purchaseOrder->id)) }}"
                data-ajax-popup="true" data-bs-toggle="tooltip" title="{{ __('Convert To Purchase') }}"
                class="btn btn-sm align-items-center bg-success">
                <i class="ti ti-exchange text-white"></i>
            </a>
        </div>
    @endpermission
@elseif($purchaseOrder->is_convert_purchase == 1)
    @permission('purchase show')
        <div class="action-btn me-2">
            <a href="{{ route('purchases.show', \Crypt::encrypt($purchaseOrder->converted_purchase_id)) }}"
                class="btn btn-sm  align-items-center bg-success" data-bs-toggle="tooltip"
                title="{{ __('Already Convert To Purchase') }}">
                <i class="ti ti-eye text-white"></i>
            </a>
        </div>
    @endpermission
@endif
@permission('purchase order show')
    <div class="action-btn me-2">
        <a class="btn btn-sm align-items-center bg-warning" href="{{ route('purchase-order.show', $purchaseOrder->id) }}"
            data-bs-toggle="tooltip" data-bs-original-title="{{ __('Detail') }}">
            <i class="ti ti-eye text-white"></i>
        </a>
    </div>
@endpermission
@permission('purchase order edit')
    <div class="action-btn me-2">
        <a class="btn btn-sm align-items-center bg-info" href="{{ route('purchase-order.edit', $purchaseOrder->id) }}"
            data-bs-toggle="tooltip" title="{{ __('Edit') }}" data-original-title="{{ __('Edit') }}">
            <i class="ti ti-pencil text-white"></i>
        </a>
    </div>
@endpermission
@permission('purchase order delete')
    <div class="action-btn">
        {{ Form::open(['route' => ['purchase-order.destroy', $purchaseOrder->id], 'class' => 'm-0']) }}
        @method('DELETE')
        <a class="btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger" data-bs-toggle="tooltip" title=""
            data-bs-original-title="Delete" aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
            data-confirm-yes="delete-form-{{ $purchaseOrder->id }}"><i class="ti ti-trash text-white text-white"></i></a>
        {{ Form::close() }}
    </div>
@endpermission
