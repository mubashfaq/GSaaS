@extends('layouts.main')
@section('page-title')
    {{__('Manage POS Order')}}
@endsection
@section('page-breadcrumb')
   {{__('POS Order')}}
@endsection
@push('css')
@include('layouts.includes.datatable-css')
<style>
.dataTable-top{
       display: flex;
    flex-direction: row;
    justify-items: end;
}
    .fbr-filter-container {
       display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 0px;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }
    
    .fbr-filter-container label {
        font-weight: 600;
        margin-bottom: 0;
        color: #495057;
        white-space: nowrap;
    }
    
    .fbr-filter-container select {
        min-width: 200px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .fbr-filter-container select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .badge {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
    }
    
    .bg-success {
        background-color: #28a745 !important;
        color: white;
    }
    
    .bg-secondary {
        background-color: #6c757d !important;
        color: white;
    }
</style>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        var filename = $('#filename').val();
        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();
        }
        
        // Additional JavaScript for FBR filter functionality
        $(document).ready(function() {
            // You can add additional custom filter logic here if needed
            console.log('FBR filter initialized');
            
            // Optional: Add event listener for filter changes
            $(document).on('change', '#fbr-filter', function() {
                var selectedValue = $(this).val();
                var selectedText = $(this).find('option:selected').text();
                console.log('FBR filter changed to:', selectedText);
                
                // You can add additional logic here if needed
                // For example, showing a loading indicator or custom messages
            });
        });
    </script>
@endpush
@section('page-action')
<div class="d-flex">
    @stack('addButtonHook')
    <a href="{{ route('pos.grid') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Grid View') }}">
        <i class="ti ti-layout-grid text-white"></i>
    </a>
</div>
@endsection
@section('content')
    <div id="printableArea">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            {{ $dataTable->table(['width' => '100%']) }}
                        </div>
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