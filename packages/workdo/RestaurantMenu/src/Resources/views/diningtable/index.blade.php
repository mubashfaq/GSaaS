@extends('layouts.main')
@section('page-title')
    {{ __('Manage Dining Tabels') }}
@endsection
@push('css')
    @include('layouts.includes.datatable-css')
    <link rel="stylesheet" href="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/css/custom.css') }}" />

@endpush
@section('page-breadcrumb')
    {{ __('Dining Tabels') }}
@endsection
@section('page-action')
    <div>
        @permission('dining_table create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="{{ __('Create Dining Table') }}"
                data-url="{{ route('restaurant-dining-table.create') }}" data-toggle="tooltip" title="{{ __('Create') }}">
                <i class="ti ti-plus text-white"></i>
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
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
@endpush
