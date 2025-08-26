@extends('layouts.main')

@section('page-title')
    {{ __('Receive Products from Workspace') }}
@endsection

@section('page-breadcrumb')
    {{ __('Receive Products from Workspace') }}
@endsection

@push('css')
    <style>
        .product-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .product-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .product-card.selected {
            border-color: #4CAF50;
            background-color: #f8fff8;
        }
        
        .transfer-btn {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .transfer-btn:hover:not(:disabled) {
            background: linear-gradient(45deg, #45a049, #4CAF50);
            transform: translateY(-2px);
        }
        
        .transfer-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .form-section {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .empty-state svg {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            color: #ccc;
        }
        
        .select-all-container {
            padding: 8px 16px;
            background: #f8f9fa;
            border-radius: 6px;
        }
        
        .product-info {
            margin-bottom: 8px;
        }
        
        .product-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }
        
        .product-details {
            color: #666;
            font-size: 0.9em;
        }
        
        .product-quantity, .product-price {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .badge {
            font-size: 0.8em;
        }
        
        .card-header {
            border-bottom: 1px solid #e0e0e0;
            padding: 16px 20px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-received {
            background: #d4edda;
            color: #155724;
        }
    </style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        // Initialize select2 for warehouse dropdown
        if (typeof $.fn.select2 !== 'undefined') {
            $('.warehouse-select').select2({
                placeholder: 'Select a warehouse...',
                allowClear: true
            });
        }

        // Handle product checkbox selection
        $(document).on('change', '.product-checkbox:not(#select-all)', function () {
            const card = $(this).closest('.product-card');
            $(this).is(':checked') ? card.addClass('selected') : card.removeClass('selected');
            updateReceiveButton();
            updateSelectAllState();
        });

        // Handle "select all" checkbox
        $(document).on('change', '#select-all', function () {
            const isChecked = $(this).is(':checked');
            $('.product-checkbox:not(#select-all)').each(function () {
                $(this).prop('checked', isChecked).trigger('change');
            });
        });

        // Warehouse dropdown change
        $('.warehouse-select').on('change', function () {
            updateReceiveButton();
        });

        // Receive form submit
        $('#receive-form').on('submit', function (e) {
            e.preventDefault();

            const selectedProducts = $('.product-checkbox:not(#select-all):checked');
            const warehouseId = $('.warehouse-select').val();

            if (selectedProducts.length === 0) {
                return showToastMessage('Error', 'Please select at least one product to receive', 'error');
            }
            if (!warehouseId) {
                return showToastMessage('Error', 'Please select a warehouse', 'error');
            }

            $('.receive-btn').prop('disabled', true).html('<i class="ti ti-loader me-2"></i>Processing...');

            const formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function (response) {
                    if (response.html) {
                        // Show partial success with failed items
                        $('#result-container').html(response.response).show();
                        showToastMessage('Warning', response.message, 'warning');
                        resetForm();
                    } else {
                        // Complete success
                        showToastMessage('Success', response.message, 'success');
                        resetForm();
                        if (response.redirect) {
                            setTimeout(() => window.location.href = response.redirect, 1500);
                        }
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'Receive failed. Please try again.';
                    if (xhr.responseJSON?.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON?.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
                    }
                    showToastMessage('Error', errorMessage, 'error');
                    $('.receive-btn').prop('disabled', false).html('<i class="ti ti-check me-2"></i>Receive Products');
                }
            });
        });

        function updateReceiveButton() {
            const count = $('.product-checkbox:not(#select-all):checked').length;
            const warehouseSelected = $('.warehouse-select').val();
            const button = $('.receive-btn');

            if (count > 0 && warehouseSelected) {
                button.prop('disabled', false).html(`<i class="ti ti-check me-2"></i>Receive ${count} Product${count > 1 ? 's' : ''}`);
            } else {
                button.prop('disabled', true).html('<i class="ti ti-check me-2"></i>Select Products & Warehouse');
            }
        }

        function updateSelectAllState() {
            const total = $('.product-checkbox:not(#select-all)').length;
            const selected = $('.product-checkbox:not(#select-all):checked').length;
            const all = $('#select-all');

            all.prop('checked', selected === total);
            all.prop('indeterminate', selected > 0 && selected < total);
        }

        function resetForm() {
            $('.product-checkbox').prop('checked', false);
            $('.product-card').removeClass('selected');
            $('.warehouse-select').val('').trigger('change');
            $('#transfer_date').val('{{ date("Y-m-d") }}');
            $('#notes').val('');
            updateReceiveButton();
            updateSelectAllState();
        }

        function showToastMessage(title, message, type) {
            if (typeof window.show_toastr === 'function') {
                window.show_toastr(title, message, type);
            } else if (typeof show_toastr === 'function') {
                show_toastr(title, message, type);
            } else {
                alert(`${type === 'error' ? 'Error: ' : ''}${message}`);
                console.log(`${title}: ${message} (${type})`);
            }
        }

        updateReceiveButton();
        updateSelectAllState();
    });
</script>
@endpush

@section('page-action')
    <div class="d-flex">
        @stack('addButtonHook')
        <x-back-button route="{{ route('workspace-transfer.index') }}" />
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Result Container for partial success messages -->
        <div id="result-container" style="display: none;" class="mb-4"></div>
        
        <form id="receive-form" method="POST" action="{{ route('workspace-transfer.store-Receive-Product') }}">
            @csrf

            <!-- Warehouse Selection -->
            <div class="form-section mb-4">
                <div class="card-header bg-light">
                    <h5><i class="ti ti-building-warehouse me-2"></i> {{ __('Select Destination Warehouse') }}</h5>
                </div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <label for="warehouse" class="form-label">{{ __('Warehouse') }}</label>
                        <select name="warehouse_id" id="warehouse" class="form-control warehouse-select" required>
                            <option value="">{{ __('Select a warehouse...') }}</option>
                            @foreach($warehouses ?? [] as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="transfer_date" class="form-label">{{ __('Receive Date') }}</label>
                        <input type="date" name="transfer_date" id="transfer_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>

            <!-- Products Selection -->
            <div class="form-section mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5><i class="ti ti-package me-2"></i> {{ __('Select Products to Receive') }}</h5>
                    <div class="select-all-container">
                        <label class="d-flex align-items-center mb-0">
                            <input type="checkbox" id="select-all" class="form-check-input me-2">
                            <span class="fw-medium">{{ __('Select All Products') }}</span>
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($transfers as $transfer)
                        @if(!empty($transfer->id) && $transfer->status === 'pending')
                        <div class="product-card mb-3 p-3">
                            <div class="row align-items-center">
                                <div class="col-md-1">
                                    <label>
                                        <input type="checkbox" name="selected_products[]" value="{{ $transfer->id }}" class="product-checkbox">
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="product-info">
                                        <div class="product-name">{{ $transfer->name ?? 'N/A' }}</div>
                                        <div class="product-details">
                                            <span class="badge bg-secondary">ID: {{ $transfer->id }}</span>
                                            @if($transfer->sku)
                                                <span class="badge bg-info">SKU: {{ $transfer->sku }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="product-info">
                                        <div class="text-muted small">{{ __('Quantity') }}</div>
                                        <div class="product-quantity fw-medium">{{ $transfer->quantity ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="product-info">
                                        <div class="text-muted small">{{ __('Unit Price') }}</div>
                                        <div class="product-price">
                                            ${{ number_format($transfer->price ?? 0, 2) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="product-info">
                                        <div class="text-muted small">{{ __('Total Value') }}</div>
                                        <div class="product-price fw-bold">
                                            ${{ number_format(($transfer->quantity ?? 0) * ($transfer->price ?? 0), 2) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <span class="status-badge status-{{ $transfer->status ?? 'pending' }}">
                                        {{ ucfirst($transfer->status ?? 'pending') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <h3 class="text-lg fw-medium text-gray-900 mb-2">{{ __('No products available to receive') }}</h3>
                            <p class="text-muted mb-4">{{ __('There are no pending products available for receiving at the moment.') }}</p>
                            <a href="{{ route('workspace-transfer.index') }}" class="btn btn-primary">
                                <i class="ti ti-list me-2"></i>{{ __('View All Transfers') }}
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Receive Button and Notes -->
            <div class="form-section">
                <div class="card-body row">
                    <div class="col-md-8">
                        <label for="notes" class="form-label">{{ __('Receive Notes (Optional)') }}</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Add any notes about receiving these products..."></textarea>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn receive-btn w-100" disabled>
                            <i class="ti ti-check me-2"></i>{{ __('Select Products & Warehouse') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection