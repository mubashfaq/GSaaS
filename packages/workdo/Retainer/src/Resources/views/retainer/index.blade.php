@extends('layouts.main')
@section('page-title')
    {{ __('Retainers') }}
@endsection
@section('page-breadcrumb')
    {{ __('Retainers') }}
@endsection
@push('css')
    @include('layouts.includes.datatable-css')
@endpush
@section('page-action')
    <div class="d-flex">
        @stack('addButtonHook')
        @if (module_is_active('ProductService'))
            <a href="{{ route('category.index') }}"data-size="md" class="btn btn-sm btn-primary me-2"
                data-bs-toggle="tooltip"data-title="{{ __('Setup') }}" title="{{ __('Setup') }}"><i
                    class="ti ti-settings"></i></a>
        @endif

        @if ((module_is_active('ProductService') && module_is_active('Account')) || module_is_active('Taskly'))
            @permission('retainer manage')
                <a href="{{ route('retainer.grid') }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip"
                    title="{{ __('Grid View') }}">
                    <i class="ti ti-layout-grid text-white"></i>
                </a>
            @endpermission

            @permission('retainer create')
                <a href="{{ route('retainer.create', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                    title="{{ __('Create') }}">
                    <i class="ti ti-plus"></i>
                </a>
            @endpermission
        @endif
    </div>
@endsection

@push('script-page')
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class=" multi-collapse mt-2" id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">

                        <div class="row d-flex align-items-center justify-content-end">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    {{ Form::label('issue_date', __('Date'), ['class' => 'form-label']) }}
                                    {{ Form::text('issue_date', isset($_GET['issue_date']) ? $_GET['issue_date'] : null, ['class' => 'form-control flatpickr-to-input', 'placeholder' => 'Select Date']) }}
                                </div>
                            </div>
                            @if (!\Auth::user()->type != 'Client')
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                    <div class="btn-box">
                                        {{ Form::label('customer', __('Customer'), ['class' => 'form-label']) }}
                                        {{ Form::select('customer', $customer, isset($_GET['customer']) ? $_GET['customer'] : '', ['class' => 'form-control', 'placeholder' => 'Select Customer']) }}
                                    </div>
                                </div>
                            @endif
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                                    {{ Form::select('status', ['' => 'Select Status'] + $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control select']) }}
                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">
                                <a class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" title="{{ __('Apply') }}"
                                    id="applyfilter" data-original-title="{{ __('apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="#!" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                    title="{{ __('Reset') }}" id="clearfilter"
                                    data-original-title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        {{ $dataTable->table(['width' => '100%']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
@endpush
