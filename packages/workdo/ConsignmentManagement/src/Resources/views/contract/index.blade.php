@extends('layouts.main')
@section('page-title')
    {{ __('Manage Contract') }}
@endsection
@section('title')
    {{ __('Contract') }}
@endsection
@section('page-breadcrumb')
    {{ __('Contract') }}
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ConsignmentManagement/src/Resources/assets/css/custom.css') }}">
    @include('layouts.includes.datatable-css')
@endpush

@section('page-action')
<div>
    @permission('consignment contract create')
    <a data-size="" data-url="{{ route('consignment-contract.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
        data-title="{{ __('Create Contract') }}" title="{{ __('Create') }}"class="btn btn-sm btn-primary btn-icon">
        <i class="ti ti-plus"></i>
    </a>
@endpermission
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
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
<script src="{{ asset('packages/workdo/ConsignmentManagement/src/Resources/assets/js/custom.js') }}"></script>
@include('layouts.includes.datatable-js')
{{ $dataTable->scripts() }}
@endpush
