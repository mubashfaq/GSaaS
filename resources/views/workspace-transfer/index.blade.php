@extends('layouts.main')

@section('page-title')
    {{ __('Workspace Transfer') }}
@endsection

@section('page-breadcrumb')
    {{ __('Workspace Transfer') }}
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
    <!--<link rel="stylesheet" href="{{ asset('packages/workdo/Pos/src/Resources/assets/css/custom.css') }}">-->
    <style>
    .dataTables_filter input {
       padding: 0.575rem 1rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #293240;
    background-color: #ffffff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
        
    }
    
    
     .dataTables_wrapper .dataTables_paginate .paginate_button {
    margin: 2px;
    border-radius: 0.4rem;
    background-color: #fff;
    color: #6c757d !important;
    border: 1px solid #dee2e6;
    transition: all 0.3s;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #6f42c1;
        color: #fff !important;
        border-color: #6f42c1;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #6f42c1;
        color: white !important;
        border-color: #6f42c1;
    }
    
    #expiry-table_filter{
            margin-top: -25px;
    margin-bottom: 20px;
    }
    


    </style>
@endpush

@push('scripts')
    @include('layouts.includes.datatable-js')
    <script>
        $(document).ready(function() {
            // ✅ Initialize DataTable only ONCE
            $('#expiry-table').DataTable({
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "_MENU_ entries per page",
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                },
                pageLength: 25,
                initComplete: function() {
                    $('#expiry-table_filter input').attr('placeholder', 'Search...');
                }
            });

            // ✅ Optional: initialize select2 if present
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2();
            }

            // ✅ Optional: Copy link functionality
            $('.copy_link').click(function(e) {
                e.preventDefault();
                var copyText = $(this).attr('href');

                document.addEventListener('copy', function(e) {
                    e.clipboardData.setData('text/plain', copyText);
                    e.preventDefault();
                }, true);

                document.execCommand('copy');
                show_toastr('Success', 'Url copied to clipboard', 'success');
            });
        });

        // ✅ Toggle custom date fields
        function toggleCustomDateFields() {
            if ($('#period').val() === 'custom') {
                $('.custom-date').removeClass('d-none');
            } else {
                $('.custom-date').addClass('d-none');
            }
        }
    </script>
    <script>
        // $(document).ready(function() {
        //     // Initialize DataTable
        //     $('#expiry-table').DataTable({
        //         dom: '<"top"lf>rt<"bottom"ip><"clear">',
        //         language: {
        //             search: "",
        //             lengthMenu: "_MENU_ entries per page"
        //         },
        //         pageLength: 25,
        //         initComplete: function() {
        //             $('#expiry-table_filter input').attr('placeholder', 'Search...');
        //         }
        //     });

        //     // If you have select2 anywhere
        //     if (typeof $.fn.select2 !== 'undefined') {
        //         $('.select2').select2();
        //     }

        //     // Copy link functionality (optional)
        //     $('.copy_link').click(function(e) {
        //         e.preventDefault();
        //         var copyText = $(this).attr('href');

        //         document.addEventListener('copy', function(e) {
        //             e.clipboardData.setData('text/plain', copyText);
        //             e.preventDefault();
        //         }, true);

        //         document.execCommand('copy');
        //         show_toastr('Success', 'Url copied to clipboard', 'success');
        //     });
        // });

        function toggleCustomDateFields() {
            if ($('#period').val() === 'custom') {
                $('.custom-date').removeClass('d-none');
            } else {
                $('.custom-date').addClass('d-none');
            }
        }
    </script>
@endpush

@section('page-action')
    <!--<div class="d-flex">-->
    <!--    @stack('addButtonHook')-->
    <!--    <a href="{{ route('purchases.grid') }}" class="btn btn-sm btn-primary me-2" data-bs-toggle="tooltip" title="{{ __('Grid View') }}">-->
    <!--        <i class="ti ti-layout-grid text-white"></i>-->
    <!--    </a>-->
    <!--</div>-->
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5>{{ __('Workspace Transfer') }}</h5>
                <div class="float-end">
                    <a href="workspace-transfer/products" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> {{ __('') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="product-service-table_wrapper" class="table-responsive">
                <table class="table " id="expiry-table">
                    <thead>
                        <tr>
                            <th>{{ __('From(Current Workspace)') }}</th>
                            <th>{{ __('To(Workspace)') }}</th>
                            <th>{{ __('Total Products') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($transfers as $transfer)
                            @if(!empty($transfer->id)) <!-- Skip empty objects -->
                                <tr class="hover:bg-gray-50">
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div class="font-medium">{{ $transfer->from_workspace_name ?? 'N/A' }}</div>
                                            <div class="text-gray-500">{{ $transfer->from_warehouse_name ?? 'Warehouse #' . $transfer->from_warehouse }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div class="font-medium">{{ $transfer->to_workspace_name ?? 'N/A' }}</div>
                                            <div class="text-gray-500">{{ $transfer->to_warehouse_name ?? '' . $transfer->to_warehouse }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $transfer->total_quantity ?? '0' }}
                                           
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'approved' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'completed' => 'bg-green-100 text-green-800 border-green-200',
                                                'rejected' => 'bg-red-100 text-red-800 border-red-200'
                                            ];
                                            $statusClass = $statusClasses[$transfer->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusClass }}">
                                            {{ ucfirst($transfer->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($transfer->created_at)->format('M d, Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($transfer->created_at)->format('H:i') }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                         <div class="action-btn me-2">
                                                        <a href="{{ route('workspace-transfers.show', $transfer->id) }}"
                                                            class="mx-3 btn btn-sm align-items-center bg-warning"
                                                            data-bs-toggle="tooltip" title="{{ __('View') }}"
                                                            data-original-title="{{ __('Detail') }}">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                        
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No transfers found</h3>
                                        <p class="text-gray-500 mb-4">Get started by creating a new workspace transfer.</p>
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>    
@endsection
