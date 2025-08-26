@permission('dining_table show')
    <div class="action-btn me-2">
        <a data-url="{{ route('restaurant-dining-table.show', $diningTable->id) }}"
            {{-- btn btn-sm d-inline-flex align-items-center bg-warning --}}
            class="btn btn-sm align-items-center bg-warning" data-bs-toggle="tooltip" data-ajax-popup="true"
            title="{{ __('QRcode') }}" data-title="{{ __('View Dining Table') }}">
            <i class="ti ti-qrcode  text-white"></i>
        </a>
    </div>
@endpermission
@permission('dining_table edit')
    <div class="action-btn me-2">
        <a data-url="{{ route('restaurant-dining-table.edit', \Crypt::encrypt($diningTable->id)) }}"
            class="btn btn-sm align-items-center bg-info "
            data-bs-toggle="tooltip" data-ajax-popup="true"
            data-title="{{ __('Edit Dining Table') }}"
            title="{{ __('Edit') }}"><i class="ti ti-pencil text-white"></i></a>
    </div>
@endpermission
@permission('dining_table delete')
    <div class="action-btn">
        {{ Form::open(['route' => ['restaurant-dining-table.destroy', $diningTable->id], 'class' => 'm-0']) }}
        @method('DELETE')
        <a href="#"
            class="btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
            data-bs-toggle="tooltip" title=""
            data-bs-original-title="Delete" aria-label="Delete"
            data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
            data-confirm-yes="delete-form-{{ $diningTable->id }}">
            <i class="ti ti-trash text-white text-white"></i>
        </a>
        {{ Form::close() }}
    </div>
@endpermission
