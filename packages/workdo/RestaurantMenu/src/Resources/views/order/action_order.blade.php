@permission('restaurant_order show')
    <div class="action-btn me-2">
        <a href="{{ route('restaurant-order.show', $order->id) }}"
            title="{{ __('view') }}"
            data-bs-toggle="tooltip" data-bs-original-title="{{ __('View') }}"
            class="mx-3 btn btn-sm align-items-center bg-warning">
            <i class="ti ti-eye text-white"></i>
        </a>
    </div>
@endpermission
