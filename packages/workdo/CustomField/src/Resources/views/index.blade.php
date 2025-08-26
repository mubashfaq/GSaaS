@extends('layouts.main')
@section('page-title')
    {{ __('Manage Custom Field') }}
@endsection
@section('page-breadcrumb')
    {{ __('Custom Field') }}
@endsection
@push('css')
    @include('layouts.includes.datatable-css')
@endpush
@section('page-action')
    @permission('customfield create')
        <div class="float-end">
            <a href="#" data-url="{{ route('custom-field.create') }}" data-bs-toggle="tooltip" title="{{ __('Create') }}"
                data-ajax-popup="true" data-title="{{ __('Create New Custom Field') }}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    @endpermission
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
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
