@php
    if ($id) {
        $currentBusiness = $id;
    } else {
        $currentBusiness = Workdo\VCard\Entities\Business::currentBusiness();
    }

@endphp
@extends('layouts.main')
@section('page-breadcrumb')
    {{ __('Contacts') }}
@endsection
@section('page-title')
    {{ __('Manage Contacts') }}
@endsection

@push('css')
<link rel="stylesheet" href="{{asset('packages/workdo/VCard/src/Resources/assets/custom/css/custom.css')}}">
@endpush
@section('page-action')
    <div class="d-flex align-items-center justify-content-end gap-2 ">
        @if (!$businessData->isempty())
            <ul class="all-button-box list-unstyled mt-1 m-2 form-control ">
                <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false" id="dropdownLanguage">
                        @foreach ($businessData as $key => $value)
                            <span
                                class="drp-text hide-mob text-primary">{{ $currentBusiness == $key ? Str::ucfirst($value) : '' }}</span>
                        @endforeach
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class="vcard-appointment-list dropdown-menu dash-h-dropdown dropdown-menu-end" aria-labelledby="dropdownLanguage">
                        @foreach ($businessData as $key => $business_val)
                            <a href="{{ route('business.current', $key) }}" class="dropdown-item">
                                <i class="@if ($currentBusiness == $key) ti ti-checks text-primary @endif "></i>
                                <span>{{ ucfirst($business_val) }}</span>
                            </a>
                        @endforeach
                    </div>
                </li>
            </ul>
        @endif
        @if (URL::previous() == URL::current())
            <a href="{{ route('contacts.index') }}" class="btn-submit btn btn-sm btn-primary " data-toggle="tooltip"
                title="{{ __('Back') }}">
                <i class=" ti ti-arrow-back-up"></i> </a>
        @else
            <a href="{{ url(URL::previous()) }}" class="btn-submit btn btn-sm btn-primary " data-toggle="tooltip"
                title="{{ __('Back') }}">
                <i class=" ti ti-arrow-back-up"></i> </a>
        @endif
    </div>
@endsection
@push('css')
    @include('layouts.includes.datatable-css')
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12">
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
