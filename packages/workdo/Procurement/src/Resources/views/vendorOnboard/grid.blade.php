@extends('layouts.main')
@section('page-title')
    {{ __('Manage Vendor On-Boarding') }}
@endsection

@section('page-breadcrumb')
    {{ __('Vendor On-Boarding') }}
@endsection
@section('page-action')
    <div class="d-flex">
        <a href="{{ route('vendor.on.board') }}" class="btn btn-sm btn-primary me-2"
            data-bs-toggle="tooltip"title="{{ __('List View') }}">
            <i class="ti ti-list text-white"></i>
        </a>
        @permission('vendoronboard create')
            <a  data-url="{{ route('vendor.on.board.create', 0) }}" data-ajax-popup="true"
                data-title="{{ __('Create New Vendor On-Boarding') }}" data-bs-toggle="tooltip" title=""
                class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/letter.avatar.js') }}"></script>
@endpush
@section('filter')
@endsection
@section('content')
    <div class="row">

        @foreach ($vendorOnBoards as $rfx)
            <div class="col-md-3 d-flex">
                <div class="card w-100">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex align-items-center">
                            @if ($rfx->status == 'pending')
                                <span
                                    class="badge bg-warning p-2 px-3">{{ Workdo\Procurement\Entities\VendorOnBoard::$status[$rfx->status] }}</span>
                            @elseif($rfx->status == 'cancel')
                                <span
                                    class="badge bg-danger p-2 px-3">{{ Workdo\Procurement\Entities\VendorOnBoard::$status[$rfx->status] }}</span>
                            @else
                                <span
                                    class="badge bg-success p-2 px-3">{{ Workdo\Procurement\Entities\VendorOnBoard::$status[$rfx->status] }}</span>
                            @endif
                        </div>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @if (Laratrust::hasPermission('vendoronboard convert') || Laratrust::hasPermission('vendoronboard edit') || Laratrust::hasPermission('vendoronboard delete'))
                                        @permission('vendoronboard edit')
                                            <a  data-url="{{ route('vendor.on.board.edit', $rfx->id) }}" data-ajax-popup="true" data-size="md"
                                                class="dropdown-item" data-bs-whatever="{{ __('Edit Vendor On Board') }}"
                                                data-bs-toggle="tooltip" data-title="{{ __('Edit Vendor On Board') }}"><i
                                                    class="ti ti-pencil"></i>
                                                {{ __('Edit') }}</a>
                                        @endpermission
                                        @permission('vendoronboard convert')
                                        @if ($rfx->status == 'confirm' && $rfx->convert_to_vendor == 0 && module_is_active('Account'))
                                        <a data-url="{{ route('vendor.on.board.converts', $rfx->id) }}"
                                            class="dropdown-item" data-ajax-popup="true"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-size="lg"
                                             data-title="{{ __('Convert to Vendor') }}">
                                            <i class="ti ti-arrows-right-left "></i>{{ __(' Convert to Vendor') }}
                                        </a>  
                                            @endif
                                        @endpermission
                                        @permission('vendoronboard delete')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['vendor.on.board.delete', $rfx->id]]) !!}
                                            <a href="#!" class="dropdown-item  show_confirm" data-bs-toggle="tooltip">
                                                <i class="ti ti-trash"></i>{{ __(' Delete') }}
                                            </a>
                                            {!! Form::close() !!}
                                        @endpermission
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 justify-content-between">
                            <div class="col-12">
                                <div class="text-center client-box">
                                    <div class="avatar-parent-child mb-3">
                                        <img alt="user-image" class="img-fluid rounded-circle"
                                            avatar="{{ !empty($rfx->applications) ? $rfx->applications->name : '-' }}">
                                    </div>
                                    <div class="h6 mt-2 mb-1 ">
                                        <a class=" text-primary"
                                            >{{ !empty($rfx->applications) ? $rfx->applications->name : '-' }}</a>
                                    </div>
                                    <div class="mb-1"><a 
                                            class="text-sm small text-muted">{{ !empty($rfx->applications) ? (!empty($rfx->applications->jobs) ? (!empty($rfx->applications->jobs) ? (!empty($rfx->applications->jobs->branches) ? $rfx->applications->jobs->branches->name : $rfx->applications->jobs->location) : '-') : '-') : '-' }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-3">
            <a  data-url="{{ route('vendor.on.board.create', 0) }}" class="btn-addnew-project rounded border-2 border border-primary" data-ajax-popup="true" data-title="{{ __('Create New Vendor On-Boarding') }}"style="padding: 62px 10px;">
                <div class="badge bg-primary proj-add-icon">
                    <i class="ti ti-plus"></i>
                </div>
                <h6 class="mt-4 mb-2">{{ __('New Vendor On-Boarding') }}</h6>
                <p class="text-muted text-center">{{ __('Click here to add New Vendor On-Boarding') }}</p>
            </a>
        </div>
    </div>
@endsection
