@extends('layouts.main')

@section('page-title')
    {{ __('Manage Shipping') }}
@endsection

@section('page-breadcrumb')
    {{ __('Shipping') }}
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css') }}"> --}}
@endpush
@push('scripts')
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
@endpush

@section('page-action')
    <div>
        @permission('consignment shipping create')
            <a class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}"
                data-ajax-popup="true" data-size="lg" data-title="{{ __('Create Shipping') }}"
                data-url="{{ route('consignment-shipping.create') }}"><i class="ti ti-plus text-white"></i></a>
        @endpermission
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h5></h5>
                    <div class="table-responsive">
                        {{ $dataTable->table(['width' => '100%']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
