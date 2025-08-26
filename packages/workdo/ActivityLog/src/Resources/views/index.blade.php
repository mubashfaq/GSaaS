@php
    $creatorId = creatorId();
@endphp

@extends('layouts.main')
@section('page-title')
    {{ __('Manage Activity Log') }}
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
@endpush
@section('page-breadcrumb')
    {{ __('Activity Log') }}
@endsection

@section('page-action')
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class=" multi-collapse mt-2" id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex align-items-center justify-content-end">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    <label for="staff">{{ __('Staff') }}</label>
                                    <select class="form-control staff " name="staff" id="staff" tabindex="-1"
                                        aria-hidden="true">
                                        <option value="">{{ __('Select staff') }}</option>
                                        @foreach ($staffs as $staff)
                                            @if ($staff->id == $creatorId)
                                                <span class="badge bg-dark"> {{ Auth::user()->roles->first()->name }}</span>
                                            @else
                                                <span class="badge bg-dark"> {{ __('') }}</span>
                                            @endif
                                            <option value="{{ $staff->id }}">
                                                {{ $staff->name }}@if ($staff->id == $creatorId)
                                                    <span class="badge bg-dark">
                                                        {{'('. $staff->type.')' }}</span>
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    <label for="filter">{{ __('Add-on') }}</label>
                                    <select class="form-control modules " name="filter" id="module" tabindex="-1"
                                        aria-hidden="true">
                                        @foreach ($modules as $key => $module)
                                            <option value="{{ $key }}">
                                                {{ $module === 'Beverage' ? 'Manufacture' : $module }}
                                                <!--{{ $module }}-->
                                                </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div class="col-auto">
                                        <a  class="btn btn-sm btn-primary me-1"
                                            data-bs-toggle="tooltip" title="{{ __('Apply') }}" id="applyfilter"
                                            data-original-title="{{ __('apply') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="#!" class="btn btn-sm btn-danger"
                                            data-bs-toggle="tooltip" title="{{ __('Reset') }}" id="clearfilter"
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
        </div>

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
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
@endpush