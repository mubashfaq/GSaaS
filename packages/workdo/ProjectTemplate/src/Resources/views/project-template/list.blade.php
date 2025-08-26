@extends('layouts.main')
@section('page-title')
    {{ __('Manage Project-Template') }}
@endsection
@section('page-breadcrumb')
    {{ __('Project Template') }}
@endsection
@section('page-action')
    <div>
        <a href="{{ route('project-template.index') }}" class="btn btn-sm btn-primary"
            data-bs-toggle="tooltip"title="{{ __('Grid View') }}">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
    </div>
@endsection
@push('css')
    @include('layouts.includes.datatable-css')
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive overflow_hidden">
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
