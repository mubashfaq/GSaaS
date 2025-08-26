@extends('layouts.main')

@section('page-title')
    {{ __('Manage Documents') }}
@endsection

@section('page-breadcrumb')
    {{ __('Documents') }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dragula.min.css') }}">
    <style>
        .comp-card {
            min-height: 140px;
        }
    </style>
@endpush

@php($taskly = module_is_active('Taskly'))
@push('css')
    @include('layouts.includes.datatable-css')
@endpush
@section('page-action')
    <div>
        @stack('addButtonHook')
        {{-- <a href="{{ route('document.grid') }}" class="btn btn-sm btn-primary"
            data-bs-toggle="tooltip"title="{{ __('Grid View') }}">
            <i class="ti ti-layout-grid text-white"></i>
        </a> --}}
        @permission('documents create')
            <a data-url="{{ route('documents.create') }}" data-size="lg" data-ajax-popup="true"
                data-bs-toggle="tooltip"data-title="{{ __('Create New Document') }}" title="{{ __('Create') }}"
                class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header card-body table-border-style">
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
