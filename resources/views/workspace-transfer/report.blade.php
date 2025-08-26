@extends('layouts.main')

@section('page-title')
    {{ __('Workspace Transfer Report') }}
@endsection

@section('page-breadcrumb')
    {{ __('Workspace Transfer Report') }}
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
    <style>
        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: white;
            transition: transform 0.3s ease;
        }
        
        .summary-card:hover {
            transform: translateY(-5px);
        }
        
        .summary-card.from-card {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .summary-card.to-card {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .filter-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        
        .dataTables_filter input {
            padding: 0.575rem 1rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #293240;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            margin: 2px;
            border-radius: 0.4rem;
            background-color: #fff;
            color: #6c757d !important;
            border: 1px solid #dee2e6;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #6f42c1;
            color: #fff !important;
            border-color: #6f42c1;
        }
    </style>
@endpush

@push('scripts')
    @include('layouts.includes.datatable-js')
    <script>
        $(document).ready(function() {
            $('#report-table').DataTable({
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
                order: [[4, 'desc']], // Order by date desc
                initComplete: function() {
                    $('#report-table_filter input').attr('placeholder', 'Search...');
                }
            });

            // Handle From Workspace change
            $('#from_workspace').change(function() {
                var workspaceId = $(this).val();
                loadWarehouses(workspaceId, '#from_warehouse');
            });

            // Handle To Workspace change
            $('#to_workspace').change(function() {
                var workspaceId = $(this).val();
                loadWarehouses(workspaceId, '#to_warehouse');
            });

            // Load warehouses on page load if workspace is selected
            var selectedFromWorkspace = $('#from_workspace').val();
            var selectedToWorkspace = $('#to_workspace').val();
            
            if (selectedFromWorkspace) {
                loadWarehouses(selectedFromWorkspace, '#from_warehouse', '{{ request("from_warehouse") }}');
            }
            
            if (selectedToWorkspace) {
                loadWarehouses(selectedToWorkspace, '#to_warehouse', '{{ request("to_warehouse") }}');
            }
        });

        function loadWarehouses(workspaceId, targetSelector, selectedWarehouse = '') {
            var $target = $(targetSelector);
            
            if (!workspaceId) {
                $target.html('<option value="">Select Workspace First</option>');
                return;
            }

            // Show loading
            $target.html('<option value="">Loading...</option>');

            $.ajax({
                url: '{{ route("warehouses-transfer.getWarehousesByWorkspace") }}',
                type: 'POST',
                data: {
                    workspace_id: workspaceId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(warehouses) {
                    var options = '<option value="">All Warehouses</option>';
                    
                    $.each(warehouses, function(id, name) {
                        var selected = (selectedWarehouse == id) ? 'selected' : '';
                        options += '<option value="' + id + '" ' + selected + '>' + name + '</option>';
                    });
                    
                    $target.html(options);
                },
                error: function() {
                    $target.html('<option value="">Error loading warehouses</option>');
                }
            });
        }

        function clearFilters() {
            $('#filter-form')[0].reset();
            $('#from_warehouse').html('<option value="">Select Workspace First</option>');
            $('#to_warehouse').html('<option value="">Select Workspace First</option>');
            $('#filter-form').submit();
        }
    </script>
@endpush

@section('page-action')
    <div class="d-flex">
        <!--<a href="{{ route('workspace-transfer.index') }}" class="btn btn-sm btn-secondary me-2">-->
        <!--    <i class="ti ti-arrow-left"></i> {{ __('Back to Transfers') }}-->
        <!--</a>-->
        <!--<button type="button" class="btn btn-sm btn-primary" onclick="window.print()">-->
        <!--    <i class="ti ti-printer"></i> {{ __('Print Report') }}-->
        <!--</button>-->
    </div>
@endsection

@section('content')
<div class="row">
    <!-- Filter Section -->
    <div class="col-md-12 mb-4">
        <div class="card filter-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="ti ti-filter me-2"></i>{{ __('Filters') }}</h5>
            </div>
            <div class="card-body">
                <form id="filter-form" method="GET" action="{{ route('workspace-transfer.report') }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('From Workspace') }}</label>
                            <select name="from_workspace" id="from_workspace" class="form-control">
                                <option value="">{{ __('All Workspaces') }}</option>
                                @foreach($workspaces as $workspace)
                                    <option value="{{ $workspace->id }}" 
                                        {{ request('from_workspace') == $workspace->id ? 'selected' : '' }}>
                                        {{ $workspace->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('To Workspace') }}</label>
                            <select name="to_workspace" id="to_workspace" class="form-control">
                                <option value="">{{ __('All Workspaces') }}</option>
                                @foreach($workspaces as $workspace)
                                    <option value="{{ $workspace->id }}" 
                                        {{ request('to_workspace') == $workspace->id ? 'selected' : '' }}>
                                        {{ $workspace->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('From Warehouse') }}</label>
                            <select name="from_warehouse" id="from_warehouse" class="form-control">
                                <option value="">{{ __('Select Workspace First') }}</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('To Warehouse') }}</label>
                            <select name="to_warehouse" id="to_warehouse" class="form-control">
                                <option value="">{{ __('Select Workspace First') }}</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('Date From') }}</label>
                            <input type="date" name="date_from" class="form-control" 
                                value="{{ request('date_from') }}">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('Date To') }}</label>
                            <input type="date" name="date_to" class="form-control" 
                                value="{{ request('date_to') }}">
                        </div>
                        
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="ti ti-search me-1"></i>{{ __('Apply Filters') }}
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="clearFilters()">
                                <i class="ti ti-refresh me-1"></i>{{ __('Clear') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="col-md-12 mb-4">
        <div class="row">
            <!-- From Summary Card -->
            <div class="col-md-4 mb-3">
                <div class="card  ">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">
                                    <i class=" me-2"></i>{{ __('Total Products') }}
                                </h6>
                                <div class="row">
                                    
                                    <div class="col-12">
                                        <div class="mb-2">
                                           
                                            <h4 class="mb-0">{{ number_format($summary['from']['total_products']) }}</h4>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="text-end">
                                <i class="ti ti-building-warehouse" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- To Summary Card -->
            <div class="col-md-4 mb-3">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">
                                    <i class=" me-2"></i>{{ __('Total Quantity') }}
                                </h6>
                                <div class="row">
                                    
                                    <div class="col-12">
                                        <div class="mb-2">
                                          
                                            <h4 class="mb-0">{{ number_format($summary['to']['total_quantity']) }}</h4>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="text-end">
                                <i class="ti ti-building-store" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">
                                    <i class=" me-2"></i>{{ __('Total Value') }}
                                </h6>
                                <div class="row">
                                    <div class="col-12">
                                         <div class="mt-2">
                                   
                                    <h4 class="mb-0">${{ number_format($summary['to']['total_price'], 2) }}</h4>
                                </div>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="text-end">
                                <i class="ti ti-building-store" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Table -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5>{{ __('Transfer Report Details') }}</h5>
                    <div class="badge bg-primary">
                        {{ __('Total Transfers: ') . $summary['total_transfers'] }}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="report-table">
                        <thead>
                            <tr>
                                <th>{{ __('Transfer ID') }}</th>
                                <th>{{ __('From (Workspace/Warehouse)') }}</th>
                                <th>{{ __('To (Workspace/Warehouse)') }}</th>
                                <th>{{ __('Products/Quantity') }}</th>
                                <th>{{ __('Total Value') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transfers as $transfer)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">#{{ $transfer->id }}</span>
                                    </td>
                                    <td>
                                        <div class="text-sm">
                                            <div class="fw-bold">{{ $transfer->from_workspace_name }}</div>
                                            <small class="text-muted">{{ $transfer->from_warehouse_name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm">
                                            <div class="fw-bold">{{ $transfer->to_workspace_name }}</div>
                                            <small class="text-muted">{{ $transfer->to_warehouse_name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm">
                                            <span class="badge bg-info">{{ $transfer->product_count }} Products</span>
                                            <div class="mt-1">
                                                <small class="text-muted">Qty: {{ number_format($transfer->total_quantity) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">
                                            ${{ number_format($transfer->total_price, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-warning',
                                                'approved' => 'bg-info',
                                                'completed' => 'bg-success',
                                                'rejected' => 'bg-danger'
                                            ];
                                            $statusClass = $statusClasses[$transfer->status] ?? 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst($transfer->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-sm">
                                            <div>{{ \Carbon\Carbon::parse($transfer->created_at)->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($transfer->created_at)->format('H:i') }}</small>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="ti ti-inbox mb-2" style="font-size: 2rem;"></i>
                                            <h5>{{ __('No transfer records found') }}</h5>
                                            <p>{{ __('Try adjusting your filters to see more results.') }}</p>
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
</div>
@endsection