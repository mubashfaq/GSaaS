@if ($saleOrder->is_convert_invoice == 0)
    @permission('sale order convert to invoice')
        <div class="action-btn me-2">
            <a data-size="md" data-url="{{ route('sale.order.popup', \Crypt::encrypt($saleOrder->id)) }}"
                data-ajax-popup="true" data-bs-toggle="tooltip" title="{{ __('Convert To Invoice') }}"
                class="btn btn-sm align-items-center bg-success">
                <i class="ti ti-exchange text-white"></i>
            </a>
        </div>
    @endpermission
@elseif($saleOrder->is_convert_invoice == 1)
    @permission('invoice show')
        <div class="action-btn me-2">
            <a href="{{ route('invoice.show', \Crypt::encrypt($saleOrder->converted_invoice_id)) }}"
                class="btn btn-sm  align-items-center bg-success" data-bs-toggle="tooltip"
                title="{{ __('Already Convert To Invoice') }}">
                <i class="ti ti-eye text-white"></i>
            </a>
        </div>
    @endpermission
@endif
@permission('sale order show')
    <div class="action-btn me-2">
        <a class="btn btn-sm  align-items-center bg-warning" href="{{ route('sale-order.show', $saleOrder->id) }}"
            data-bs-toggle="tooltip" data-bs-original-title="{{ __('Detail') }}">
            <i class="ti ti-eye text-white"></i>
        </a>
    </div>
@endpermission
@permission('sale order edit')
    <div class="action-btn me-2">
        <a class="btn btn-sm align-items-center bg-info" href="{{ route('sale-order.edit', $saleOrder->id) }}"
            data-bs-toggle="tooltip" title="{{ __('Edit') }}" data-original-title="{{ __('Edit') }}">
            <i class="ti ti-pencil text-white"></i>
        </a>
    </div>
@endpermission
@permission('sale order delete')
    <div class="action-btn">
        {{ Form::open(['route' => ['sale-order.destroy', $saleOrder->id], 'class' => 'm-0']) }}
        @method('DELETE')
        <a class="btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger" data-bs-toggle="tooltip" title=""
            data-bs-original-title="Delete" aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
            data-confirm-yes="delete-form-{{ $saleOrder->id }}"><i class="ti ti-trash text-white text-white"></i></a>
        {{ Form::close() }}
    </div>
@endpermission
