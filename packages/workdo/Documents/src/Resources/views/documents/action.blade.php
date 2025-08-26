<td class="Action">
    <span>
        @permission('documents create')
            @if (\Auth::user()->type == 'company')
                <div class="action-btn me-2">
                    <a data-size="lg" title="{{ __('Duplicate') }}" data-url="{{ route('documents.copy', $document->id) }}"
                        data-ajax-popup="true" data-title="{{ __('Duplicate') }}"
                        class="bg-info btn btn-sm align-items-center" data-bs-toggle="tooltip"
                        data-bs-placement="top">
                        <i class="ti ti-copy text-white"></i></a>
                </div>
            @endif
        @endpermission
        @permission('documents show')
            <div class="action-btn me-2">
                <a href="{{ route('documents.show', $document->id) }}"
                    class="bg-warning btn btn-sm align-items-center" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="{{ __('View') }}"><i class="ti ti-eye text-white"></i></a>
            </div>
        @endpermission
        @permission('documents edit')
            <div class="action-btn me-2">
                <a data-size="lg" title="{{ __('Edit') }}" data-url="{{ route('documents.edit', $document->id) }}"
                    data-ajax-popup="true" data-title="{{ __('Edit Document') }}"
                    class="bg-info btn btn-sm align-items-center" data-bs-toggle="tooltip"
                    data-bs-placement="top">
                    <i class="ti ti-pencil text-white"></i></a>
            </div>
        @endpermission
        @permission('documents delete')
            <div class="action-btn">
                {!! Form::open(['method' => 'DELETE', 'route' => ['documents.destroy', $document->id]]) !!}
                <a href="#!" title="{{ __('Delete') }}"
                    class="bg-danger btn btn-sm d-inline-flex align-items-center show_confirm" data-bs-toggle="tooltip"
                    data-bs-placement="top">
                    <span class="text-white"><i class="ti ti-trash"></i></span>
                </a>
                {!! Form::close() !!}
            </div>
        @endpermission
    </span>
</td>
