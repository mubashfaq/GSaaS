@extends('layouts.main')

@section('page-title')
    {{ __('Manage Quality Control') }}
@endsection

@section('page-breadcrumb')
    {{ __('Quality Control') }}
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
@endpush
@push('scripts')
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
@endpush

@section('page-action')
    <div>
        @permission('consignment qualitycontrol create')
            <a class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}"
                data-ajax-popup="true" data-size="lg" data-title="{{ __('Create Quality Control') }}"
                data-url="{{ route('consignment-qualitycontrol.create') }}"><i class="ti ti-plus text-white"></i></a>
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
@push('scripts')
@endpush
