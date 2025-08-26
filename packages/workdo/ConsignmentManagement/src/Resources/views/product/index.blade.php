@extends('layouts.main')
@section('page-title')
    {{ __('Items') }}
@endsection
@section('page-breadcrumb')
    {{ __('Items') }}
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
        @stack('addButtonHook')
        @permission('consignment product create')
            <a href="{{ route('product-item.create', ['item_type' => 'consignment']) }}" class="btn btn-sm btn-primary btn-icon"
                data-bs-toggle="tooltip" data-bs-placement="top" data-title="{{ __('Create New Product') }}"
                title="{{ __('Create') }}"><i class="ti ti-plus text-white"></i></a>
        @endpermission
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
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

