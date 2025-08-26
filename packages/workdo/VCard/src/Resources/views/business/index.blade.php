@extends('layouts.main')
@section('page-title')
    {{ __('Manage Business') }}
@endsection
@section('page-breadcrumb')
    {{ __('Business') }}
@endsection
@section('page-action')
    <div class="d-flex">
        @stack('addButtonHook')
        @permission('business manage')
            <a href="{{ route('business.grid.view') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Grid View') }}"
                class="btn btn-sm btn-primary me-2">
                <i class="ti ti-layout-grid"></i>
            </a>
        @endpermission
        @permission('business create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="xl" data-title="{{ __('Create New Business') }}"
                data-url="{{ route('business.create') }}" data-toggle="tooltip" title="{{ __('Create') }}">
                <i class="ti ti-plus text-white"></i>
            </a>
        @endpermission
    </div>
@endsection
@push('css')
    @include('layouts.includes.datatable-css')
@endpush

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
    <script type="text/javascript">
        function copyToClipboard(element) {
            var value = $(element).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            toastrs('{{ __('Success') }}', '{{ __('Link Copy on Clipboard') }}', 'success');
        }
    </script>
@endpush
