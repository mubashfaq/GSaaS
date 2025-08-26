@permission('offers edit')
<div class="action-btn me-2">
    <a data-url="{{ route('restaurant-offers.edit', \Crypt::encrypt($offer->id)) }}"
        class="btn btn-sm align-items-center bg-info "
        data-bs-toggle="tooltip" data-ajax-popup="true"
        data-title="{{ __('Edit Offer') }}"
        title="{{ __('Edit') }}"><i class="ti ti-pencil text-white"></i></a>
</div>
@endpermission
@permission('offers delete')
<div class="action-btn">
    {{ Form::open(['route' => ['restaurant-offers.destroy', $offer->id], 'class' => 'm-0']) }}
    @method('DELETE')
    <a href="#"
        class="btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
        data-bs-toggle="tooltip" title=""
        data-bs-original-title="Delete" aria-label="Delete"
        data-confirm="{{ __('Are You Sure?') }}"
        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
        data-confirm-yes="delete-form-{{ $offer->id }}">
        <i class="ti ti-trash text-white text-white"></i>
    </a>
    {{ Form::close() }}
</div>
@endpermission